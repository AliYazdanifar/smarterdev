/* SmarterDev — demo form validation (login, register, contact).
   STATIC PROTOTYPE: nothing is sent anywhere. On success a clearly-labelled demo panel is shown.
   Laravel: replace with FormRequest validation + server-side error bags. */
(function () {
  'use strict';
  var FA = '۰۱۲۳۴۵۶۷۸۹', AR = '٠١٢٣٤٥٦٧٨٩';
  function toLatin(s) {
    return String(s).replace(/[۰-۹]/g, function (d) { return FA.indexOf(d); }).replace(/[٠-٩]/g, function (d) { return AR.indexOf(d); });
  }
  var EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  var MOBILE = /^(\+98|0098|98|0)?9\d{9}$/;

  function errorEl(field) { return document.getElementById(field.id + '-error'); }
  function setError(field, msg) {
    var el = errorEl(field);
    if (!el) { return; }
    if (msg) {
      el.innerHTML = '<i class="bi bi-exclamation-circle" aria-hidden="true"></i><span></span>';
      el.lastChild.textContent = msg;
      el.hidden = false;
      field.setAttribute('aria-invalid', 'true');
    } else {
      el.hidden = true; el.textContent = '';
      field.removeAttribute('aria-invalid');
    }
  }
  function check(field, form) {
    var v = field.value.trim();
    if (field.hasAttribute('required') && !v) { return field.getAttribute('data-msg-required') || 'این فیلد الزامی است.'; }
    if (!v) { return ''; }
    var kind = field.getAttribute('data-kind');
    if (kind === 'email' && !EMAIL.test(v)) { return 'ایمیل واردشده معتبر نیست.'; }
    if (kind === 'contact') {
      var n = toLatin(v).replace(/[\s-]/g, '');
      if (!EMAIL.test(n) && !MOBILE.test(n)) { return 'ایمیل یا شماره موبایل معتبر وارد کنید.'; }
    }
    var min = parseInt(field.getAttribute('data-min'), 10);
    if (min && v.length < min) { return 'حداقل ' + min.toLocaleString('fa-IR') + ' نویسه لازم است.'; }
    var match = field.getAttribute('data-match');
    if (match) {
      var other = form.querySelector(match);
      if (other && other.value !== field.value) { return 'مقدار واردشده با فیلد قبلی یکسان نیست.'; }
    }
    return '';
  }

  Array.prototype.forEach.call(document.querySelectorAll('form[data-demo-form]'), function (form) {
    var fields = Array.prototype.slice.call(form.querySelectorAll('.sd-input'));
    fields.forEach(function (f) {
      f.addEventListener('blur', function () { if (f.value || f.getAttribute('aria-invalid')) { setError(f, check(f, form)); } });
      f.addEventListener('input', function () { if (f.getAttribute('aria-invalid')) { setError(f, check(f, form)); } });
    });
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      var firstBad = null;
      fields.forEach(function (f) {
        var msg = check(f, form);
        setError(f, msg);
        if (msg && !firstBad) { firstBad = f; }
      });
      var consent = form.querySelector('[data-consent]');
      if (consent && !consent.checked) {
        var ce = document.getElementById(consent.id + '-error');
        if (ce) { ce.hidden = false; ce.innerHTML = '<i class="bi bi-exclamation-circle" aria-hidden="true"></i><span>برای ادامه باید این مورد را تأیید کنید.</span>'; }
        consent.setAttribute('aria-invalid', 'true');
        if (!firstBad) { firstBad = consent; }
      }
      if (firstBad) { firstBad.focus(); return; }
      var ok = document.querySelector('[data-demo-success]');
      if (ok) {
        ok.hidden = false;
        form.hidden = true;
        var heading = ok.querySelector('[data-focus-target]');
        if (heading) { heading.focus(); }
      }
    });
  });
})();
