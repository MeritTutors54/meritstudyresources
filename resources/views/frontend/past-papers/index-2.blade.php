@extends('layouts.frontend-2')
@section('content')
    <!-- ============================= PAGE HEADER / SEARCH ============================= -->
    <header class="pp-hero">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Past Papers</div>
            <span class="eyebrow"><span class="divider-dot"></span> REVISION LIBRARY</span>
            <h1 class="mt-4 mb-3">All Past Papers, mapped to your <span class="text-green">exact exam board.</span></h1>
            <p class="lead-muted mb-4" style="max-width:560px;">Browse thousands of papers with full mark schemes across
                A
                Level, AS Level, GCSE and IGCSE — filter by subject on the left or search below.</p>

            <div class="pp-search-wrapper">
                <div class="pp-search-row">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <input type="text" id="ppSearchInput" placeholder="Search any subject, e.g. 'Biology' or 'French'"
                           autocomplete="off">
                </div>

                <!-- Dynamic Search Dropdown Panel -->
                <div id="ppSearchResultsPanel" class="search-dropdown-panel d-none">
                    <div id="searchResultsList" class="search-results-list"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================= MAIN CONTENT ============================= -->
    <section class="section-pad" style="padding-top:24px;">
        <div class="container">
            <div class="row gy-4">

                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    @include('frontend.past-papers._sidebar')
                </div>

                <!-- SUBJECT GRID -->
                <div class="col-lg-8">
                    <div id="ppNoResults" class="pp-no-results">
                        <svg viewBox="0 0 24 24" fill="none" width="40" height="40"
                             style="color:var(--muted);margin-bottom:14px;">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        <p class="mb-0">No subjects match your search — try a different term.</p>
                    </div>

                    @include('frontend.past-papers._mainbar')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('ppSearchInput');
            const resultsPanel = document.getElementById('ppSearchResultsPanel');
            const resultsList = document.getElementById('searchResultsList');

            let debounceTimer = null;

            searchInput.addEventListener('input', function () {
                const query = this.value.trim();
                const route = "{{ route('ajax.search.past-papers') }}";

                clearTimeout(debounceTimer);

                if (query.length < 2) {
                    resultsPanel.classList.add('d-none');
                    resultsList.innerHTML = '';
                    return;
                }

                // Debounce: Wait 250ms after user stops typing
                debounceTimer = setTimeout(() => {
                    // 1. Grab CSRF Token from meta tag
                    const csrfToken = "{{ csrf_token() }}";

                    // 2. Perform POST request
                    fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // <-- CSRF Header
                        },
                        body: JSON.stringify({
                            q: query // Send search term in JSON body
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            resultsList.innerHTML = '';

                            if (data.length === 0) {
                                resultsList.innerHTML = '<div class="search-no-results">No subjects or papers found</div>';
                            } else {
                                data.forEach(item => {
                                    const fullTitle = `${item.category_name} ${item.subcategory_name}`.trim();

                                    const row = document.createElement('a');
                                    row.href = item.url;
                                    row.className = 'search-result-item';

                                    row.innerHTML = `
                    <div class="search-result-title">
                        ${fullTitle}
                    </div>
                    <div class="search-badges">
                        ${item.resubcategory_name ? `<span class="badge-board">${item.resubcategory_name}</span>` : ''}
                        ${item.unit_code ? `<span class="badge-code">${item.unit_code}</span>` : ''}
                    </div>
                `;

                                    resultsList.appendChild(row);
                                });
                            }

                            resultsPanel.classList.remove('d-none');
                        })
                        .catch(err => console.error('Search error:', err));
                }, 250);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !resultsPanel.contains(e.target)) {
                    resultsPanel.classList.add('d-none');
                }
            });

            // Re-open panel on refocus if search has query
            searchInput.addEventListener('focus', function () {
                if (this.value.trim().length >= 2 && resultsList.children.length > 0) {
                    resultsPanel.classList.remove('d-none');
                }
            });
        });
    </script>
    <script>
        // Navbar shadow on scroll
        const ppNav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            ppNav.classList.toggle('is-scrolled', window.scrollY > 12);
        });

        // Billing toggle (yearly / monthly)
        function setBilling(mode) {
            document.getElementById('yearlyBtn').classList.toggle('active', mode === 'yearly');
            document.getElementById('monthlyBtn').classList.toggle('active', mode === 'monthly');
            document.querySelectorAll('.price-display').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            document.querySelectorAll('.period-label').forEach(el => {
                el.textContent = mode === 'yearly' ? 'yearly' : 'monthly';
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Sidebar Button Clicks
            document.querySelectorAll('.pp-level-toggle').forEach(btn => {
                btn.addEventListener('click', () => {
                    const categoryId = btn.dataset.target.replace('lvl-', '');
                    const isOpen = btn.getAttribute('aria-expanded') === 'true';

                    closeAll();

                    if (!isOpen) {
                        openCategory(categoryId);
                    }
                });
            });

            // 2. Main Title Clicks
            document.querySelectorAll('.pp-level-title').forEach(title => {
                title.addEventListener('click', () => {
                    const categoryId = title.dataset.toggleBody.replace('grid-', '');
                    const isOpen = title.getAttribute('aria-expanded') === 'true';

                    closeAll();

                    if (!isOpen) {
                        openCategory(categoryId);
                    }
                });
            });

            // 3. Helper: Close everything on both sides
            function closeAll() {
                // Reset Sidebar toggles & bodies
                document.querySelectorAll('.pp-level-toggle').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                    const target = document.getElementById(btn.dataset.target);
                    if (target) target.style.display = 'none';
                });

                // Reset Main titles & bodies
                document.querySelectorAll('.pp-level-title').forEach(title => {
                    title.setAttribute('aria-expanded', 'false');
                    const target = document.getElementById(title.dataset.toggleBody);
                    if (target) target.style.display = 'none';
                });
            }

            // 4. Helper: Open both sides for a specific Category ID
            function openCategory(id) {
                // Open Sidebar elements
                const sideBtn = document.querySelector(`.pp-level-toggle[data-target="lvl-${id}"]`);
                const sideBody = document.getElementById(`lvl-${id}`);

                if (sideBtn) sideBtn.setAttribute('aria-expanded', 'true');
                if (sideBody) sideBody.style.display = 'block';

                // Open Main Grid elements
                const mainTitle = document.querySelector(`.pp-level-title[data-toggle-body="grid-${id}"]`);
                const mainGrid = document.getElementById(`grid-${id}`);

                if (mainTitle) mainTitle.setAttribute('aria-expanded', 'true');
                if (mainGrid) mainGrid.style.display = 'flex';
            }

        });


        // Sidebar subject row expand (show exam boards)
        document.querySelectorAll('.pp-subject-row').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                const isOpen = target.style.display !== 'none';
                document.querySelectorAll('.pp-board-list').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.pp-subject-row').forEach(el => el.classList.remove('active'));
                if (!isOpen) {
                    target.style.display = 'block';
                    btn.classList.add('active');
                }
            });
        });


        // Sidebar "AS Level / GCSE / IGCSE" quick jump
        document.querySelectorAll('.pp-simple-level').forEach(btn => {
            btn.addEventListener('click', () => {
                const label = btn.dataset.scroll;
                const block = document.querySelector(`.pp-level-block[data-level-block="${label}"]`);
                if (!block) return;
                const title = block.querySelector('.pp-level-title');
                const grid = block.querySelector('.pp-pill-grid');
                title.setAttribute('aria-expanded', 'true');
                grid.style.display = 'flex';
                block.scrollIntoView({behavior: 'smooth', block: 'start'});
            });
        });


        // Subject search — filters pills across all level sections
        function runPPSearch() {
            const term = document.getElementById('ppSearchInput').value.trim().toLowerCase();
            let anyVisible = false;
            document.querySelectorAll('.pp-level-block').forEach(block => {
                const title = block.querySelector('.pp-level-title');
                const grid = block.querySelector('.pp-pill-grid');
                let matchCount = 0;
                grid.querySelectorAll('.subject-pill').forEach(pill => {
                    const match = term === '' || pill.textContent.toLowerCase().includes(term);
                    pill.style.display = match ? 'inline-flex' : 'none';
                    if (match) matchCount++;
                });
                if (term === '') {
                    block.style.display = '';
                    anyVisible = true;
                } else {
                    block.style.display = matchCount > 0 ? '' : 'none';
                    if (matchCount > 0) {
                        title.setAttribute('aria-expanded', 'true');
                        grid.style.display = 'flex';
                        anyVisible = true;
                    }
                }
            });
            document.getElementById('ppNoResults').style.display = (term !== '' && !anyVisible) ? 'block' : 'none';
        }

        // document.getElementById('ppSearchBtn').addEventListener('click', runPPSearch);
        // document.getElementById('ppSearchInput').addEventListener('keydown', (e) => { if(e.key === 'Enter'){ e.preventDefault(); runPPSearch(); }});
        // document.getElementById('ppSearchInput').addEventListener('input', runPPSearch);


        document.addEventListener('click', (event) => {
            const header = event.target.closest('.pill-header');

            if (header) {
                const currentPill = header.closest('.subject-pill');

                // Close any other open pills (Optional)
                document.querySelectorAll('.subject-pill.expanded').forEach((pill) => {
                    if (pill !== currentPill) {
                        pill.classList.remove('expanded');

                    }
                });

                // Toggle the clicked pill
                currentPill.classList.toggle('expanded');
            }
        });
    </script>
    <script>
        document.querySelectorAll('.title-scope-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();

                const targetId = button.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);

                console.log(targetId, targetElement)

                if (!targetElement) return;

                // Check whether it is currently hidden
                const isHidden = window.getComputedStyle(targetElement).display === 'none';
                console.log(isHidden);

                // Toggle display: show if hidden, hide if visible
                targetElement.style.display = isHidden ? 'block' : 'none';

                // Toggle active class on the button
                button.classList.toggle('active', isHidden);
            });
        });
    </script>
@endpush
