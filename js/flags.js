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
function rezfusionToggleFlag(namespace, itemId) {
  var items = rezfusionGetFlags(namespace);
  if(!items) {
    localStorage.setItem(namespace, JSON.stringify([itemId]));
    return REZFUSION_FLAG_ITEM_ADDED;
  }
  var index = items.indexOf(itemId);
  if(index === -1) {
    items.push(itemId);
    localStorage.setItem(namespace, JSON.stringify(items));
    return REZFUSION_FLAG_ITEM_ADDED;
  }

  items.splice(index, 1);
  localStorage.setItem(namespace, JSON.stringify(items));
  return REZFUSION_FLAG_ITEM_REMOVED;
}

/**
 * Determine whether an item is currently flagged or not.
 * @param namespace
 * @param itemId
 * @returns {boolean}
 */
function rezfusionItemIsFlagged(namespace, itemId) {
  var items = rezfusionGetFlags(namespace);
  if(!items) {
    return false;
  }
  var index = items.indexOf(itemId);
  if(index === -1) {
    return false;
  }
  return true;
}

/**
 * Get the full list of favorites stored in the browser.
 * @param namespace
 * @returns {*}
 */
function rezfusionGetFlags(namespace) {
  const data = localStorage.getItem(namespace);
  if (!data) {
    return [];
  }
  try {
    return JSON.parse(data);
  } catch (err) {
    console.error(err);
    return false;
  }
}

/**
 * Provide a simple javascript "component" for providing
 * an interactive Flag toggle.
 * @param elem
 * @param namespace
 * @param itemId
 * @constructor
 */
var RezfusionItemFlag = function (elem, namespace, itemId) {
  elem.dataset.rzfFlagNamespace = namespace;
  elem.dataset.rzfFlagItem = itemId;

  /**
   * Use a callback to determine when to set the flag state/classes.
   * @param namespace
   * @param itemId
   * @param callback
   */
  function handleFlag(namespace, itemId, callback) {
    if(callback(namespace, itemId)) {
      flag();
    }
    else {
      unflag();
    }
  }

  /**
   * Set flagged classes.
   */
  function flag() {
    elem.classList.add('lodging-item-flag--flagged');
    elem.classList.remove('lodging-item-flag--unflagged');
  }

  /**
   * Set unflagged classes.
   */
  function unflag() {
    elem.classList.add('lodging-item-flag--unflagged');
    elem.classList.remove('lodging-item-flag--flagged');
  }

  // Handle the initial state.
  handleFlag(namespace, itemId, function(n, i) { return rezfusionItemIsFlagged(n, i) });

  // Handle toggling the flag.
  elem.onclick = function() {
    handleFlag(namespace, itemId, function(n, i) { return rezfusionToggleFlag(n, i) });
  };
};
