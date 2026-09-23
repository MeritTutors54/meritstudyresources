/* Merit Study Resources — resource page behaviour
   Course context from the URL, client-side filtering and search over the
   sample rows, deep-linkable tabs. No backend. */
(function () {
    'use strict';

    function onReady(fn) {
        if (document.readyState !== 'loading') { fn(); }
        else { document.addEventListener('DOMContentLoaded', fn); }
    }

    onReady(function () {

        /* -------------------------------------------------------------
           1. Course context
           The homepage finder links here as:
           resources.html?qualification=GCSE&subject=Mathematics&examBoard=Edexcel&tier=Higher+Tier
           Anything missing keeps the default already in the markup.
           ------------------------------------------------------------- */
        var params = new URLSearchParams(window.location.search);
        var specCodes = {          // illustrative — replace with real spec codes
            'GCSE|Mathematics': '1MA1',
            'GCSE|Biology': '1BI0',
            'GCSE|Chemistry': '1CH0',
            'GCSE|Physics': '1PH0',
            'A Level|Mathematics': '9MA0'
        };

        var course = {
            qualification: params.get('qualification') || 'GCSE',
            subject: params.get('subject') || 'Mathematics',
            board: params.get('examBoard') || 'Edexcel',
            tier: params.get('tier') || 'Higher Tier'
        };

        function setCourseField(name, value) {
            Array.prototype.forEach.call(
                document.querySelectorAll('[data-course="' + name + '"]'),
                function (el) { el.textContent = value; }
            );
        }

        setCourseField('qualification', course.qualification);
        setCourseField('qualification-link', course.qualification);
        setCourseField('subject', course.subject);
        setCourseField('subject-link', course.subject);
        setCourseField('board', course.board);
        setCourseField('board-name', course.board);
        setCourseField('tier', course.tier);
        setCourseField('spec', specCodes[course.qualification + '|' + course.subject] || '—');

        document.title = course.qualification + ' ' + course.subject + ' (' + course.board +
            ') resources — Merit Study Resources';

        // Hide the tier chip when the course has no tiers
        var tierChip = document.querySelector('.course-chip-tier');
        if (tierChip && !params.get('tier') && course.qualification !== 'GCSE') {
            tierChip.hidden = true;
        }

        /* -------------------------------------------------------------
           2. Deep-linkable tabs — resources.html#notes opens that tab,
           and switching tabs updates the hash.
           ------------------------------------------------------------- */
        var tabMap = {
            all: 'tab-all',
            papers: 'tab-papers',
            notes: 'tab-notes',
            questions: 'tab-questions',
            tests: 'tab-tests',
            workbooks: 'tab-workbooks',
            solutions: 'tab-solutions'
        };

        function showTab(id) {
            var trigger = document.getElementById(id);
            if (trigger && window.bootstrap) { bootstrap.Tab.getOrCreateInstance(trigger).show(); }
        }

        var initialHash = window.location.hash.replace('#', '');
        if (tabMap[initialHash]) { showTab(tabMap[initialHash]); }

        Array.prototype.forEach.call(document.querySelectorAll('#resourceTabs [data-bs-toggle="tab"]'), function (tab) {
            tab.addEventListener('shown.bs.tab', function () {
                var key = Object.keys(tabMap).filter(function (k) { return tabMap[k] === tab.id; })[0];
                if (key && history.replaceState) {
                    history.replaceState(null, '', key === 'all' ? window.location.pathname + window.location.search : '#' + key);
                }
                applyFilters();
            });
        });

        // Summary cards on the "All resources" pane jump to their tab
        Array.prototype.forEach.call(document.querySelectorAll('[data-goto]'), function (card) {
            card.addEventListener('click', function () { showTab(card.dataset.goto); });
        });

        /* -------------------------------------------------------------
           3. Filtering and in-page search
           Rows carry data-tier / data-series / data-paper / data-source /
           data-keywords. Topic items carry data-keywords only.
           ------------------------------------------------------------- */
        var searchInput = document.getElementById('resourceSearch');
        var emptyState = document.getElementById('emptyState');
        var clearBtn = document.getElementById('clearFilters');
        var filterInputs = document.querySelectorAll('[data-filter]');

        function checkedValues(name) {
            var values = [];
            Array.prototype.forEach.call(
                document.querySelectorAll('[data-filter="' + name + '"]'),
                function (input) { if (input.checked && input.value) { values.push(input.value); } }
            );
            return values;
        }

        function matches(el, query, tier, series, papers, sources) {
            var data = el.dataset;

            if (query) {
                var haystack = ((data.keywords || '') + ' ' + el.textContent).toLowerCase();
                if (haystack.indexOf(query) === -1) { return false; }
            }
            if (tier && data.tier && data.tier !== tier) { return false; }
            if (series.length && data.series && series.indexOf(data.series) === -1) { return false; }
            if (papers.length && data.paper && papers.indexOf(data.paper) === -1) { return false; }
            if (sources.length && data.source && sources.indexOf(data.source) === -1) { return false; }
            return true;
        }

        function applyFilters() {
            var query = (searchInput.value || '').trim().toLowerCase();
            var tier = checkedValues('tier')[0] || '';
            var series = checkedValues('series');
            var papers = checkedValues('paper');
            var sources = checkedValues('source');

            var activePane = document.querySelector('.tab-pane.active');
            if (!activePane) { return; }

            var visible = 0;

            Array.prototype.forEach.call(
                activePane.querySelectorAll('.resource-row, .topic-item'),
                function (el) {
                    var show = matches(el, query, tier, series, papers, sources);
                    el.hidden = !show;
                    if (show) { visible++; }
                }
            );

            // Collapse an accordion section whose items have all been filtered out
            Array.prototype.forEach.call(activePane.querySelectorAll('.accordion-item'), function (item) {
                var rows = item.querySelectorAll('.resource-row, .topic-item');
                var anyVisible = Array.prototype.some.call(rows, function (row) { return !row.hidden; });
                item.hidden = rows.length > 0 && !anyVisible;
            });

            emptyState.hidden = visible > 0;
        }

        if (searchInput) { searchInput.addEventListener('input', applyFilters); }

        Array.prototype.forEach.call(filterInputs, function (input) {
            input.addEventListener('change', applyFilters);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                Array.prototype.forEach.call(filterInputs, function (input) {
                    if (input.type === 'checkbox') { input.checked = true; }
                    if (input.type === 'radio') { input.checked = input.id === 'tier-both'; }
                });
                applyFilters();
                searchInput.focus();
            });
        }

        applyFilters();
    });
})();