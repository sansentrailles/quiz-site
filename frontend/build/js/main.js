/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./frontend/js/modules/booking.js"
/*!****************************************!*\
  !*** ./frontend/js/modules/booking.js ***!
  \****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initBooking: () => (/* binding */ initBooking)
/* harmony export */ });
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function initBooking() {
  var modal = document.getElementById('signupModal');
  var openBtn = document.getElementById('openSignupModal');
  var closeBtn = document.getElementById('closeModal');
  var form = document.getElementById('quizForm');
  var submitBtn = document.getElementById('submitBtn');
  var toast = document.getElementById('successToast');

  // Открытие модального окна
  openBtn.addEventListener('click', function () {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Блокировка прокрутки фона
  });

  // Закрытие модального окна
  var closeModal = function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
    clearErrors();
  };
  closeBtn.addEventListener('click', closeModal);

  // Закрытие по клику на фон
  window.addEventListener('click', function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Очистка ошибок
  function clearErrors() {
    var inputs = form.querySelectorAll('input, select');
    var errorMessages = form.querySelectorAll('.error-message');
    inputs.forEach(function (input) {
      return input.classList.remove('error');
    });
    errorMessages.forEach(function (msg) {
      msg.style.display = 'none';
      msg.querySelector('span').textContent = '';
    });
  }

  // Отображение ошибки под конкретным полем
  function showFieldError(fieldId, message) {
    var input = document.getElementById(fieldId);
    var errorContainer = document.getElementById("error-".concat(fieldId));
    if (input && errorContainer) {
      input.classList.add('error');
      errorContainer.querySelector('span').textContent = message;
      errorContainer.style.display = 'flex';
    }
  }

  // Показать уведомление об успехе
  function showToast() {
    toast.classList.add('toast--show');
    setTimeout(function () {
      toast.classList.remove('toast--show');
    }, 4000);
  }

  // Обработка отправки формы
  form.addEventListener('submit', /*#__PURE__*/function () {
    var _ref = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee(e) {
      var formData, originalBtnText, response, _i, _Object$entries, _Object$entries$_i, field, message, _t;
      return _regenerator().w(function (_context) {
        while (1) switch (_context.p = _context.n) {
          case 0:
            e.preventDefault();

            // Очистка предыдущих ошибок
            clearErrors();

            // Сбор данных
            formData = {
              name: document.getElementById('name').value.trim(),
              teamName: document.getElementById('teamName').value.trim(),
              contact: document.getElementById('contact').value.trim(),
              quantity: document.getElementById('quantity').value,
              occasion: document.getElementById('occasion').value.trim(),
              flags: {
                joinTeam: document.getElementById('joinTeam').checked,
                solo: document.getElementById('solo').checked
              }
            }; // Блокировка кнопки
            originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
            submitBtn.disabled = true;
            _context.p = 1;
            _context.n = 2;
            return mockApiSubmit(formData);
          case 2:
            response = _context.v;
            if (response.success) {
              // Успех
              closeModal();
              showToast();
              form.reset();
            } else if (response.errors) {
              // Ошибка валидации от сервера
              // Проходим по объекту ошибок и выводим их
              for (_i = 0, _Object$entries = Object.entries(response.errors); _i < _Object$entries.length; _i++) {
                _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2), field = _Object$entries$_i[0], message = _Object$entries$_i[1];
                showFieldError(field, message);
              }
            }
            _context.n = 4;
            break;
          case 3:
            _context.p = 3;
            _t = _context.v;
            console.error(_t);
            alert('Произошла системная ошибка. Попробуйте позже.');
          case 4:
            _context.p = 4;
            // Разблокировка кнопки
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            return _context.f(4);
          case 5:
            return _context.a(2);
        }
      }, _callee, null, [[1, 3, 4, 5]]);
    }));
    return function (_x) {
      return _ref.apply(this, arguments);
    };
  }());
}

/**
 * Функция-имитатор API запроса
 * Возвращает Promise с ответом сервера
 */
function mockApiSubmit(data) {
  return new Promise(function (resolve) {
    setTimeout(function () {
      console.log("Отправка данных на сервер:", data);

      // ЛОГИКА ТЕСТИРОВАНИЯ ОШИБОК:
      // 1. Если контакт содержит слово "ошибка", возвращаем ошибку валидации для контакта
      // 2. Если имя короче 3 символов, ошибка для имени
      // 3. Иначе успех

      var errors = {};
      if (data.contact.length < 5) {
        errors.contact = 'Контакт слишком короткий';
      }
      if (data.contact.includes('error')) {
        errors.contact = 'Некорректный формат номера';
      }
      if (data.name.length < 2) {
        errors.name = 'Введите настоящее имя';
      }

      // Если есть ошибки, возвращаем failure
      if (Object.keys(errors).length > 0) {
        resolve({
          success: false,
          errors: errors
        });
      } else {
        // Иначе успех
        resolve({
          success: true,
          message: 'Заявка успешно создана'
        });
      }
    }, 1000); // Задержка 1 секунда
  });
}

