/* eslint-env jest */
import { RezfusionItemFlag, rezfusionItemIsFlagged } from './flags';
import localStorage from './__mocks__/localStorage';

window.localStorage = localStorage;

test('Classes', () => {
  document.body.innerHTML = '<div><div class="flag"></div></div>';
  const el = document.querySelector('.flag');
  const flag = new RezfusionItemFlag(el, 'test-ns', 1234);
  flag.flag();
  expect(flag.elem.classList.toString()).toEqual('flag lodging-item-flag--flagged');
  flag.unflag();
  expect(flag.elem.classList.toString()).toEqual('flag lodging-item-flag--unflagged');
});

test('Toggles Items', () => {
  document.body.innerHTML = '<div><div class="flag"></div></div>';
  const el = document.querySelector('.flag');
  const flag = new RezfusionItemFlag(el, 'test-ns', 1234);
  const flagged = rezfusionItemIsFlagged('test-ns', 1234);
  expect(flagged).toEqual(false);
  expect(flag.elem.classList.toString()).toEqual('flag lodging-item-flag--unflagged');
  flag.elem.onclick();
  const actuallyFlagged = rezfusionItemIsFlagged('test-ns', 1234);
  expect(actuallyFlagged).toEqual(true);
  expect(flag.elem.classList.toString()).toEqual('flag lodging-item-flag--flagged');
  flag.elem.onclick();
  const actuallyNotFlagged = rezfusionItemIsFlagged('test-ns', 1234);
  expect(actuallyNotFlagged).toEqual(false);
  expect(flag.elem.classList.toString()).toEqual('flag lodging-item-flag--unflagged');
});
