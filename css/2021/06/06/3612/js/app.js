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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/assets/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/assets/js/app.js":
/*!******************************!*\
  !*** ./src/assets/js/app.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("\r\n/* Drop Menu */\r\n\r\n$(\"#navToggle\").on(\"click\", function(event) {\r\n        \r\n    event.preventDefault();\r\n    $(this).toggleClass(\"active\");\r\n    $(\"#listMenu\").toggleClass(\"open\");\r\n\r\n    $(\"#listMenu\").find('.childrenAway').removeClass('childrenAway');\r\n\r\n});\r\n\r\nwindow.addEventListener('resize', function() {\r\n\r\n    if ($(window).width()>768) {\r\n        $(\"#listMenu\").find('.childrenAway').removeClass('childrenAway');\r\n    }\r\n    \r\n});    \r\n\r\n//on mobile - open submenu\r\n\r\n$('.hasChildren').children('a').on('click', function(event){\r\n    if ($(window).width()<=768) {\r\n        event.preventDefault();\r\n    \r\n        $(this).parent('li').children('ul').addClass(\"childrenAway\")\r\n    }\r\n    \r\n});\r\n\r\n$('.goBack').children('a').on('click', function(event){\r\n        event.preventDefault();\r\n         \r\n        $(this).parent('li').parent('ul').removeClass(\"childrenAway\");\r\n});\r\n\r\n$('.hasChildren').children('a').on('click', function(event){\r\n    if ($(window).width()<=768) {\r\n        event.preventDefault();\r\n    \r\n        $(this).parent('li').children('ul').addClass(\"childrenAway\")\r\n    }\r\n    \r\n});\r\n\r\n//on mobile - product list\r\nif (document.getElementsByClassName(\"product__price\") != null) {\r\n    let cena = document.createElement('li');\r\n    let itogo = document.createElement('li');\r\n    cena.className = \"price-label col-sm-6 col-6\";\r\n    itogo.className = \"itogo-label col-sm-6 col-6\";\r\n    cena.innerHTML = \"Цена:\";\r\n    itogo.innerHTML = \"Итого:\";\r\n    let isResizeble = false;\r\n\r\n    let elements = document.getElementsByClassName(\"product__price\");\r\n    const price = Array.from(elements);\r\n    elements = document.getElementsByClassName(\"product__priceTotal\");\r\n    const priceTotal = Array.from(elements);\r\n\r\n    function res() {\r\n        if ($(window).width()<=767) {\r\n            if(!isResizeble) {\r\n                price.forEach(element => element.before(cena.cloneNode(true)));\r\n                priceTotal.forEach(element => element.before(itogo.cloneNode(true)));\r\n                isResizeble = true;\r\n            }\r\n        } else {\r\n            let delElements = document.getElementsByClassName(\"price-label\");\r\n            const del = Array.from(delElements); \r\n            del.forEach(element => element.parentNode.removeChild(element));\r\n            delElements = document.getElementsByClassName(\"itogo-label\");\r\n            const deli = Array.from(delElements);\r\n            deli.forEach(element => element.parentNode.removeChild(element));\r\n\r\n            isResizeble = false;\r\n        }  \r\n    }\r\n    function resLoad () {\r\n        if ($(window).width()<=768) {\r\n            price.forEach(element => element.before(cena.cloneNode(true)));\r\n            priceTotal.forEach(element => element.before(itogo.cloneNode(true)));\r\n            isResizeble = true;\r\n        }\r\n    }\r\n    window.addEventListener('resize', res);\r\n    document.addEventListener('DOMContentLoaded', res);\r\n}\r\n/* Search input toggle */\r\n\r\n$(\"#search__btn\").on(\"click\", function(event) { \r\n    event.preventDefault();\r\n    if ($(\"#searchPlace\").css(\"display\") === 'none') {\r\n        $(\"#searchPlace\").css(\"display\", $(\"#searchPlace\").css(\"display\") === 'none' ? '' : 'none');    \r\n        $(\"#searchPlace\").toggle();\r\n    } else {\r\n        $(\"#searchPlace\").css(\"display\", $(\"#searchPlace\").css(\"display\") === 'none' ? '' : 'block');    \r\n        $(\"#searchPlace\").toggle(); \r\n    }\r\n    \r\n});\r\n$(\"#search__sm__btn\").on(\"click\", function(event) { \r\n    if ($(\"#searchPlace\").css(\"display\") === 'none') {\r\n        $(\"#searchPlace\").css(\"display\", $(\"#searchPlace\").css(\"display\") === 'none' ? '' : 'none');    \r\n        $(\"#searchPlace\").toggle();\r\n    } else {\r\n        $(\"#searchPlace\").css(\"display\", $(\"#searchPlace\").css(\"display\") === 'none' ? '' : 'block');    \r\n        $(\"#searchPlace\").toggle(); \r\n    }\r\n    \r\n});\r\n\r\n$(document).on(\"mouseup\", function(e) {\r\n    \r\n    if ($(\"#searchPlace\").has(e.target).length === 0){\r\n        if ($(\"#searchPlace\").css(\"display\") === 'block') {\r\n            $(\"#searchPlace\").css(\"display\", $(\"#searchPlace\").css(\"display\") === 'none' ? '' : 'block');    \r\n            $(\"#searchPlace\").toggle(); \r\n        }\r\n    }\r\n});\r\n\r\n/* Korzina page quantity */\r\n\r\n\r\n\r\n$(\".quantity__plus\").on(\"click\", function() { \r\n    let quantity = this.parentNode.getElementsByClassName(\"quantity__number\")[0].innerHTML;\r\n    quantity++;\r\n    this.parentNode.getElementsByClassName(\"quantity__number\")[0].innerHTML = quantity; \r\n });\r\n\r\n$(\".quantity__minus\").on(\"click\", function() { \r\n    let quantity = this.parentNode.getElementsByClassName(\"quantity__number\")[0].innerHTML;\r\n    if (quantity > 1) {\r\n        quantity--;\r\n        this.parentNode.getElementsByClassName(\"quantity__number\")[0].innerHTML = quantity;\r\n    }\r\n});\r\n\r\n\r\n/* Korzina page delivery choose */\r\n\r\nif (document.getElementById(\"shop_delivery_type_id\") != null) {\r\n    let itemList = document.getElementById(\"shop_delivery_type_id\");\r\n    let collection = itemList.selectedOptions;\r\n    let delivery__text = document.getElementById(\"delivery\");\r\n\r\n    itemList.addEventListener('change', function () {\r\n\r\n    for (let i=0; i<collection.length; i++) {\r\n        if ((itemList.selectedIndex-1)>=0) {\r\n            delivery__text.children[itemList.selectedIndex-1].style.display=\"block\";  \r\n        };\r\n\r\n        for (let i=0; i<delivery__text.childElementCount; i++) {\r\n\r\n            if (itemList.selectedIndex-1 != i)\r\n            delivery__text.children[i].style.display=\"none\";\r\n        }\r\n    }\r\n    })\r\n}\r\n\r\n/* Money counting */\r\n\r\nfunction totalprodPrice() {\r\n    let elements = document.getElementsByClassName(\"product\");\r\n    const total = Array.from(elements);\r\n    total.forEach(element => \r\n        element.getElementsByClassName(\"priceTotal\").item(0).innerHTML = (element.getElementsByClassName(\"priceNum\").item(0).innerHTML*element.getElementsByClassName(\"quantity__number\").item(0).innerHTML)\r\n    );\r\n}\r\nfunction totalPrice() {\r\n    let elements = document.getElementsByClassName(\"priceTotal\");\r\n    const total = Array.from(elements);\r\n    let n = 0;\r\n    total.forEach(element => \r\n        n = n + parseInt(element.innerHTML)\r\n    );\r\n    let x = $(\".disNum\").html();\r\n    $(\".sumNum\").html(n+parseInt(x));\r\n    \r\n}\r\n\r\ndocument.addEventListener('DOMContentLoaded', totalprodPrice);\r\ndocument.addEventListener('DOMContentLoaded', totalPrice);\r\n\r\n$(\".quantity__plus\").on(\"click\", totalprodPrice);\r\n$(\".quantity__minus\").on(\"click\", totalprodPrice);\r\n$(\".quantity__plus\").on(\"click\", totalPrice);\r\n$(\".quantity__minus\").on(\"click\", totalPrice);\r\n\r\n\r\n/* Product list delete */\r\n\r\nfunction prodCheck () {\r\n    let elements = document.getElementsByClassName(\"product\");\r\n    const total = Array.from(elements);\r\n\r\n    let empty = document.createElement('div');\r\n    empty.className = \"prodEmpty\";\r\n    empty.innerHTML = \"Ваша корзина пуста\";\r\n    \r\n    if (total.length >= 1) {\r\n        \r\n    } else {\r\n        $(\".content\").children(\"section\").remove();\r\n        $(\".content\").append(empty);\r\n    }\r\n}\r\n\r\nif (document.getElementsByClassName(\"product\") != null) {\r\n    $(\".close-big\").on(\"click\", function (){\r\n        $(this).parent('button').parent('li').parent('ul').remove();\r\n    });\r\n    $(\".close-big\").on(\"click\", prodCheck);\r\n    $(\".close-big\").on(\"click\", totalPrice);\r\n} \r\n\r\n/* Input validation */\r\n\r\n$('.cell').on('focusout', function () {\r\n    let form = $(this);\r\n    let field = [];\r\n   \r\n    let err = document.createElement('div');\r\n        err.className = \"err\";\r\n        err.style = \"position: relative; top:-10px; left:0; font-size: 11px; color: #fff; background-color:#d85151; padding:2px 2px 2px 5px;\"\r\n        err.innerHTML = \"Необходимо заполнить\";\r\n\r\n    if (!form.val()) {\r\n        //console.log(\"ne zapolneno\");\r\n        $(this).addClass(\"cell-required\");\r\n        $(this).after(err);\r\n    } else {\r\n        //console.log(\"zapolneno\");\r\n        $(this).removeClass(\"cell-required\");\r\n        $(\".err\").remove();\r\n    }\r\n  });\r\n\r\n  /* Favorite Hint toggle */\n\n//# sourceURL=webpack:///./src/assets/js/app.js?");

/***/ })

/******/ });