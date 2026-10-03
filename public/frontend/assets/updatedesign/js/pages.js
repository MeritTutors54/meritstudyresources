/* Merit Study Resources — behaviour for the auth, blog, policy, contact,
   FAQ and dashboard pages. Every form is a front-end demo: nothing is sent. */
(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
  }

  function each(list, fn) { Array.prototype.forEach.call(list, fn); }

  ready(function () {

    /* -------------------------------------------------------------
       1. Password visibility
       ------------------------------------------------------------- */
    each(document.querySelectorAll('[data-password-toggle]'), function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.passwordToggle);
        if (!input) { return; }
        var showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        btn.innerHTML = showing
          ? '<i class="bi bi-eye" aria-hidden="true"></i>'
          : '<i class="bi bi-eye-slash" aria-hidden="true"></i>';
      });
    });

    /* -------------------------------------------------------------
       2. Password strength — a rough guide, not a security check
       ------------------------------------------------------------- */
    var strengthBar = document.querySelector('[data-strength-bar]');
    var strengthLabel = document.querySelector('[data-strength-label]');
    var pwField = document.getElementById('password');

    if (strengthBar && pwField) {
      pwField.addEventListener('input', function () {
        var value = pwField.value;
        var score = 0;
        if (value.length >= 8) { score++; }
        if (value.length >= 12) { score++; }
        if (/[^a-zA-Z0-9]/.test(value) || /\d/.test(value)) { score++; }

        var states = [
          { width: '0%', cls: '', text: 'Use 8 characters or more. A short phrase works well.' },
          { width: '33%', cls: 'is-weak', text: 'A bit short — longer is stronger than complicated.' },
          { width: '66%', cls: 'is-ok', text: 'Reasonable. A few more characters would help.' },
          { width: '100%', cls: 'is-good', text: 'Strong enough.' }
        ];
        var state = states[value ? score : 0];

        strengthBar.style.width = state.width;
        strengthBar.className = 'strength-bar ' + state.cls;
        if (strengthLabel) { strengthLabel.textContent = state.text; }
      });
    }

    /* -------------------------------------------------------------
       3. Form validation + demo submit
       Uses the browser's own constraint validation, then shows the
       matching .field-error. Replace the success branch with a real
       fetch() / form POST when a backend exists.
       ------------------------------------------------------------- */
    each(document.querySelectorAll('[data-demo-form]'), function (form) {
      var status = form.querySelector('[data-form-status]');

      function showError(field, show) {
        var msg = form.querySelector('[data-error-for="' + field.id + '"]');
        field.classList.toggle('is-invalid', show);
        if (msg) { msg.classList.toggle('is-shown', show); }
      }

      each(form.querySelectorAll('input, select, textarea'), function (field) {
        field.addEventListener('blur', function () {
          if (field.value || field.required) { showError(field, !field.checkValidity()); }
        });
        field.addEventListener('input', function () {
          if (field.checkValidity()) { showError(field, false); }
        });
      });

      form.addEventListener('submit', function (event) {
        event.preventDefault();
        var firstBad = null;

        each(form.querySelectorAll('input, select, textarea'), function (field) {
          var bad = !field.checkValidity();
          showError(field, bad);
          if (bad && !firstBad) { firstBad = field; }
        });

        if (firstBad) {
          if (status) {
            status.textContent = 'Check the highlighted fields.';
            status.classList.add('is-error');
          }
          firstBad.focus();
          return;
        }

        if (status) {
          status.classList.remove('is-error');
          status.textContent = 'Looks good — this preview has no backend, so nothing was sent.';
        }
      });
    });

    // Buttons that only exist to show intent in the preview
    each(document.querySelectorAll('[data-demo]'), function (el) {
      el.addEventListener('click', function (event) {
        event.preventDefault();
        var status = document.querySelector('[data-form-status]');
        if (status) {
          status.classList.remove('is-error');
          status.textContent = el.dataset.demo;
        } else {
          alert(el.dataset.demo);
        }
      });
    });

    /* -------------------------------------------------------------
       4. Blog — category pills and search
       ------------------------------------------------------------- */
    var postSearch = document.getElementById('postSearch');
    var postPills = document.querySelectorAll('.blog-filter .filter-pill');
    var postCards = document.querySelectorAll('.post-card');
    var postEmpty = document.getElementById('postEmpty');
    var activeCategory = '';

    function filterPosts() {
      if (!postCards.length) { return; }
      var query = postSearch ? postSearch.value.trim().toLowerCase() : '';
      var visible = 0;

      each(postCards, function (card) {
        var inCategory = !activeCategory || card.dataset.category === activeCategory;
        var inQuery = !query ||
          ((card.dataset.keywords || '') + ' ' + card.textContent).toLowerCase().indexOf(query) !== -1;
        var show = inCategory && inQuery;
        card.hidden = !show;
        if (show) { visible++; }
      });

      each(document.querySelectorAll('[data-post-wrap]'), function (wrap) {
        var cards = wrap.querySelectorAll('.post-card');
        wrap.hidden = cards.length > 0 &&
          !Array.prototype.some.call(cards, function (c) { return !c.hidden; });
      });

      if (postEmpty) { postEmpty.hidden = visible > 0; }
    }

    each(postPills, function (pill) {
      pill.addEventListener('click', function () {
        activeCategory = pill.dataset.category || '';
        each(postPills, function (other) {
          var on = other === pill;
          other.classList.toggle('is-active', on);
          other.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        filterPosts();
      });
    });
    if (postSearch) { postSearch.addEventListener('input', filterPosts); }

    /* -------------------------------------------------------------
       5. FAQ search — filters questions and hides empty categories
       ------------------------------------------------------------- */
    var faqSearch = document.getElementById('faqSearch');
    var faqEmpty = document.getElementById('faqEmpty');

    if (faqSearch) {
      faqSearch.addEventListener('input', function () {
        var query = faqSearch.value.trim().toLowerCase();
        var visible = 0;

        each(document.querySelectorAll('.faq-item'), function (item) {
          var show = !query ||
            ((item.dataset.keywords || '') + ' ' + item.textContent).toLowerCase().indexOf(query) !== -1;
          item.hidden = !show;
          if (show) { visible++; }
        });

        each(document.querySelectorAll('.faq-group'), function (group) {
          var items = group.querySelectorAll('.faq-item');
          var any = Array.prototype.some.call(items, function (i) { return !i.hidden; });
          group.hidden = !any;
          var count = group.querySelector('.group-count');
          if (count) {
            var shown = Array.prototype.filter.call(items, function (i) { return !i.hidden; }).length;
            count.textContent = shown + (shown === 1 ? ' question' : ' questions');
          }
        });

        if (faqEmpty) { faqEmpty.hidden = visible > 0; }
      });
    }

    /* -------------------------------------------------------------
       6. Article contents — highlights the section you are reading
       ------------------------------------------------------------- */
    var tocLinks = document.querySelectorAll('.toc-list a');

    if (tocLinks.length && 'IntersectionObserver' in window) {
      var headings = [];
      each(tocLinks, function (link) {
        var target = document.getElementById(link.getAttribute('href').slice(1));
        if (target) { headings.push({ link: link, target: target }); }
      });

      var tocObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) { return; }
          each(tocLinks, function (l) { l.classList.remove('is-current'); });
          var match = headings.filter(function (h) { return h.target === entry.target; })[0];
          if (match) { match.link.classList.add('is-current'); }
        });
      }, { rootMargin: '-15% 0px -70% 0px' });

      headings.forEach(function (h) { tocObserver.observe(h.target); });
    }

    /* -------------------------------------------------------------
       7. Copy link
       ------------------------------------------------------------- */
    each(document.querySelectorAll('[data-copy-link]'), function (btn) {
      var original = btn.innerHTML;
      btn.addEventListener('click', function () {
        var done = function () {
          btn.innerHTML = '<i class="bi bi-check2" aria-hidden="true"></i> Copied';
          setTimeout(function () { btn.innerHTML = original; }, 2000);
        };
        if (navigator.clipboard) {
          navigator.clipboard.writeText(window.location.href).then(done, function () {});
        }
      });
    });
  });
})();
