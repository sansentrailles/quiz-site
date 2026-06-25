<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    -webkit-user-select: none;
    user-select: none;
  }

  html, body {
    width: 100%;
    height: 100%;
    overflow: hidden;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  body {
    background: radial-gradient(circle at center, #1a1f3a 0%, #0a0e1f 100%);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    position: relative;
    transition: background 0.6s ease;
  }

  body.arrived {
    background: radial-gradient(circle at center, #1a3a2a 0%, #0a1f14 100%);
  }

  .stars {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    opacity: 0.4;
  }

  #config-data { display: none; }

  .top-panel {
    width: 100%;
    max-width: 500px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .route-title {
    font-size: 0.8em;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #8a94c7;
    text-align: center;
  }

  .progress-bar-wrap {
    width: 100%;
    height: 6px;
    background: rgba(255,255,255,0.08);
    border-radius: 3px;
    overflow: hidden;
    position: relative;
  }

  .progress-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #6ea8ff, #4ade80);
    border-radius: 3px;
    transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
    position: relative;
  }

  .progress-bar-fill::after {
    content: '';
    position: absolute;
    right: 0;
    top: -2px;
    width: 10px;
    height: 10px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 0 10px #4ade80, 0 0 20px rgba(74,222,128,0.5);
    opacity: 0;
    transition: opacity 0.3s;
  }

  .progress-bar-fill.active::after {
    opacity: 1;
  }

  .progress-label {
    font-size: 0.65em;
    color: #6ea8ff;
    text-align: right;
    margin-top: 2px;
    font-family: 'Courier New', monospace;
  }

  .current-target {
    text-align: center;
  }

  .current-target-row {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .current-target-label {
    font-size: 0.85em;
    color: #8a94c7;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .current-target-name {
    font-size: 1.3em;
    font-weight: 700;
    color: #6ea8ff;
  }

  body.arrived .current-target-name {
    color: #4ade80;
  }

  .distance {
    font-size: 3em;
    font-weight: 200;
    line-height: 1;
    background: linear-gradient(135deg, #ffffff 0%, #6ea8ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: all 0.6s ease;
    text-align: center;
    margin-top: 6px;
  }

  body.arrived .distance {
    background: linear-gradient(135deg, #ffffff 0%, #4ade80 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: arrivedPulse 2s ease-in-out infinite;
  }

  @keyframes arrivedPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }

  .distance-unit {
    font-size: 0.35em;
    color: #8a94c7;
    margin-left: 5px;
    vertical-align: middle;
  }

  .coords {
    font-size: 0.75em;
    color: #6ea8ff;
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
    text-align: center;
  }

  .points-list {
    display: flex;
    flex-direction: column;
    gap: 3px;
    align-self: flex-start;
    margin-left: 10px;
    margin-top: 4px;
  }

  .point-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 2px 6px;
    font-family: 'Courier New', monospace;
    font-size: 0.75em;
    letter-spacing: 1px;
    color: #6ea8ff;
    opacity: 0.5;
    transition: all 0.3s ease;
  }

  .point-item.active {
    opacity: 1;
    font-weight: 700;
    color: #6ea8ff;
    text-shadow: 0 0 10px rgba(110, 168, 255, 0.6);
  }

  .point-item.completed {
    color: #4ade80;
    opacity: 0.85;
    text-decoration: line-through;
    text-decoration-color: rgba(74, 222, 128, 0.5);
    font-weight: 700;
  }

  .point-number { color: inherit; min-width: 18px; }
  .point-title { color: inherit; }
  .point-distance {
    color: inherit;
    opacity: 0.9;
    margin-left: auto;
    padding-left: 10px;
  }

  .compass-container {
    position: relative;
    width: min(70vw, 70vh, 400px);
    height: min(70vw, 70vh, 400px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    flex-shrink: 0;
  }

  .compass-container .compass-ring {
    transition: box-shadow 0.6s ease, border-color 0.6s ease;
  }

  .glow-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    pointer-events: none;
    transition: box-shadow 0.4s ease;
  }

  .compass-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 2px solid rgba(110, 168, 255, 0.2);
    border-radius: 50%;
    box-shadow:
      0 0 60px rgba(110, 168, 255, 0.15) inset,
      0 0 40px rgba(110, 168, 255, 0.1);
    transition: all 0.6s ease;
  }

  body.arrived .compass-ring {
    border-color: rgba(74, 222, 128, 0.4);
    box-shadow:
      0 0 60px rgba(74, 222, 128, 0.25) inset,
      0 0 40px rgba(74, 222, 128, 0.2);
  }

  .compass-ring::before {
    content: '';
    position: absolute;
    top: -2px; left: -2px; right: -2px; bottom: -2px;
    border: 1px dashed rgba(110, 168, 255, 0.3);
    border-radius: 50%;
    animation: rotate 60s linear infinite;
    transition: border-color 0.6s ease;
  }

  body.arrived .compass-ring::before {
    border-color: rgba(74, 222, 128, 0.4);
  }

  @keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  .compass-cardinals {
    position: absolute;
    width: 100%;
    height: 100%;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
  }

  .cardinal {
    position: absolute;
    font-size: 1.2em;
    font-weight: 700;
    letter-spacing: 2px;
    transition: color 0.3s ease;
  }

  .cardinal.n {
    top: 8px; left: 50%; transform: translateX(-50%);
    color: #ff6b6b;
    text-shadow: 0 0 10px rgba(255, 107, 107, 0.6);
  }

  body.arrived .cardinal.n {
    color: #4ade80;
    text-shadow: 0 0 10px rgba(74, 222, 128, 0.6);
  }

  .cardinal.s { bottom: 8px; left: 50%; transform: translateX(-50%); color: #8a94c7; }
  body.arrived .cardinal.s { color: #86efac; }
  .cardinal.e { right: 12px; top: 50%; transform: translateY(-50%); color: #8a94c7; }
  body.arrived .cardinal.e { color: #86efac; }
  .cardinal.w { left: 12px; top: 50%; transform: translateY(-50%); color: #8a94c7; }
  body.arrived .cardinal.w { color: #86efac; }

  .arrow-wrapper {
    width: 70%;
    height: 70%;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
  }

  .arrow-svg {
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 0 20px rgba(255, 100, 100, 0.6));
    transition: filter 0.6s ease;
  }

  body.arrived .arrow-svg {
    filter: drop-shadow(0 0 25px rgba(74, 222, 128, 0.8));
  }

  .center-dot {
    position: absolute;
    width: 14px;
    height: 14px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    z-index: 3;
  }

  .bottom-panel {
    text-align: center;
    z-index: 2;
    width: 100%;
    max-width: 400px;
  }

  .status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(110, 168, 255, 0.2);
    border-radius: 30px;
    backdrop-filter: blur(10px);
    margin: 0 auto;
    width: fit-content;
    max-width: 100%;
    transition: all 0.6s ease;
  }

  body.arrived .status {
    border-color: rgba(74, 222, 128, 0.4);
    background: rgba(74, 222, 128, 0.1);
  }

  .status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 10px #4ade80;
    animation: pulse 2s infinite;
  }

  .status-dot.error {
    background: #f87171;
    box-shadow: 0 0 10px #f87171;
    animation: none;
  }

  .status-dot.pending {
    background: #fbbf24;
    box-shadow: 0 0 10px #fbbf24;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
  }

  .status-text {
    font-size: 0.9em;
    color: #c7d0f0;
  }

  .heading-info {
    margin-top: 12px;
    font-size: 0.75em;
    color: #6ea8ff;
    font-family: 'Courier New', monospace;
  }

  .https-warning {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(10, 14, 31, 0.97);
    backdrop-filter: blur(15px);
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 300;
    padding: 30px;
    text-align: center;
    overflow-y: auto;
  }

  .https-warning.visible { display: flex; }

  .https-warning-icon { font-size: 4em; margin-bottom: 20px; }
  .https-warning-title { font-size: 1.5em; font-weight: 700; margin-bottom: 15px; color: #fbbf24; }

  .https-warning-text {
    color: #c7d0f0;
    line-height: 1.6;
    max-width: 400px;
    margin-bottom: 15px;
    font-size: 0.95em;
  }

  .https-warning-url {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(251, 191, 36, 0.3);
    border-radius: 10px;
    padding: 12px 20px;
    font-family: 'Courier New', monospace;
    font-size: 0.85em;
    color: #fbbf24;
    word-break: break-all;
    margin-bottom: 15px;
    max-width: 100%;
  }

  .arrival-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(10, 31, 20, 0.9);
    backdrop-filter: blur(15px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 200;
    padding: 30px;
    text-align: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s ease;
  }

  .arrival-overlay.visible { opacity: 1; pointer-events: auto; }

  .arrival-icon {
    font-size: 5em;
    margin-bottom: 20px;
    animation: bounce 1.5s ease-in-out infinite;
    filter: drop-shadow(0 0 30px rgba(74, 222, 128, 0.6));
  }

  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
  }

  .arrival-title {
    font-size: 1.8em;
    font-weight: 700;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #ffffff 0%, #4ade80 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 1px;
  }

  .arrival-point-name {
    font-size: 2.2em;
    font-weight: 800;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #4ade80 0%, #86efac 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .arrival-message {
    color: #a7f3d0;
    font-size: 1.1em;
    margin-bottom: 30px;
    line-height: 1.6;
    max-width: 400px;
    padding: 15px 25px;
    background: rgba(74, 222, 128, 0.1);
    border-radius: 12px;
    border: 1px solid rgba(74, 222, 128, 0.2);
  }

  .arrival-stats {
    background: rgba(74, 222, 128, 0.1);
    border: 1px solid rgba(74, 222, 128, 0.3);
    border-radius: 15px;
    padding: 20px 30px;
    margin-bottom: 30px;
    min-width: 250px;
  }

  .arrival-stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 0.95em;
  }

  .arrival-stat-row + .arrival-stat-row {
    border-top: 1px solid rgba(74, 222, 128, 0.15);
  }

  .arrival-stat-label { color: #86efac; opacity: 0.8; }

  .arrival-stat-value {
    color: white;
    font-weight: 600;
    font-family: 'Courier New', monospace;
  }

  .arrival-btn {
    padding: 15px 40px;
    background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    letter-spacing: 1px;
    box-shadow: 0 10px 30px rgba(74, 222, 128, 0.4);
    transition: transform 0.2s;
  }

  .arrival-btn:active { transform: scale(0.95); }

  .arrival-btn.finish {
    background: linear-gradient(135deg, #6ea8ff 0%, #4f7cff 100%);
    box-shadow: 0 10px 30px rgba(79, 124, 255, 0.4);
  }

  .confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    pointer-events: none;
    animation: confettiFall 3s linear forwards;
  }

  @keyframes confettiFall {
    0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
  }
</style>