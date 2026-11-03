(function () {
  'use strict';

  var TOKEN_KEY = 'sd_auth_token';
  var apiBase = (window.SD_AUTH && window.SD_AUTH.apiBase) || '/api/v1/auth';

  function getToken() {
    try {
      return localStorage.getItem(TOKEN_KEY) || '';
    } catch (e) {
      return '';
    }
  }

  function setToken(token) {
    try {
      localStorage.setItem(TOKEN_KEY, token);
    } catch (e) { /* ignore */ }
  }

  function clearToken() {
    try {
      localStorage.removeItem(TOKEN_KEY);
    } catch (e) { /* ignore */ }
  }

  function redirectAfterAuth() {
    var params = new URLSearchParams(window.location.search);
    var next = params.get('next');
    if (next === 'project-request') {
      window.location.href = (window.SD_AUTH && window.SD_AUTH.projectRequestUrl) || '/project-request';
      return;
    }
    if (next && /^\/[a-z0-9\-\/]*$/i.test(next)) {
      window.location.href = next;
      return;
    }
    window.location.href = (window.SD_AUTH && window.SD_AUTH.projectRequestUrl) || '/project-request';
  }

  function parseJsonResponse(res) {
    return res.text().then(function (text) {
      if (!text) {
        return {};
      }
      try {
        return JSON.parse(text);
      } catch (e) {
        return { message: text };
      }
    });
  }

  function api(path, options) {
    options = options || {};
    var headers = Object.assign(
      { Accept: 'application/json', 'Content-Type': 'application/json' },
      options.headers || {}
    );
    var token = getToken();
    if (token) {
      headers.Authorization = 'Bearer ' + token;
    }
    return fetch(apiBase + path, {
      method: options.method || 'GET',
      headers: headers,
      body: options.body ? JSON.stringify(options.body) : undefined,
      credentials: 'same-origin',
    }).then(function (res) {
      return parseJsonResponse(res).then(function (data) {
        return { ok: res.ok, status: res.status, data: data };
      });
    });
  }

  function firstErrorMessage(payload) {
    if (!payload) {
      return 'خطایی رخ داد. دوباره تلاش کنید.';
    }
    if (payload.message && typeof payload.message === 'string') {
      return payload.message;
    }
    if (payload.errors && typeof payload.errors === 'object') {
      var keys = Object.keys(payload.errors);
      if (keys.length && payload.errors[keys[0]] && payload.errors[keys[0]][0]) {
        return payload.errors[keys[0]][0];
      }
    }
    return 'خطایی رخ داد. دوباره تلاش کنید.';
  }

  function persistAuthPayload(payload) {
    if (payload && payload.data && payload.data.token) {
      setToken(payload.data.token);
    }
  }

  window.SdAuth = {
    getToken: getToken,
    setToken: setToken,
    clearToken: clearToken,
    redirectAfterAuth: redirectAfterAuth,
    firstErrorMessage: firstErrorMessage,
    api: api,
    me: function () {
      if (!getToken()) {
        return Promise.resolve({ ok: false, status: 401, data: null });
      }
      return api('/me');
    },
    login: function (phone, password) {
      return api('/login', { method: 'POST', body: { phone: phone, password: password } });
    },
    register: function (body) {
      return api('/register', { method: 'POST', body: body });
    },
    verifyOtp: function (phone, code) {
      return api('/verify-otp', { method: 'POST', body: { phone: phone, code: code } }).then(function (result) {
        if (result.ok) {
          persistAuthPayload(result.data);
        }
        return result;
      });
    },
    resendOtp: function (phone) {
      return api('/resend-otp', { method: 'POST', body: { phone: phone } });
    },
    logout: function () {
      return api('/logout', { method: 'POST' }).finally(function () {
        clearToken();
      });
    },
  };
})();
