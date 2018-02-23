/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 206);
/******/ })
/************************************************************************/
/******/ ({

/***/ 206:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(207);
module.exports = __webpack_require__(613);


/***/ }),

/***/ 207:
/***/ (function(module, __webpack_exports__) {

"use strict";
throw new Error("Module build failed: SyntaxError: Unexpected token (300:0)\n\n\u001b[0m \u001b[90m 298 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'knocksretriver'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/knocksretriver.vue'\u001b[39m))\u001b[33m;\u001b[39m\n \u001b[90m 299 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'knocksvoicerecognition'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/knocksvoicerecognition.vue'\u001b[39m))\u001b[33m;\u001b[39m\n\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 300 | \u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<\u001b[39m \u001b[33mHEAD\u001b[39m\n \u001b[90m     | \u001b[39m\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\n \u001b[90m 301 | \u001b[39m\u001b[33m===\u001b[39m\u001b[33m===\u001b[39m\u001b[33m=\u001b[39m\n \u001b[90m 302 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'knockscroppie'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/knockscroppie.vue'\u001b[39m))\u001b[33m;\u001b[39m\n \u001b[90m 303 | \u001b[39m\u001b[0m\n");

/***/ }),

/***/ 613:
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: \n}\n^\n      Invalid CSS after \"}\": expected 1 selector or at-rule, was \"<<<<<<< HEAD\"\n      in /Users/heshamahmed/websites/knocks/resources/assets/sass/app.scss (line 1807, column 2)\n    at runLoaders (/Users/heshamahmed/websites/knocks/node_modules/webpack/lib/NormalModule.js:195:19)\n    at /Users/heshamahmed/websites/knocks/node_modules/loader-runner/lib/LoaderRunner.js:364:11\n    at /Users/heshamahmed/websites/knocks/node_modules/loader-runner/lib/LoaderRunner.js:230:18\n    at context.callback (/Users/heshamahmed/websites/knocks/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at Object.asyncSassJobQueue.push [as callback] (/Users/heshamahmed/websites/knocks/node_modules/sass-loader/lib/loader.js:55:13)\n    at Object.<anonymous> (/Users/heshamahmed/websites/knocks/node_modules/async/dist/async.js:2257:31)\n    at Object.callback (/Users/heshamahmed/websites/knocks/node_modules/async/dist/async.js:958:16)\n    at options.error (/Users/heshamahmed/websites/knocks/node_modules/node-sass/lib/index.js:294:32)");

/***/ })

/******/ });