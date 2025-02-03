/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/inviewport.js":
/*!******************************!*\
  !*** ./src/js/inviewport.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function ($) {
  var lastScrollTop = 0;
  var inViewport = function inViewport(e) {
    var b = e.get(0).getBoundingClientRect();
    return !(b.top > window.innerHeight || b.bottom < 0);
  };
  var checkInViewport = function checkInViewport(els) {
    els.each(function () {
      var $this = $(this);
      if (inViewport($this)) {
        $this.removeClass('ct-not-in-viewport');
        $this.removeClass('ct-in-viewport');
        $this.addClass('ct-in-viewport');
      } else {
        $this.removeClass('ct-in-viewport');
        $this.removeClass('ct-not-in-viewport');
        $this.addClass('ct-not-in-viewport');
      }
    });
  };
  function init() {
    var els = $('.ct-visual');
    if (els.length) {
      console.log(els.length);
      checkInViewport(els);
      document.addEventListener('scroll', function () {
        var st = window.pageYOffset || document.documentElement.scrollTop;
        // const scrollDir = st > lastScrollTop ? 'down' : 'up'

        lastScrollTop = st <= 0 ? 0 : st;
        checkInViewport(els);
      });
    }
  }
  init();
});

/***/ })

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
/*!*********************!*\
  !*** ./src/main.js ***!
  \*********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_inviewport__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/inviewport */ "./src/js/inviewport.js");

(function ($) {
  (0,_js_inviewport__WEBPACK_IMPORTED_MODULE_0__["default"])($);
})(jQuery);
})();

/******/ })()
;
//# sourceMappingURL=main.js.map