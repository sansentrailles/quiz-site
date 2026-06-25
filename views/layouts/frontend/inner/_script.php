<script>
(function() {
  const routeData = JSON.parse(document.body.dataset.route);
  const points = routeData.points.map(function(p) {
    return {
      latitude: parseFloat(p.latitude),
      longitude: parseFloat(p.longitude),
      title: p.title,
      message: p.message
    };
  });
  const arrivalRadius = routeData.arrival_radius || 30;
  const routeTitle = routeData.title || 'Маршрут';

  document.getElementById('routeTitle').textContent = routeTitle;

  var currentPointIndex = 0;
  var currentLat = null;
  var currentLng = null;
  var currentHeading = null;
  var currentAccuracy = null;
  var gpsReady = false;
  var headingReady = false;
  var hasArrived = false;
  var arrivalDismissed = false;
  var watchId = null;

  class KalmanFilter {
    constructor(pn, mn) {
      this.processNoise = pn || 0.00001;
      this.measurementNoise = mn || 0.0005;
      this.estimate = null;
      this.errorCovariance = 1;
    }
    filter(val) {
      if (this.estimate === null) {
        this.estimate = val;
        return val;
      }
      var pred = this.estimate;
      var predErr = this.errorCovariance + this.processNoise;
      var gain = predErr / (predErr + this.measurementNoise);
      this.estimate = pred + gain * (val - pred);
      this.errorCovariance = (1 - gain) * predErr;
      return this.estimate;
    }
  }

  class AngleFilter {
    constructor(s) {
      this.smoothing = s || 0.25;
      this.angle = null;
    }
    filter(a) {
      if (this.angle === null) { this.angle = a; return a; }
      var diff = a - this.angle;
      while (diff > 180) diff -= 360;
      while (diff < -180) diff += 360;
      this.angle += diff * this.smoothing;
      while (this.angle < 0) this.angle += 360;
      while (this.angle >= 360) this.angle -= 360;
      return this.angle;
    }
  }

  var latFilter = new KalmanFilter(0.00001, 0.0005);
  var lngFilter = new KalmanFilter(0.00001, 0.0005);
  var headingFilter = new AngleFilter(0.25);

  function calcDist(la1, lo1, la2, lo2) {
    var R = 6371000;
    var dLat = (la2 - la1) * Math.PI / 180;
    var dLo = (lo2 - lo1) * Math.PI / 180;
    var a = Math.sin(dLat/2) ** 2 +
            Math.cos(la1*Math.PI/180) * Math.cos(la2*Math.PI/180) *
            Math.sin(dLo/2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  }

  function calcBearing(la1, lo1, la2, lo2) {
    var p1 = la1*Math.PI/180, p2 = la2*Math.PI/180;
    var dl = (lo2-lo1)*Math.PI/180;
    var y = Math.sin(dl)*Math.cos(p2);
    var x = Math.cos(p1)*Math.sin(p2) - Math.sin(p1)*Math.cos(p2)*Math.cos(dl);
    return (Math.atan2(y,x)*180/Math.PI + 360) % 360;
  }

  function fmtDist(d) {
    return d >= 1000 ? (d/1000).toFixed(2) + ' км' : Math.round(d) + ' м';
  }

  function fmtTime(d) {
    return d.toLocaleTimeString('ru-RU', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
  }

  var arrowWrapper = document.getElementById('arrowWrapper');
  var compassCardinals = document.getElementById('compassCardinals');
  var distanceValue = document.getElementById('distanceValue');
  var distanceUnit = document.getElementById('distanceUnit');
  var coordsDisplay = document.getElementById('coordsDisplay');
  var headingInfo = document.getElementById('headingInfo');
  var statusDot = document.getElementById('statusDot');
  var statusText = document.getElementById('statusText');
  var arrivalOverlay = document.getElementById('arrivalOverlay');
  var arrivalBtn = document.getElementById('arrivalBtn');
  var arrivalPointName = document.getElementById('arrivalPointName');
  var arrivalMessage = document.getElementById('arrivalMessage');
  var arrivalDistance = document.getElementById('arrivalDistance');
  var arrivalAccuracy = document.getElementById('arrivalAccuracy');
  var arrivalTime = document.getElementById('arrivalTime');
  var arrivalIcon = document.getElementById('arrivalIcon');
  var pointsList = document.getElementById('pointsList');
  var currentTargetName = document.getElementById('currentTargetName');
  var httpsWarning = document.getElementById('httpsWarning');
  var currentUrlEl = document.getElementById('currentUrl');
  var progressFill = document.getElementById('progressFill');
  var progressLabel = document.getElementById('progressLabel');
  var glowRing = document.getElementById('glowRing');
  var glowFilter = document.getElementById('glow');

  function checkSecureContext() {
    if (window.isSecureContext === false) {
      currentUrlEl.textContent = window.location.href;
      httpsWarning.classList.add('visible');
      statusDot.className = 'status-dot error';
      statusText.textContent = 'Нет HTTPS — GPS недоступен';
      return false;
    }
    var p = window.location.protocol;
    var isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.hostname === '';
    if (p !== 'https:' && p !== 'file:' && !isLocal) {
      currentUrlEl.textContent = window.location.href;
      httpsWarning.classList.add('visible');
      statusDot.className = 'status-dot error';
      statusText.textContent = 'Требуется HTTPS';
      return false;
    }
    return true;
  }

  function initPointsList() {
    pointsList.innerHTML = '';
    points.forEach(function(p, i) {
      var el = document.createElement('div');
      el.className = 'point-item';
      el.id = 'point-' + i;
      el.innerHTML = '<span class="point-number">' + (i+1) + '.</span>' +
        '<span class="point-title">' + p.title + '</span>' +
        '<span class="point-distance" id="point-dist-' + i + '">—</span>';
      pointsList.appendChild(el);
    });
    updatePointsList();
  }

  function updatePointsList() {
    points.forEach(function(p, i) {
      var el = document.getElementById('point-' + i);
      var distEl = document.getElementById('point-dist-' + i);
      el.classList.remove('active', 'completed');
      if (i < currentPointIndex) {
        el.classList.add('completed');
        distEl.textContent = '✓';
      } else if (i === currentPointIndex) {
        el.classList.add('active');
        if (currentLat !== null) {
          distEl.textContent = fmtDist(calcDist(currentLat, currentLng, p.latitude, p.longitude));
        }
      } else {
        distEl.textContent = '—';
      }
    });
    currentTargetName.textContent = points[currentPointIndex] ? points[currentPointIndex].title : '—';
  }

  function updateProgressBar() {
    var total = points.length;
    var completed = currentPointIndex;
    var pct = total > 0 ? (completed / total) * 100 : 0;
    progressFill.style.width = pct + '%';
    progressLabel.textContent = completed + ' / ' + total + ' точек пройдено';
    if (completed > 0 && completed < total) {
      progressFill.classList.add('active');
    } else {
      progressFill.classList.remove('active');
    }
  }

  function updateArrowGlow(distance) {
    var maxDist = 200;
    var proximity = Math.max(0, 1 - distance / maxDist);
    proximity = Math.min(1, proximity);

    var blurMin = 2;
    var blurMax = 14;
    var blur = blurMin + (blurMax - blurMin) * proximity;

    if (glowFilter) {
      glowFilter.querySelector('feGaussianBlur').setAttribute('stdDeviation', blur.toFixed(1));
    }

    var shadowAlpha = 0.2 + 0.6 * proximity;
    var shadowSize = 15 + 35 * proximity;
    arrowWrapper.style.filter = 'drop-shadow(0 0 ' + shadowSize.toFixed(0) + 'px rgba(255, 80, 80, ' + shadowAlpha.toFixed(2) + '))';

    var ringAlpha = 0.05 + 0.25 * proximity;
    var ringSize = 10 + 40 * proximity;
    glowRing.style.boxShadow = '0 0 ' + ringSize.toFixed(0) + 'px rgba(255, 80, 80, ' + ringAlpha.toFixed(2) + '), inset 0 0 ' + ringSize.toFixed(0) + 'px rgba(255, 80, 80, ' + (ringAlpha*0.5).toFixed(2) + ')';
  }

  function resetArrowGlow() {
    if (glowFilter) {
      glowFilter.querySelector('feGaussianBlur').setAttribute('stdDeviation', '3');
    }
    arrowWrapper.style.filter = '';
    glowRing.style.boxShadow = '';
  }
    var colors = ['#4ade80', '#22c55e', '#86efac', '#ffffff', '#fbbf24'];
    for (var i = 0; i < 40; i++) {
      var c = document.createElement('div');
      c.className = 'confetti';
      c.style.left = Math.random()*100 + '%';
      c.style.background = colors[Math.floor(Math.random()*colors.length)];
      c.style.animationDelay = (Math.random()*1.5) + 's';
      c.style.animationDuration = (2+Math.random()*2) + 's';
      c.style.width = (6+Math.random()*8) + 'px';
      c.style.height = c.style.width;
      c.style.borderRadius = Math.random()>0.5 ? '50%' : '2px';
      arrivalOverlay.appendChild(c);
      setTimeout(function(el){ el.remove(); }, 4500, c);
    }
  }

  function showArrival(distance) {
    var cp = points[currentPointIndex];
    arrivalPointName.textContent = cp.title;
    arrivalMessage.textContent = cp.message;
    arrivalDistance.textContent = distance.toFixed(1) + ' м';
    arrivalAccuracy.textContent = currentAccuracy ? currentAccuracy.toFixed(1) + ' м' : '—';
    arrivalTime.textContent = fmtTime(new Date());
    var isLast = currentPointIndex === points.length - 1;
    arrivalBtn.textContent = isLast ? 'ЗАВЕРШИТЬ' : 'ПРОДОЛЖИТЬ';
    arrivalBtn.className = 'arrival-btn' + (isLast ? ' finish' : '');
    arrivalIcon.textContent = isLast ? '🏆' : '🎯';
    arrivalOverlay.classList.add('visible');
    spawnConfetti();
    resetArrowGlow();
    if (navigator.vibrate) navigator.vibrate([200,100,200,100,400]);
  }

  function hideArrival() {
    arrivalOverlay.classList.remove('visible');
    arrivalDismissed = true;
  }

  function goToNext() {
    currentPointIndex++;
    hasArrived = false;
    arrivalDismissed = false;
    document.body.classList.remove('arrived');
    hideArrival();
    updatePointsList();
  }

  arrivalBtn.addEventListener('click', function() {
    if (currentPointIndex < points.length - 1) {
      goToNext();
    } else {
      hideArrival();
      document.body.classList.remove('arrived');
      statusText.textContent = 'Маршрут завершен!';
      statusDot.className = 'status-dot';
    }
  });

  function checkArrival(distance) {
    if (distance <= arrivalRadius && !hasArrived) {
      hasArrived = true;
      arrivalDismissed = false;
      document.body.classList.add('arrived');
      showArrival(distance);
    } else if (distance > arrivalRadius && hasArrived) {
      hasArrived = false;
      arrivalDismissed = false;
      document.body.classList.remove('arrived');
      arrivalOverlay.classList.remove('visible');
    }
  }

  function updateUI() {
    if (currentLat === null || currentLng === null || !points[currentPointIndex]) return;
    var cp = points[currentPointIndex];
    var distance = calcDist(currentLat, currentLng, cp.latitude, cp.longitude);

    if (distance >= 1000) {
      distanceValue.textContent = (distance/1000).toFixed(2);
      distanceUnit.textContent = 'км';
    } else {
      distanceValue.textContent = Math.round(distance);
      distanceUnit.textContent = 'м';
    }

    coordsDisplay.textContent = currentLat.toFixed(6) + '°, ' + currentLng.toFixed(6) + '°';

    if (currentHeading !== null) {
      compassCardinals.style.transform = 'rotate(' + (-currentHeading) + 'deg)';
      var bearing = calcBearing(currentLat, currentLng, cp.latitude, cp.longitude);
      if (distance <= arrivalRadius) {
        arrowWrapper.style.transform = 'rotate(0deg)';
      } else {
        var arrowAngle = bearing - currentHeading;
        while (arrowAngle > 180) arrowAngle -= 360;
        while (arrowAngle < -180) arrowAngle += 360;
        arrowWrapper.style.transform = 'rotate(' + arrowAngle + 'deg)';
      }
      headingInfo.textContent = 'Курс: ' + Math.round(currentHeading) + '° | Азимут: ' + Math.round(bearing) + '°';
    } else {
      headingInfo.textContent = 'Курс: ожидание компаса...';
    }

    updatePointsList();
    updateProgressBar();
    updateArrowGlow(distance);
    checkArrival(distance);
    updateStatus();
  }

  function updateStatus() {
    if (hasArrived) {
      statusDot.className = 'status-dot';
      statusText.textContent = '✓ Точка "' + points[currentPointIndex].title + '" достигнута';
      return;
    }
    if (!gpsReady && !headingReady) {
      statusDot.className = 'status-dot pending';
      statusText.textContent = 'Ожидание GPS и компаса...';
    } else if (gpsReady && !headingReady) {
      statusDot.className = 'status-dot pending';
      statusText.textContent = 'GPS ✓ | Ожидание компаса...';
    } else if (!gpsReady && headingReady) {
      statusDot.className = 'status-dot pending';
      statusText.textContent = 'Компас ✓ | Ожидание GPS...';
    } else {
      statusDot.className = 'status-dot';
      statusText.textContent = 'Наведение на "' + points[currentPointIndex].title + '"';
    }
  }

  function handlePosition(pos) {
    var rawLat = pos.coords.latitude;
    var rawLng = pos.coords.longitude;
    currentLat = latFilter.filter(rawLat);
    currentLng = lngFilter.filter(rawLng);
    currentAccuracy = pos.coords.accuracy;
    gpsReady = true;
    updateUI();
  }

  function handleGeoError(err) {
    statusDot.className = 'status-dot error';
    if (err.code === 1) statusText.textContent = 'Доступ к геолокации запрещён';
    else if (err.code === 2) statusText.textContent = 'Геолокация недоступна';
    else if (err.code === 3) statusText.textContent = 'Таймаут GPS';
    else statusText.textContent = 'Ошибка GPS';
  }

  var geoOptions = { enableHighAccuracy: true, timeout: 30000, maximumAge: 5000 };

  function startGPS() {
    if (!('geolocation' in navigator)) {
      statusDot.className = 'status-dot error';
      statusText.textContent = 'Геолокация не поддерживается';
      return;
    }
    statusDot.className = 'status-dot pending';
    statusText.textContent = 'Запрос доступа к GPS...';
    navigator.geolocation.getCurrentPosition(
      function(pos) {
        handlePosition(pos);
        if (watchId === null) {
          watchId = navigator.geolocation.watchPosition(handlePosition, handleGeoError, geoOptions);
        }
      },
      function(err) {
        handleGeoError(err);
        if (watchId === null) {
          watchId = navigator.geolocation.watchPosition(handlePosition, handleGeoError, geoOptions);
        }
      },
      geoOptions
    );
  }

  var usingAbsoluteOrientation = false;
  var iosOrientationRequested = false;

  function handleOrientationAbs(ev) {
    if (typeof ev.alpha !== 'number') return;
    usingAbsoluteOrientation = true;
    var h = (360 - ev.alpha) % 360;
    if (!isNaN(h)) {
      currentHeading = headingFilter.filter(h);
      headingReady = true;
      updateUI();
    }
  }

  function handleOrientation(ev) {
    var h = null;
    if (typeof ev.webkitCompassHeading === 'number') {
      h = ev.webkitCompassHeading;
    } else if (usingAbsoluteOrientation) {
      return;
    } else if (typeof ev.alpha === 'number') {
      h = (360 - ev.alpha) % 360;
    }
    if (h !== null && !isNaN(h)) {
      currentHeading = headingFilter.filter(h);
      headingReady = true;
      updateUI();
    }
  }

  function startCompass() {
    window.addEventListener('deviceorientationabsolute', handleOrientationAbs, true);
    window.addEventListener('deviceorientation', handleOrientation, true);
    if (typeof DeviceOrientationEvent !== 'undefined' &&
        typeof DeviceOrientationEvent.requestPermission === 'function') {
      var reqIOS = function() {
        if (iosOrientationRequested) return;
        iosOrientationRequested = true;
        DeviceOrientationEvent.requestPermission().catch(function(){});
      };
      document.addEventListener('click', reqIOS, { once: true });
      document.addEventListener('touchstart', reqIOS, { once: true });
    }
  }

  window.addEventListener('load', function() {
    initPointsList();
    if (!checkSecureContext()) return;
    startGPS();
    startCompass();
  });

  var lastTouchEnd = 0;
  document.addEventListener('touchend', function(e) {
    var now = Date.now();
    if (now - lastTouchEnd <= 300) e.preventDefault();
    lastTouchEnd = now;
  }, false);
})();
</script>