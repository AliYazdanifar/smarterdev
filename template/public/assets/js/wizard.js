/* SmarterDev — project request wizard (STATIC PROTOTYPE).
   Everything stays in the browser: no network requests, no storage. Values live in the form DOM,
   so going back never loses input. Laravel: replace validation with FormRequest + server-side errors. */
(function () {
  'use strict';
  var form = document.getElementById('project-wizard');
  if (!form) { return; }

  var qs = function (s, c) { return (c || document).querySelector(s); };
  var qsa = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var fa = function (n) { return Number(n).toLocaleString('fa-IR'); };
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var steps = qsa('[data-step]', form);
  var total = steps.length;
  var cur = 0;
  var prevBtn = qs('[data-prev]', form), nextBtn = qs('[data-next]', form), submitBtn = qs('[data-submit]', form);
  var summary = qs('[data-error-summary]', form);
  var live = qs('[data-live]');
  var done = qs('[data-done]');
  var progress = qs('[data-progress]');
  var fill = qs('.wiz-bar__fill', progress), bar = qs('.wiz-bar', progress);
  var dots = qsa('.wiz-dots li', progress);

  /* ---- helpers --------------------------------------------------------- */
  function selectedCategory() {
    var c = qs('input[name="category"]:checked', form);
    return c ? c.value : '';
  }
  function errEl(id) { return document.getElementById(id + '-error'); }
  function showError(id, msg, control) {
    var el = errEl(id);
    if (!el) { return; }
    if (msg) {
      el.innerHTML = '<i class="bi bi-exclamation-circle" aria-hidden="true"></i><span></span>';
      el.lastChild.textContent = msg; el.hidden = false;
      if (control) { control.setAttribute('aria-invalid', 'true'); }
    } else {
      el.hidden = true; el.textContent = '';
      if (control) { control.removeAttribute('aria-invalid'); }
    }
  }
  function validUrl(v) {
    try { var u = new URL(/^https?:\/\//i.test(v) ? v : 'https://' + v); return u.hostname.indexOf('.') > 0; } catch (e) { return false; }
  }

  /* ---- conditional questions (step 3) ---------------------------------- */
  function applyConditions() {
    var cat = selectedCategory();
    qsa('.wiz-cond', form).forEach(function (block) {
      var show = !!cat && block.getAttribute('data-cats').split(',').indexOf(cat) !== -1;
      block.hidden = !show;
      qsa('input, select, textarea', block).forEach(function (c) { c.disabled = !show; });
    });
  }

  /* ---- validation ------------------------------------------------------ */
  function validateStep(i) {
    var root = steps[i], firstBad = null, ok = true;
    function bad(ctrl) { ok = false; if (!firstBad) { firstBad = ctrl; } }

    qsa('[data-required-group]', root).forEach(function (fs) {
      if (fs.closest('.wiz-cond[hidden]')) { return; }
      var name = fs.getAttribute('data-required-group');
      var any = qsa('input[name="' + name + '"]', fs).some(function (r) { return r.checked; });
      var first = qs('input', fs);
      if (!any) { showError(name, 'لطفاً یکی از گزینه‌ها را انتخاب کنید.', fs); fs.setAttribute('aria-invalid', 'true'); bad(first); }
      else { showError(name, '', fs); fs.removeAttribute('aria-invalid'); }
    });

    qsa('input[data-required], textarea[data-required]', root).forEach(function (f) {
      if (f.disabled || f.closest('.wiz-cond[hidden]')) { return; }
      var v = f.value.trim(), min = parseInt(f.getAttribute('data-min'), 10) || 0, msg = '';
      if (!v) { msg = 'این فیلد الزامی است.'; }
      else if (min && v.length < min) { msg = 'لطفاً کمی دقیق‌تر بنویسید (حداقل ' + fa(min) + ' نویسه).'; }
      showError(f.id, msg, f);
      if (msg) { bad(f); }
    });

    qsa('[data-kind="url"]', root).forEach(function (f) {
      var v = f.value.trim();
      var msg = v && !validUrl(v) ? 'نشانی واردشده معتبر نیست؛ مثلاً example.com' : '';
      showError(f.id, msg, f);
      if (msg) { bad(f); }
    });

    var consent = qs('[data-consent-required]', root);
    if (consent) {
      var cMsg = consent.checked ? '' : 'برای تکمیل درخواست باید این مورد را تأیید کنید.';
      showError('consent', cMsg, consent);
      if (cMsg) { bad(consent); }
    }

    summary.hidden = ok;
    if (!ok && firstBad) { firstBad.focus(); }
    return ok;
  }

  // live re-validation of a field once it has been flagged
  form.addEventListener('input', function (e) {
    var t = e.target;
    if (t.getAttribute && t.getAttribute('aria-invalid') === 'true' && t.id) {
      var step = t.closest('[data-step]');
      if (step) { validateStep(steps.indexOf(step)); }
    }
  });
  form.addEventListener('change', function (e) {
    var t = e.target;
    if (t.name === 'category') { applyConditions(); }
    if (t.type === 'radio' || t.type === 'checkbox') {
      var fs = t.closest('[data-required-group]');
      if (fs && !fs.closest('.wiz-cond[hidden]')) { showError(fs.getAttribute('data-required-group'), '', fs); fs.removeAttribute('aria-invalid'); }
      if (t.hasAttribute('data-consent-required') && t.checked) { showError('consent', '', t); }
    }
    if (t.type === 'file') {
      var list = qs('[data-attach-list]', form);
      list.innerHTML = '';
      Array.prototype.forEach.call(t.files, function (f) {
        var li = document.createElement('li'); li.textContent = f.name + ' (نمایشی — بارگذاری نمی‌شود)'; list.appendChild(li);
      });
    }
  });

  /* ---- review ---------------------------------------------------------- */
  function valueOf(field) {
    var radios = qsa('input[type="radio"]:checked', field);
    if (radios.length) { return textOfChoice(radios[0]); }
    var checks = qsa('input[type="checkbox"]:checked', field);
    if (checks.length) { return checks.map(textOfChoice).join('، '); }
    var sel = qs('select', field);
    if (sel) { return sel.value ? sel.options[sel.selectedIndex].text : ''; }
    var file = qs('input[type="file"]', field);
    if (file) { return Array.prototype.map.call(file.files, function (f) { return f.name; }).join('، '); }
    var txt = qs('input[type="text"], textarea', field);
    return txt ? txt.value.trim() : '';
  }
  function textOfChoice(input) {
    var t = qs('.choice__title', input.closest('.choice'));
    return t ? t.textContent.trim() : input.value;
  }
  function buildReview() {
    var host = qs('[data-review]', form);
    host.innerHTML = '';
    steps.slice(0, total - 1).forEach(function (step, i) {
      var fields = qsa('[data-field][data-label]', step).filter(function (f) { return !f.closest('.wiz-cond[hidden]') && !!qs('input:not(:disabled), textarea:not(:disabled), select:not(:disabled)', f); });
      if (!fields.length) { return; }
      var block = document.createElement('section'); block.className = 'review__block';
      var head = document.createElement('div'); head.className = 'review__head';
      var h = document.createElement('h3'); h.textContent = step.getAttribute('data-label');
      var edit = document.createElement('button'); edit.type = 'button'; edit.className = 'edit-btn'; edit.setAttribute('data-goto', i);
      edit.innerHTML = '<i class="bi bi-pencil" aria-hidden="true"></i>'; edit.appendChild(document.createTextNode('ویرایش'));
      edit.setAttribute('aria-label', 'ویرایش بخش ' + step.getAttribute('data-label'));
      head.appendChild(h); head.appendChild(edit); block.appendChild(head);
      var dl = document.createElement('dl');
      fields.forEach(function (f) {
        var dt = document.createElement('dt'); dt.textContent = f.getAttribute('data-label');
        var dd = document.createElement('dd'); var v = valueOf(f);
        dd.textContent = v || 'ثبت نشده'; if (!v) { dd.className = 'is-empty'; }
        dl.appendChild(dt); dl.appendChild(dd);
      });
      block.appendChild(dl); host.appendChild(block);
    });
  }
  form.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-goto]');
    if (btn) { show(parseInt(btn.getAttribute('data-goto'), 10)); }
  });

  /* ---- navigation ------------------------------------------------------ */
  function show(i, silent) {
    cur = Math.max(0, Math.min(total - 1, i));
    steps.forEach(function (s, idx) { s.hidden = idx !== cur; });
    if (cur === 2) { applyConditions(); }
    if (cur === total - 1) { buildReview(); }
    prevBtn.hidden = cur === 0;
    nextBtn.hidden = cur === total - 1;
    submitBtn.hidden = cur !== total - 1;
    summary.hidden = true;
    qs('[data-cur]', progress).textContent = fa(cur + 1);
    qs('[data-step-label]', progress).textContent = steps[cur].getAttribute('data-label');
    fill.style.inlineSize = ((cur + 1) / total * 100) + '%';
    bar.setAttribute('aria-valuenow', String(cur + 1));
    dots.forEach(function (d, idx) { d.classList.toggle('is-current', idx === cur); d.classList.toggle('is-done', idx < cur); });
    if (live) { live.textContent = 'مرحلهٔ ' + fa(cur + 1) + ' از ' + fa(total) + ': ' + steps[cur].getAttribute('data-label'); }
    if (!silent) {
      var h = qs('h2', steps[cur]);
      if (h) { h.focus({ preventScroll: true }); }
      var top = qs('.wiz-card').getBoundingClientRect().top + window.pageYOffset - 90;
      window.scrollTo({ top: top, behavior: reduce ? 'auto' : 'smooth' });
    }
  }
  function next() { if (validateStep(cur)) { show(cur + 1); } }
  nextBtn.addEventListener('click', next);
  prevBtn.addEventListener('click', function () { show(cur - 1); });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (cur < total - 1) { next(); return; }
    // validate every earlier step too, jump to the first problem
    for (var i = 0; i < total; i++) {
      if (!validateStep(i)) { if (i !== cur) { show(i); validateStep(i); } return; }
    }
    // DEMO ONLY: nothing is sent anywhere.
    form.hidden = true; progress.hidden = true; done.hidden = false;
    var t = qs('[data-done-title]', done); if (t) { t.focus(); }
    if (live) { live.textContent = 'پایان نمایش آزمایشی؛ درخواست ثبت یا ارسال نشد.'; }
  });
  var back = qs('[data-back-to-review]');
  if (back) { back.addEventListener('click', function () { done.hidden = true; form.hidden = false; progress.hidden = false; show(total - 1); }); }

  /* ---- init ------------------------------------------------------------ */
  var preset = (new URLSearchParams(window.location.search)).get('category');
  var presetInput = preset ? qs('input[name="category"][value="' + preset.replace(/[^a-z-]/g, '') + '"]', form) : null;
  if (presetInput) { presetInput.checked = true; applyConditions(); show(1, true); } else { applyConditions(); show(0, true); }
})();
