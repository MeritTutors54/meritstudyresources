/* =============================================================
   Merit Study Resources — /bookshops page behaviour (vanilla JS)
   Requires bootstrap.bundle.min.js (Collapse) loaded first.

   Handles:
   - Year filter chips            (design A)   [data-msr-filter]
   - Search box                   (A, B, C)    [data-msr-search]
   - Sidebar book switching       (design B)   [data-msr-book]
   - Year section open/closed bg  (design C)
   - QR deep links: /bookshops?book=y1-b2  or  /bookshops#y1-b2
       -> selects the year, opens the book's downloads, scrolls to it
   ============================================================= */
(function () {
  'use strict';

  var page = document.body.getAttribute('data-msr-page') || 'a';
  var lastYear = null;

  function $(sel, root) { return (root || document).querySelector(sel); }
  function $$(sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); }
  function showCollapse(el) { if (el && window.bootstrap) { bootstrap.Collapse.getOrCreateInstance(el, { toggle: false }).show(); } }
  function highlight(card) {
    if (!card) { return; }
    card.classList.add('msr-highlight');
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(function () { card.classList.remove('msr-highlight'); }, 3500);
  }
  function terms(q) { return q.toLowerCase().trim().split(/\s+/).filter(Boolean); }
  /* phrase match first ("target grade 5" -> only Grade 5); if nothing matches the phrase, fall back to all-words-anywhere */
  var usePhrase = false;
  function phraseOf(ts) { return ts.join(' '); }
  function anyPhrase(sel, ts) { var ph = phraseOf(ts); return $$(sel).some(function (el) { return (el.getAttribute('data-search') || '').toLowerCase().indexOf(ph) !== -1; }); }
  function matches(hay, ts) {
    hay = (hay || '').toLowerCase();
    if (usePhrase) { return hay.indexOf(phraseOf(ts)) !== -1; }
    return ts.every(function (t) { return hay.indexOf(t) !== -1; });
  }

  /* ---------- Design A: year filter ---------- */
  function setYear(id) {
    var chips = $$('[data-msr-filter]');
    if (!chips.length) { return; }
    lastYear = id;
    chips.forEach(function (c) {
      var on = c.getAttribute('data-msr-filter') === id;
      c.classList.toggle('active', on);
      c.setAttribute('aria-pressed', on ? 'true' : 'false');
      if (on) {
        var t = $('[data-msr="year-title"]'); if (t) { t.textContent = c.getAttribute('data-title') || c.textContent; }
        var s = $('[data-msr="year-sub"]'); if (s) { s.textContent = c.getAttribute('data-sub') || ''; }
      }
    });
    var n = 0;
    $$('.msr-book-col').forEach(function (col) {
      var on = col.getAttribute('data-year') === id;
      col.classList.toggle('d-none', !on);
      if (on) { n++; }
    });
    var empty = $('[data-msr="empty"]'); if (empty) { empty.classList.toggle('d-none', n > 0); }
  }
  $$('[data-msr-filter]').forEach(function (chip) {
    chip.addEventListener('click', function () {
      var input = $('[data-msr-search]'); if (input) { input.value = ''; }
      setYear(chip.getAttribute('data-msr-filter'));
    });
  });

  /* ---------- Search (all designs) ---------- */
  function search(q) {
    var ts = terms(q);
    usePhrase = ts.length > 1 && anyPhrase('[data-search]', ts);
    if (page === 'a') {
      if (!ts.length) { setYear(lastYear || ($('[data-msr-filter]') && $('[data-msr-filter]').getAttribute('data-msr-filter'))); return; }
      var n = 0;
      $$('.msr-book-col').forEach(function (col) {
        var on = matches(col.getAttribute('data-search'), ts);
        col.classList.toggle('d-none', !on); if (on) { n++; }
      });
      $$('[data-msr-filter]').forEach(function (c) { c.classList.remove('active'); c.setAttribute('aria-pressed', 'false'); });
      var t = $('[data-msr="year-title"]'); if (t) { t.textContent = 'Search results'; }
      var s = $('[data-msr="year-sub"]'); if (s) { s.textContent = n + (n === 1 ? ' book matches ' : ' books match ') + '“' + q.trim() + '”'; }
      var empty = $('[data-msr="empty"]'); if (empty) { empty.classList.toggle('d-none', n > 0); }
    } else if (page === 'c') {
      $$('.msr-year').forEach(function (sec) {
        var any = false;
        $$('[data-search]', sec).forEach(function (col) {
          var on = !ts.length || matches(col.getAttribute('data-search'), ts);
          col.classList.toggle('d-none', !on); if (on) { any = true; }
        });
        var hasBooks = $$('[data-search]', sec).length > 0;
        sec.classList.toggle('d-none', ts.length > 0 && !any);
        if (ts.length && any && hasBooks) { showCollapse($('.collapse', sec)); }
      });
    } else if (page === 'b') {
      $$('[data-msr-book]').forEach(function (a) {
        var on = !ts.length || matches(a.getAttribute('data-search'), ts);
        a.classList.toggle('d-none', !on);
        if (on && ts.length) { showCollapse(a.closest('.accordion-collapse')); }
      });
    }
  }
  $$('[data-msr-search]').forEach(function (input) {
    input.addEventListener('input', function () { search(input.value); });
    var form = input.closest('form');
    if (form) { form.addEventListener('submit', function (e) { e.preventDefault(); search(input.value); if (page === 'a') { var g = $('[data-msr="grid"]'); if (g) { g.scrollIntoView({ behavior: 'smooth', block: 'start' }); } } }); }
  });

  /* ---------- Design B: sidebar book switching (demo only — in Laravel each book is its own route) ---------- */
  function setText(key, val) { $$('[data-msr="' + key + '"]').forEach(function (el) { el.textContent = val; }); }
  function selectBook(link, scroll, keepHash) {
    if (!link) { return false; }
    var d = link.dataset;
    $$('[data-msr-book]').forEach(function (a) { a.classList.toggle('active', a === link); if (a === link) { a.setAttribute('aria-current', 'page'); } else { a.removeAttribute('aria-current'); } });
    showCollapse(link.closest('.accordion-collapse'));
    setText('title', d.title); setText('year', d.year); setText('n', d.n); setText('of', d.of);
    setText('blurb', d.blurb); setText('format', d.format); setText('series', d.series); setText('code', d.code);
    setText('year-upper', (d.year || '').toUpperCase());
    $$('[data-msr="cover"]').forEach(function (el) { el.style.setProperty('--cover', d.color); });
    $$('[data-msr="accent"]').forEach(function (el) { el.style.color = d.color; });
    $$('[data-msr-dl]').forEach(function (a) { a.setAttribute('href', '/downloads/' + d.slug + '/book-' + d.n + '/' + a.getAttribute('data-msr-dl')); });
    var amazon = $('[data-msr="amazon"]'); if (amazon && d.amazon) { amazon.setAttribute('href', d.amazon); }
    /* rebuild "Other books in this year" from the sibling links */
    var others = $('[data-msr="others"]');
    if (others) {
      var group = link.closest('.accordion-collapse');
      var html = '';
      $$('[data-msr-book]', group).filter(function (a) { return a !== link; }).slice(0, 3).forEach(function (a) {
        var o = a.dataset;
        html += '<div class="col-sm-6 col-xl-4"><a class="msr-mini" href="#' + o.id + '" data-msr-goto="' + o.id + '">' +
          '<span class="msr-cover msr-cover-xs" style="--cover:' + o.color + '"></span>' +
          '<span class="d-flex flex-column gap-1 min-w-0"><span class="msr-mini-eyebrow" style="--cover:' + o.color + '">Book ' + o.n + '</span>' +
          '<span class="fw-bold">' + o.title + '</span><span class="small text-muted">View book &amp; downloads</span></span></a></div>';
      });
      others.innerHTML = html;
    }
    if (!keepHash && history.replaceState) { history.replaceState(null, '', '#' + d.id); }
    if (scroll) { var main = $('[data-msr="book-card"]'); if (main) { main.scrollIntoView({ behavior: 'smooth', block: 'start' }); } }
    return true;
  }
  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-msr-book]');
    if (a) { e.preventDefault(); selectBook(a, window.innerWidth < 992); return; }
    var g = e.target.closest('[data-msr-goto]');
    if (g) { e.preventDefault(); selectBook($('[data-msr-book][data-id="' + g.getAttribute('data-msr-goto') + '"]'), true); }
  });

  /* ---------- Design C: section background follows open/closed ---------- */
  document.addEventListener('shown.bs.collapse', function (e) { var sec = e.target.closest('.msr-year'); if (sec) { sec.classList.add('is-open'); } });
  document.addEventListener('hidden.bs.collapse', function (e) { var sec = e.target.closest('.msr-year'); if (sec) { sec.classList.remove('is-open'); } });

  /* ---------- QR deep link: ?book=y1-b2 or #y1-b2 ---------- */
  function deepLink() {
    var id = new URLSearchParams(location.search).get('book') || location.hash.replace('#', '');
    if (!/^[a-z0-9]+-b\d+$/.test(id)) { return false; }
    if (page === 'a') {
      var card = document.getElementById(id); if (!card) { return false; }
      var col = card.closest('.msr-book-col');
      if (col) { setYear(col.getAttribute('data-year')); }
      showCollapse($('#dl-' + id));
      setTimeout(function () { highlight(card); }, 150);
    } else if (page === 'b') {
      return selectBook($('[data-msr-book][data-id="' + id + '"]'), false);
    } else if (page === 'c') {
      var c = document.getElementById(id); if (!c) { return false; }
      var sec = c.closest('.msr-year');
      if (sec) { showCollapse($('.collapse', sec)); }
      setTimeout(function () { highlight(c); }, 350);
    }
    return true;
  }

  /* ---------- Init ---------- */
  var first = $('[data-msr-filter].active') || $('[data-msr-filter]');
  if (first) { setYear(first.getAttribute('data-msr-filter')); }
  if (!deepLink() && page === 'b') { var cur = $('[data-msr-book].active'); if (cur) { selectBook(cur, false, true); } }
  window.addEventListener('hashchange', deepLink);
})();
