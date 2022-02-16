import { nodeOps } from './nodeOps.js';

const activateSubmitBtn = ($form) => {
  const $submitBtn = nodeOps.qs('[type="submit"]', $form);

  if ($form.checkValidity()) {
    nodeOps.rmAttr($submitBtn, 'disabled');
  } else {
    nodeOps.setAttr($submitBtn, 'disabled', true);
  }
};

// init form-validation
export function validateForm() {
  const $inputs = nodeOps.qsAl('.validate-target');
  const $form = nodeOps.qs('.validate-form');

  if (!$form) {
    return;
  }

  $inputs.forEach(($input) => {
    nodeOps.on($input, 'input', (e) => {
      const $target = e.currentTarget;
      const $feedback = $target.nextElementSibling;

      activateSubmitBtn($form);

      if (!$feedback.classList.contains('invalid-feedback')) {
        return;
      }

      if ($target.checkValidity()) {
        nodeOps.clta($target, 'is-valid');
        nodeOps.cltr($target, 'is-invalid');
        
        $feedback.textContent = '';
      } else {
        nodeOps.clta($target, 'is-invalid');
        nodeOps.cltr($target, 'is-valid');

        if ($target.validity.valueMissing) {
          $feedback.textContent = '値の入力が必須です。';
        } else if ($target.validity.tooShort) {
          $feedback.textContent = `${$target.minLength}文字以上で入力してください。現在の文字数は${$target.value.length}文字です。`;
        } else if ($target.validity.tooLong) {
          $feedback.textContent = `${$target.maxLength}文字以上で入力してください。現在の文字数は${$target.value.length}文字です。`;
        } else if (
          $target.validity.patternMismatch &&
          $target.id === 'Input-id'
        ) {
          $feedback.textContent = `半角英数値で入力してください。`;
        } else if (
          $target.validity.patternMismatch &&
          $target.id === 'Input-pass'
        ) {
          $feedback.textContent = `半角英数値かつ1つ以上の大文字で入力してください。`;
        }
      }
    });
  });
  activateSubmitBtn($form);
}
