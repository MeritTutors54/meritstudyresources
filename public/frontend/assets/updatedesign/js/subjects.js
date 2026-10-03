/* Merit Study Resources — subjects page
   Client-side search and qualification filtering over the tiles. Each tile
   carries data-quals and data-keywords, so adding a subject needs no JS edit. */
(function () {
  'use strict';

  function onReady(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
  }

  onReady(function () {
    var searchForm = document.getElementById('subjectSearchForm');
    var searchInput = document.getElementById('subjectSearch');
    var countLabel = document.getElementById('subjectCount');
    var emptyState = document.getElementById('subjectEmpty');
    var pills = document.querySelectorAll('.qual-filter .filter-pill');
    var tiles = document.querySelectorAll('.subject-tile');
    var groups = document.querySelectorAll('[data-group]');
    var total = tiles.length;
    var activeQual = '';

    // A qualification can be preselected: subjects.html?qualification=alevel
    var fromUrl = (new URLSearchParams(window.location.search).get('qualification') || '').toLowerCase();
    var urlMap = { 'gcse': 'gcse', 'igcse': 'igcse', 'a level': 'alevel', 'as level': 'alevel', 'alevel': 'alevel' };
    if (urlMap[fromUrl]) { activeQual = urlMap[fromUrl]; }

    function label(count) {
      var qualName = { '': '', 'gcse': ' GCSE', 'igcse': ' IGCSE', 'alevel': ' AS & A Level' }[activeQual];
      if (count === total) { return 'Showing all ' + total + ' subjects'; }
      if (count === 0) { return 'No subjects match'; }
      return 'Showing ' + count + ' of ' + total + qualName + ' subjects';
    }

    function apply() {
      var query = (searchInput.value || '').trim().toLowerCase();
      var visible = 0;

      Array.prototype.forEach.call(tiles, function (tile) {
        var quals = tile.dataset.quals || '';
        var haystack = ((tile.dataset.keywords || '') + ' ' + tile.textContent).toLowerCase();

        var matchesQual = !activeQual || quals.indexOf(activeQual) !== -1;
        var matchesQuery = !query || haystack.indexOf(query) !== -1;
        var show = matchesQual && matchesQuery;

        tile.hidden = !show;
        if (show) { visible++; }
      });

      // Hide a category whose tiles have all been filtered out
      Array.prototype.forEach.call(groups, function (group) {
        var groupTiles = group.querySelectorAll('.subject-tile');
        var anyVisible = Array.prototype.some.call(groupTiles, function (t) { return !t.hidden; });
        group.hidden = !anyVisible;

        var count = group.querySelector('.group-count');
        if (count) {
          var shown = Array.prototype.filter.call(groupTiles, function (t) { return !t.hidden; }).length;
          count.textContent = shown + (shown === 1 ? ' subject' : ' subjects');
        }
      });

      emptyState.hidden = visible > 0;
      countLabel.textContent = label(visible);
    }

    if (searchForm) {
      searchForm.addEventListener('submit', function (e) { e.preventDefault(); });
    }
    if (searchInput) {
      searchInput.addEventListener('input', apply);
    }

    Array.prototype.forEach.call(pills, function (pill) {
      // reflect a qualification that came in from the URL
      var isActive = (pill.dataset.qual || '') === activeQual;
      pill.classList.toggle('is-active', isActive);
      pill.setAttribute('aria-pressed', isActive ? 'true' : 'false');

      pill.addEventListener('click', function () {
        activeQual = pill.dataset.qual || '';
        Array.prototype.forEach.call(pills, function (other) {
          var on = other === pill;
          other.classList.toggle('is-active', on);
          other.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        apply();
      });
    });

    apply();
  });
})();
