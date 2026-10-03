/* Merit Study Resources — front-end behaviour
   No backend: each handler shows how the selected values would be passed on.
   Loaded with `defer` from <head> so motion states apply before first paint. */
(function () {
  'use strict';

  var root = document.documentElement;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Enables the motion layer. Without JS the page renders fully visible.
  root.classList.add('js');

  function onReady(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
  }

  onReady(function () {

    /* -------------------------------------------------------------
       Hero entrance — one orchestrated sequence on load.
       ------------------------------------------------------------- */
    Array.prototype.forEach.call(document.querySelectorAll('.book'), function (book, i) {
      book.style.setProperty('--book-index', i);
    });

    requestAnimationFrame(function () {
      root.classList.add('is-ready');
    });

    /* -------------------------------------------------------------
       Scroll reveal — each element animates once, then is left alone.
       [data-reveal]       a single element
       [data-reveal-group] its direct children, staggered
       ------------------------------------------------------------- */
    var targets = Array.prototype.slice.call(document.querySelectorAll('[data-reveal]'));

    Array.prototype.forEach.call(document.querySelectorAll('[data-reveal-group]'), function (group) {
      Array.prototype.forEach.call(group.children, function (child, i) {
        child.setAttribute('data-reveal-item', '');
        child.style.setProperty('--reveal-index', i % 6);
        targets.push(child);
      });
    });

    if (reduceMotion || !('IntersectionObserver' in window)) {
      targets.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
      var revealObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.1 });

      targets.forEach(function (el) { revealObserver.observe(el); });
    }

    /* -------------------------------------------------------------
       Cookie notice — remembers the choice in localStorage. Analytics
       scripts should only load when getConsent() === 'all'.
       ------------------------------------------------------------- */
    var CONSENT_KEY = 'msr_consent';

    function getConsent() {
      try { return localStorage.getItem(CONSENT_KEY); } catch (e) { return 'unavailable'; }
    }

    function setConsent(value) {
      try { localStorage.setItem(CONSENT_KEY, value); } catch (e) { /* private mode */ }
    }

    if (!getConsent()) {
      var cookieBanner = document.createElement('aside');
      cookieBanner.className = 'cookie-banner';
      cookieBanner.setAttribute('role', 'region');
      cookieBanner.setAttribute('aria-label', 'Cookie notice');
      cookieBanner.innerHTML =
        '<p class="cookie-text">We use essential cookies to run the site, and optional ones to see ' +
        'which resources get used. No advertising, ever. <a href="cookies.html">Cookie policy</a>.</p>' +
        '<div class="cookie-actions">' +
          '<button type="button" class="btn btn-soft" data-consent="essential">Essential only</button>' +
          '<button type="button" class="btn btn-merit btn-sm" data-consent="all">Accept all</button>' +
        '</div>';

      document.body.appendChild(cookieBanner);

      Array.prototype.forEach.call(cookieBanner.querySelectorAll('[data-consent]'), function (btn) {
        btn.addEventListener('click', function () {
          setConsent(btn.dataset.consent);
          cookieBanner.remove();
        });
      });
    }

    /* -------------------------------------------------------------
       Sticky nav — hairline shadow once the bar reaches the top.
       ------------------------------------------------------------- */
    var nav = document.querySelector('.main-nav');

    if (nav && 'IntersectionObserver' in window) {
      var sentinel = document.createElement('div');
      sentinel.setAttribute('aria-hidden', 'true');
      nav.parentNode.insertBefore(sentinel, nav);

      new IntersectionObserver(function (entries) {
        nav.classList.toggle('is-stuck', !entries[0].isIntersecting);
      }, { threshold: 1 }).observe(sentinel);
    }

    /* -------------------------------------------------------------
       Resource finder — builds the URL a real listing page would use.
       Replace the demo message with: window.location.href = url;
       ------------------------------------------------------------- */
    var finder = document.getElementById('resourceFinder');
    var finderResult = document.getElementById('finderResult');

    if (finder && finderResult) {
      finder.addEventListener('submit', function (event) {
        event.preventDefault();

        var params = new URLSearchParams();
        var chosen = [];

        new FormData(finder).forEach(function (value, key) {
          if (value) {
            params.set(key, value);
            chosen.push(value);
          }
        });

        if (!chosen.length) {
          finderResult.textContent = 'Choose at least one option to see matching resources.';
          document.getElementById('qualification').focus();
          return;
        }

        // Hands the selection to the resource page, which reads these params.
        finderResult.textContent = 'Opening resources for ' + chosen.join(' · ') + '…';
        window.location.href = 'resources.html?' + params.toString();
      });
    }

    /* -------------------------------------------------------------
       Header search — demonstrates how a query would be handed over.
       ------------------------------------------------------------- */
    var searchForm = document.getElementById('siteSearchForm');
    var searchFeedback = document.getElementById('searchFeedback');

    if (searchForm && searchFeedback) {
      searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var query = document.getElementById('siteSearch').value.trim();

        searchFeedback.textContent = query
          ? 'Searching for “' + query + '” → /search?q=' + encodeURIComponent(query)
          : 'Type a topic, paper or subject to search.';
      });
    }

    /* -------------------------------------------------------------
       Popular this week — filter pills.
       Swap the demo text for a fetch/render call when data is wired up.
       ------------------------------------------------------------- */
    var pills = document.querySelectorAll('.filter-pill');

    Array.prototype.forEach.call(pills, function (pill) {
      pill.addEventListener('click', function () {
        Array.prototype.forEach.call(pills, function (other) {
          other.classList.toggle('is-active', other === pill);
          other.setAttribute('aria-pressed', other === pill ? 'true' : 'false');
        });
        // Hook point: loadPopular(pill.dataset.filter);
      });
    });
  });
})();