/***/ },

/***/ "./frontend/js/modules/common.js"
/*!***************************************!*\
  !*** ./frontend/js/modules/common.js ***!
  \***************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initCommon: () => (/* binding */ initCommon)
/* harmony export */ });
// frontend/js/modules/common.js

// Экспортируем функцию инициализации
function initCommon() {
  // Логика для FAQ
  var firstFaq = document.querySelector('.faq-item');
  if (firstFaq) {
    firstFaq.classList.add('active');
  }

  // Навешиваем клики на FAQ items (делегирование или прямой перебор)
  var faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(function (item) {
    // Предполагаем, что у вас есть кнопка или заголовок внутри, на который нужно кликать.
    // Если вы кликали на весь item, оставим так, но лучше уточнить селектор кнопки.
    item.addEventListener('click', function () {
      // // Закрываем другие (опционально)
      // faqItems.forEach(i => {
      //     if (i !== this) i.classList.remove('active');
      // });
      this.classList.toggle('active');
    });
  });

  // Плавная прокрутка
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (href !== '#' && href.startsWith('#')) {
        e.preventDefault();
        var targetId = href.substring(1);
        var targetElement = document.getElementById(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 100,
            behavior: 'smooth'
          });
        }
      }
    });
  });
}

/***/ },

/***/ "./frontend/js/modules/map.js"
/*!************************************!*\
  !*** ./frontend/js/modules/map.js ***!
  \************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initMap: () => (/* binding */ initMap)
/* harmony export */ });
// frontend/js/modules/map.js

function initMap() {
  var mapModal = document.getElementById('map-modal');
  var showMapButton = document.getElementById('show-map');

  // Если элементов нет на этой странице, выходим
  if (!mapModal || !showMapButton) return;
  var map;
  var mapInitialized = false;
  var barCoordinates = [mapModal.dataset.latitude, mapModal.dataset.longitude];

  // Функция инициализации карты
  function initYandexMap() {
    if (mapInitialized) return;

    // Проверяем, загрузилась ли библиотека Yandex
    if (typeof ymaps === 'undefined') {
      console.error('Yandex Maps API не загружен');
      return;
    }
    ymaps.ready(function () {
      map = new ymaps.Map('modal-map-container', {
        center: barCoordinates,
        zoom: 16,
        controls: ['zoomControl', 'fullscreenControl']
      });
      var myPlacemark = new ymaps.Placemark(barCoordinates, {
        balloonContent: 'Бар "Пинта"<br>ул. Покровка, 15<br>Москва, 105062'
      }, {
        preset: 'islands#blueBeerIcon',
        iconColor: '#3a7bd5'
      });
      map.geoObjects.add(myPlacemark);
      mapInitialized = true;
    });
  }

  // Обработчики событий
  var closeMapModal = document.getElementById('close-map-modal');
  showMapButton.addEventListener('click', function (e) {
    e.preventDefault();
    mapModal.style.display = 'flex';
    if (!mapInitialized) {
      setTimeout(initYandexMap, 100);
    } else {
      map.container.fitToViewport();
    }
  });
  if (closeMapModal) {
    closeMapModal.addEventListener('click', function () {
      mapModal.style.display = 'none';
    });
  }
  mapModal.addEventListener('click', function (e) {
    if (e.target === mapModal) {
      mapModal.style.display = 'none';
    }
  });
  window.addEventListener('resize', function () {
    if (mapInitialized && mapModal.style.display === 'flex') {
      setTimeout(function () {
        map.container.fitToViewport();
      }, 200);
    }
  });
}

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!*****************************!*\
  !*** ./frontend/js/main.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/common */ "./frontend/js/modules/common.js");
/* harmony import */ var _modules_map__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/map */ "./frontend/js/modules/map.js");
/* harmony import */ var _modules_booking__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/booking */ "./frontend/js/modules/booking.js");
// frontend/js/main.js





// Используем одно событие DOMContentLoaded для запуска всего
document.addEventListener('DOMContentLoaded', function () {
  // Инициализируем общие скрипты
  (0,_modules_common__WEBPACK_IMPORTED_MODULE_0__.initCommon)();

  // Инициализируем карту
  (0,_modules_map__WEBPACK_IMPORTED_MODULE_1__.initMap)();

  // Форма записи
  (0,_modules_booking__WEBPACK_IMPORTED_MODULE_2__.initBooking)();

  // В будущем здесь будут появляться новые импорты, например:
  // import { initSlider } from './modules/slider';
  // initSlider();
});
})();

/******/ })()
;
//# sourceMappingURL=main.js.map