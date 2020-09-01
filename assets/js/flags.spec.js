import { RezfusionItemFlag } from './flags';

test('Handles Flagging Items', () => {
  document.body.innerHTML = '<div><div class="flag"></div></div>'
  const el = document.querySelector('.flag');
  const flag = new RezfusionItemFlag(el, 'test-ns', 1234);
  flag.flag();
  expect(flag.elem.classList.toString() === 'flag lodging-item-flag--flagged');;
  flag.unflag();
  expect(flag.elem.classList.toString() === 'flag lodging-item-flag--unflagged');
});

test('Handles Local Storage', () => {
  document.body.innerHTML = '<div><div class="flag"></div></div>'
  const el = document.querySelector('.flag');
  const flag = new RezfusionItemFlag(el, 'test-ns', 1234);
  flag.flag();
  expect(flag.elem.classList.toString() === 'flag lodging-item-flag--flagged');
  flag.unflag();
  expect(flag.elem.classList.toString() === 'flag lodging-item-flag--unflagged');
});
