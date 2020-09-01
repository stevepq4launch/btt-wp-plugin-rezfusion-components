/**
 * Constant value for signaling the removal of an item from the list of flag.
 * @type {number}
 */
const REZFUSION_FLAG_ITEM_REMOVED = 0;
/**
 * Constant value for signaling the addition of a flagged item.
 * @type {number}
 */
const REZFUSION_FLAG_ITEM_ADDED = 1;

/**
 * Toggle a given item's presence in a list of flags.
 *
 * @param namespace
 * @param itemId
 * @returns {*}
 */
const rezfusionToggleFlag = (namespace, itemId) => {
  const items = rezfusionGetFlags(namespace);
  if(!items) {
    localStorage.setItem(namespace, JSON.stringify([itemId]));
    return REZFUSION_FLAG_ITEM_ADDED;
  }
  const index = items.indexOf(itemId);
  if(index === -1) {
    localStorage.setItem(namespace, JSON.stringify([
      ...items,
      itemId,
    ]));
    return REZFUSION_FLAG_ITEM_ADDED;
  }

  localStorage.setItem(namespace, JSON.stringify(items.filter(i => i !== itemId)));
  return REZFUSION_FLAG_ITEM_REMOVED;
};

/**
 * Determine whether an item is currently flagged or not.
 * @param namespace
 * @param itemId
 * @returns {boolean}
 */
export const rezfusionItemIsFlagged = (namespace, itemId) =>
  rezfusionGetFlags(namespace) && rezfusionGetFlags(namespace).indexOf(itemId) !== -1;

/**
 * Get the full list of favorites stored in the browser.
 * @param namespace
 * @returns {*}
 */
export const rezfusionGetFlags = (namespace) => {
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
};

/**
 * Provide a simple javascript "component" for providing
 * an interactive Flag toggle.
 * @param elem
 * @param namespace
 * @param itemId
 * @constructor
 */
export class RezfusionItemFlag {
  constructor(elem, namespace, itemId) {
    this.elem = elem;
    this.namespace = namespace;
    this.itemId = itemId;
    this.elem.dataset.rzfFlagNamespace = namespace;
    this.elem.dataset.rzfFlagItem = itemId;
    this.handle(() => rezfusionItemIsFlagged(this.namespace, this.itemId));
    this.elem.onclick = () => this.handle(() => rezfusionToggleFlag(this.namespace, this.itemId));
  }

  /**
   * Use a callback to determine when to set the flag state/classes.
   * @param callback
   */
  handle = (callback) =>
    (callback(this.namespace, this.itemId) ? this.flag() : this.unflag());

  /**
   * Set flagged classes.
   */
  flag = () => {
    this.elem.classList.add('lodging-item-flag--flagged');
    this.elem.classList.remove('lodging-item-flag--unflagged');
  };

  /**
   * Set unflagged classes.
   */
  unflag = () => {
    this.elem.classList.add('lodging-item-flag--unflagged');
    this.elem.classList.remove('lodging-item-flag--flagged');
  }
}

window.RezfusionItemFlag = RezfusionItemFlag;
