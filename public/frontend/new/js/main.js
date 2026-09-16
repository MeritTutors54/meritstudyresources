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

        // Demo only — a live site would navigate to this address.
        finderResult.textContent =
          'Showing resources for ' + chosen.join(' · ') + ' → /resources?' + params.toString();
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
