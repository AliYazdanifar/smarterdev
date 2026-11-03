(function () {
  'use strict';

  function showWizardForAuthenticatedUser() {
    if (!window.SdAuth || !window.SdAuth.getToken()) {
      return;
    }

    window.SdAuth.me().then(function (result) {
      if (!result.ok || !result.data || result.data.success === false) {
        window.SdAuth.clearToken();
        return;
      }

      var gate = document.querySelector('[data-gate]');
      var wizard = document.querySelector('[data-wizard-root]');
      if (gate) {
        gate.hidden = true;
      }
      if (wizard) {
        wizard.hidden = false;
      }

      document.querySelectorAll('[data-hide-when-authenticated]').forEach(function (el) {
        el.hidden = true;
      });
    });
  }

  document.addEventListener('DOMContentLoaded', showWizardForAuthenticatedUser);
})();
