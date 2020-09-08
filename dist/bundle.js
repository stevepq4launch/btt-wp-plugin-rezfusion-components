(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.RezfusionItemFlag = exports.rezfusionGetFlags = exports.rezfusionItemIsFlagged = void 0;

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}
/**
 * Constant value for signaling the removal of an item from the list of flag.
 * @type {number}
 */


var REZFUSION_FLAG_ITEM_REMOVED = 0;
/**
 * Constant value for signaling the addition of a flagged item.
 * @type {number}
 */

var REZFUSION_FLAG_ITEM_ADDED = 1;
/**
 * Toggle a given item's presence in a list of flags.
 *
 * @param namespace
 * @param itemId
 * @returns {*}
 */

var rezfusionToggleFlag = function rezfusionToggleFlag(namespace, itemId) {
  var items = rezfusionGetFlags(namespace);

  if (!items) {
    localStorage.setItem(namespace, JSON.stringify([itemId]));
    return REZFUSION_FLAG_ITEM_ADDED;
  }

  var index = items.indexOf(itemId);

  if (index === -1) {
    localStorage.setItem(namespace, JSON.stringify([].concat(_toConsumableArray(items), [itemId])));
    return REZFUSION_FLAG_ITEM_ADDED;
  }

  localStorage.setItem(namespace, JSON.stringify(items.filter(function (i) {
    return i !== itemId;
  })));
  return REZFUSION_FLAG_ITEM_REMOVED;
};
/**
 * Determine whether an item is currently flagged or not.
 * @param namespace
 * @param itemId
 * @returns {boolean}
 */


var rezfusionItemIsFlagged = function rezfusionItemIsFlagged(namespace, itemId) {
  return rezfusionGetFlags(namespace) && rezfusionGetFlags(namespace).indexOf(itemId) !== -1;
};
/**
 * Get the full list of favorites stored in the browser.
 * @param namespace
 * @returns {*}
 */


exports.rezfusionItemIsFlagged = rezfusionItemIsFlagged;

var rezfusionGetFlags = function rezfusionGetFlags(namespace) {
  var data = localStorage.getItem(namespace);

  if (!data) {
    return [];
  }

  try {
    return JSON.parse(data);
  } catch (err) {
    console.error(err);
    return false;
  }
};
/**
 * Provide a simple javascript "component" for providing
 * an interactive Flag toggle.
 * @param elem
 * @param namespace
 * @param itemId
 * @constructor
 */


exports.rezfusionGetFlags = rezfusionGetFlags;

var RezfusionItemFlag = function RezfusionItemFlag(elem, namespace, itemId) {
  var _this = this;

  _classCallCheck(this, RezfusionItemFlag);

  _defineProperty(this, "handle", function (callback) {
    return callback(_this.namespace, _this.itemId) ? _this.flag() : _this.unflag();
  });

  _defineProperty(this, "flag", function () {
    _this.elem.classList.add('lodging-item-flag--flagged');

    _this.elem.classList.remove('lodging-item-flag--unflagged');
  });

  _defineProperty(this, "unflag", function () {
    _this.elem.classList.add('lodging-item-flag--unflagged');

    _this.elem.classList.remove('lodging-item-flag--flagged');
  });

  this.elem = elem;
  this.namespace = namespace;
  this.itemId = itemId;
  this.elem.dataset.rzfFlagNamespace = namespace;
  this.elem.dataset.rzfFlagItem = itemId;
  this.handle(function () {
    return rezfusionItemIsFlagged(_this.namespace, _this.itemId);
  });

  this.elem.onclick = function () {
    return _this.handle(function () {
      return rezfusionToggleFlag(_this.namespace, _this.itemId);
    });
  };
}
/**
 * Use a callback to determine when to set the flag state/classes.
 * @param callback
 */
;

exports.RezfusionItemFlag = RezfusionItemFlag;
window.RezfusionItemFlag = RezfusionItemFlag;

},{}]},{},[1]);
