import { showMessage } from './snackbar';
import GmStyles from '../shared/styles';
import { isRtl } from '../shared/helpers';
import axios from 'axios/index';

export function gmSaveForm (form, subAction) {

  let saveBtnElem = document.querySelector('.gm-gui-save-btn .fa');
  let spinnerClassName = 'gm-three-quarters-spinner';
  saveBtnElem.classList ? saveBtnElem.classList.add(spinnerClassName) : saveBtnElem.className += ' gm-three-quarters-spinner';

  let formData = new FormData(document.forms.preset);
  let presetObj = {};
  formData.forEach((value, key) => {presetObj[key] = value;});
  let presetData = JSON.stringify(presetObj);
  let gmNonce = document.querySelector('#gm-nonce-save-preset-action');
  let data = {
    'action': 'gm_save',
    'sub_action': subAction,
    'gm_nonce': gmNonce.value,
    'data': presetData
  };
  const params = new URLSearchParams(data);

  axios.post(ajaxurl, params)
    .then(function () {
      gmGetSettings(form, subAction);
    })
    .catch(function (response) {
      showMessage(`Error gmSaveForm: ${response.data}`);
      saveBtnElem.className = saveBtnElem.className.replace(spinnerClassName, '');
    });
}

function gmGetSettings (form, subAction) {
  let presetId = parseInt(form.dataset.id, 10);
  const data = {
    'action': 'gm_get_setting',
    'preset_id': presetId
  };
  const params = new URLSearchParams(data);

  let saveBtnElem = document.querySelector('.gm-gui-save-btn .fa');
  let spinnerClassName = 'gm-three-quarters-spinner';

  axios.post(ajaxurl, params)
    .then(function (response) {
      const settings = response.data.data;
      const gmStyles = new GmStyles(settings);
      gmSaveStyles(presetId, gmStyles.get(), subAction);
    })
    .catch(function (response) {
      showMessage(`Error gmGetSettings: ${response.data}`);
      saveBtnElem.className = saveBtnElem.className.replace(spinnerClassName, '');
    });
}

function gmSaveStyles (presetId, css, subAction) {
  let gmNonce = document.querySelector('#gm-nonce-save-preset-action');
  let groovyMenuForm = document.querySelector('.gm-form');

  const data = {
    'action': 'gm_save_styles',
    'sub_action': subAction,
    'direction': isRtl() ? 'rtl' : 'ltr',
    'preset_id': presetId,
    'gm_nonce': gmNonce.value,
    'gm_version': groovyMenuForm.getAttribute('data-version'),
    'data': css,
  };
  const params = new URLSearchParams(data);

  let saveBtnElem = document.querySelector('.gm-gui-save-btn .fa');
  let spinnerClassName = 'gm-three-quarters-spinner';

  window.onbeforeunload = null;

  axios.post(ajaxurl, params)
    .then(function (response) {
      showMessage(response.data.data);
      saveBtnElem.className = saveBtnElem.className.replace(spinnerClassName, '');
    })
    .catch(function (response) {
      showMessage(`Error gmSaveStyles: ${response.data}`);
      saveBtnElem.className = saveBtnElem.className.replace(spinnerClassName, '');
    });
}

export function restoreSettings (form, subAction) {
  let fields = form.querySelectorAll('.gm-select, .gm-colorpicker, .gm-gui__module__number__input, .switch, .gm-header, .gm-hover-style-input, .gm-upload-input');
  let changeEvent = new Event('change');

  fields.forEach(function (field) {
    if (field.dataset.reset === 'undefined') {
      return;
    }

    if (field.classList.contains('gm-header')) {
      field.dataset.align = 'left';
      field.dataset.toolbar = 'false';
      field.dataset.style = '1';
      field
        .closest('.gm-gui__header-types__options')
        .querySelector('.gm-gui__header-types__options__align--left')
        .click();
    }

    if (subAction === 'restore') {
      if (field.classList.contains('gm-colorpicker')) {
        field.value = field.dataset.default;
        field
          .closest('.gm-gui__module__colorpicker')
          .querySelector('.pcr-button')
          .click();
        document
          .querySelector('.pcr-app.visible .pcr-clear')
          .click();
      }
    }

    if (field.classList.contains('select-hidden')) {
      if (field.dataset.default === undefined) {
        field.options[0].selected = true;
      }
    }

    if (field.dataset.default !== undefined) {
      field.value = field.dataset.default;
    }

    field.dispatchEvent(changeEvent);

    if (field.getAttribute('type') === 'checkbox') {
      if (field.dataset.default === '1') {
        field.checked = true;
      } else {
        field.checked = false;
      }
    }
  });

  if (subAction === 'restore_all') {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
    });
  }
}

