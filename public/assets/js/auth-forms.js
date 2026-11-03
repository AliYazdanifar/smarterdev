/* Shop auth forms: register, login, OTP verify — uses Modules/Auth API via SdAuth. */
(function () {
  'use strict';

  var FA = '۰۱۲۳۴۵۶۷۸۹';
  var AR = '٠١٢٣٤٥٦٧٨٩';

  function toLatin(s) {
    return String(s)
      .replace(/[۰-۹]/g, function (d) {
        return FA.indexOf(d);
      })
      .replace(/[٠-٩]/g, function (d) {
        return AR.indexOf(d);
      });
  }

  function normalizePhone(raw) {
    var n = toLatin(String(raw).trim()).replace(/[\s\-()]/g, '');
    if (/^(\+98|0098|98)9\d{9}$/.test(n)) {
      n = n.replace(/^(\+98|0098|98)/, '0');
    }
    if (/^9\d{9}$/.test(n)) {
      n = '0' + n;
    }
    return n;
  }

  function errorEl(field) {
    return document.getElementById(field.id + '-error');
  }

  function setError(field, msg) {
    var el = errorEl(field);
    if (!el) {
      return;
    }
    if (msg) {
      el.innerHTML = '<i class="bi bi-exclamation-circle" aria-hidden="true"></i><span></span>';
      el.lastChild.textContent = msg;
      el.hidden = false;
      field.setAttribute('aria-invalid', 'true');
    } else {
      el.hidden = true;
      el.textContent = '';
      field.removeAttribute('aria-invalid');
    }
  }

  function setFormAlert(root, msg) {
    var box = root.querySelector('[data-auth-alert]');
    if (!box) {
      return;
    }
    if (msg) {
      box.hidden = false;
      box.querySelector('p').textContent = msg;
    } else {
      box.hidden = true;
    }
  }

  function splitName(full) {
    var parts = String(full).trim().split(/\s+/).filter(Boolean);
    if (!parts.length) {
      return { first_name: '', last_name: '' };
    }
    if (parts.length === 1) {
      return { first_name: parts[0], last_name: parts[0] };
    }
    return { first_name: parts[0], last_name: parts.slice(1).join(' ') };
  }

  function showOtpStep(root, phone) {
    root.querySelector('[data-auth-step="credentials"]').hidden = true;
    var otpStep = root.querySelector('[data-auth-step="otp"]');
    otpStep.hidden = false;
    otpStep.querySelector('[data-otp-phone]').textContent = phone;
    otpStep.querySelector('input[name="code"]').focus();
    root.dataset.pendingPhone = phone;
  }

  function bindOtpStep(root) {
    var otpStep = root.querySelector('[data-auth-step="otp"]');
    if (!otpStep) {
      return;
    }
    var form = otpStep.querySelector('form');
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      setFormAlert(root, '');
      var phone = root.dataset.pendingPhone || '';
      var codeInput = form.querySelector('input[name="code"]');
      var code = toLatin(codeInput.value.trim());
      if (!/^\d{4}$/.test(code)) {
        setError(codeInput, 'کد ۴ رقمی را وارد کنید.');
        return;
      }
      setError(codeInput, '');
      var btn = form.querySelector('[type="submit"]');
      btn.disabled = true;
      window.SdAuth.verifyOtp(phone, code).then(function (result) {
        btn.disabled = false;
        if (result.ok && result.data && result.data.success !== false) {
          window.SdAuth.redirectAfterAuth();
          return;
        }
        setFormAlert(root, window.SdAuth.firstErrorMessage(result.data));
      });
    });

    var resendBtn = otpStep.querySelector('[data-resend-otp]');
    if (resendBtn) {
      resendBtn.addEventListener('click', function () {
        var phone = root.dataset.pendingPhone || '';
        resendBtn.disabled = true;
        window.SdAuth.resendOtp(phone).then(function (result) {
          resendBtn.disabled = false;
          setFormAlert(
            root,
            result.ok ? 'کد جدید ارسال شد.' : window.SdAuth.firstErrorMessage(result.data)
          );
        });
      });
    }
  }

  function bindRegister(root) {
    var form = root.querySelector('form[data-auth-register]');
    if (!form) {
      return;
    }
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      setFormAlert(root, '');
      var name = form.querySelector('#r-name');
      var phoneEl = form.querySelector('#r-phone');
      var pass = form.querySelector('#r-pass');
      var pass2 = form.querySelector('#r-pass2');
      var consent = form.querySelector('#r-consent');
      var names = splitName(name.value);
      var phone = normalizePhone(phoneEl.value);
      if (!names.first_name) {
        setError(name, 'نام را وارد کنید.');
        return;
      }
      setError(name, '');
      if (!/^09\d{9}$/.test(phone)) {
        setError(phoneEl, 'شماره موبایل معتبر وارد کنید (مثال: ۰۹۱۲۳۴۵۶۷۸۹).');
        return;
      }
      setError(phoneEl, '');
      if (pass.value.length < 8) {
        setError(pass, 'حداقل ۸ نویسه.');
        return;
      }
      setError(pass, '');
      if (pass.value !== pass2.value) {
        setError(pass2, 'تکرار گذرواژه مطابقت ندارد.');
        return;
      }
      setError(pass2, '');
      if (!consent.checked) {
        var ce = document.getElementById('r-consent-error');
        if (ce) {
          ce.hidden = false;
        }
        return;
      }
      var btn = form.querySelector('[type="submit"]');
      btn.disabled = true;
      window.SdAuth.register({
        first_name: names.first_name,
        last_name: names.last_name,
        phone: phone,
        password: pass.value,
        password_confirmation: pass2.value,
      }).then(function (result) {
        btn.disabled = false;
        if (result.ok || result.status === 429) {
          showOtpStep(root, phone);
          setFormAlert(root, result.data.message || 'کد تایید برای شما ارسال شد.');
          return;
        }
        setFormAlert(root, window.SdAuth.firstErrorMessage(result.data));
      });
    });
  }

  function bindLogin(root) {
    var form = root.querySelector('form[data-auth-login]');
    if (!form) {
      return;
    }
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      setFormAlert(root, '');
      var phoneEl = form.querySelector('#a-phone');
      var pass = form.querySelector('#a-pass');
      var phone = normalizePhone(phoneEl.value);
      if (!/^09\d{9}$/.test(phone)) {
        setError(phoneEl, 'شماره موبایل معتبر وارد کنید.');
        return;
      }
      setError(phoneEl, '');
      if (!pass.value) {
        setError(pass, 'گذرواژه الزامی است.');
        return;
      }
      setError(pass, '');
      var btn = form.querySelector('[type="submit"]');
      btn.disabled = true;
      window.SdAuth.login(phone, pass.value).then(function (result) {
        btn.disabled = false;
        if (result.ok && result.data && result.data.data && result.data.data.token) {
          window.SdAuth.setToken(result.data.data.token);
          window.SdAuth.redirectAfterAuth();
          return;
        }
        if (
          result.status === 403 &&
          result.data &&
          result.data.errors &&
          result.data.errors.needs_verification
        ) {
          showOtpStep(root, phone);
          setFormAlert(root, result.data.message || 'کد تایید ارسال شد.');
          return;
        }
        if (result.status === 429) {
          showOtpStep(root, phone);
          setFormAlert(root, result.data.message || 'کد قبلی هنوز معتبر است.');
          return;
        }
        setFormAlert(root, window.SdAuth.firstErrorMessage(result.data));
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    Array.prototype.forEach.call(document.querySelectorAll('[data-auth-root]'), function (root) {
      bindOtpStep(root);
      bindRegister(root);
      bindLogin(root);
    });
  });
})();
