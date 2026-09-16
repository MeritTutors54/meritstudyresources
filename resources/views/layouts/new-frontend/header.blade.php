<!-- ============================================================
    1. HEADER — utility bar (logo / search / tagline) + main nav
============================================================ -->
<header class="site-header">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center g-3">

                <!-- Brand -->
                <div class="col-lg-4 col-6 order-1">
                    <a class="brand" href="{{ route('home') }}">
                        <img src="{{ asset('frontend/new/assets/images/logo.png')}}" alt="Merit Study Resources logo" width="60" height="60" class="brand-mark">
                        <span class="brand-text">
                            <span class="brand-name">Merit Study<br>
                                <span class="brand-name-accent">Resources</span>
                            </span>
                            <span class="brand-tagline">Learn &nbsp;Practise &nbsp;Succeed</span>
                        </span>
                    </a>
                </div>

                <!-- Site search -->
                <div class="col-lg-5 col-12 order-3 order-lg-2">
                    <form class="site-search" role="search" id="siteSearchForm" novalidate>
                        <label for="siteSearch" class="visually-hidden">Search Merit Study Resources</label>
                        <div class="search-shell">
                            <i class="bi bi-search search-icon" aria-hidden="true"></i>
                            <input type="search" class="form-control search-input" id="siteSearch"
                                   name="q" placeholder="Search for topics, past papers, or resources..."
                                   autocomplete="off">
                            <button class="btn btn-merit search-btn" type="submit">Search</button>
                        </div>
                        <p class="search-feedback" id="searchFeedback" role="status" aria-live="polite"></p>
                    </form>
                </div>

                <!-- Strapline -->
                <div class="col-lg-3 col-6 order-2 order-lg-3 text-end">
                    <p class="strapline">
                        Free Resources
                        <span class="strapline-script">for Brighter Futures</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg main-nav" aria-label="Main navigation">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#primaryNav" aria-controls="primaryNav"
                    aria-expanded="false" aria-label="Toggle navigation menu">
                <i class="bi bi-list" aria-hidden="true"></i>
                <span class="toggler-label">Menu</span>
            </button>

            <div class="collapse navbar-collapse" id="primaryNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}" aria-current="page">
                            <i class="bi bi-house-door-fill" aria-hidden="true"></i> Home
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('past.papers') }}">Past Papers</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Revision Notes</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">GCSE revision notes</a></li>
                            <li><a class="dropdown-item" href="#">IGCSE revision notes</a></li>
                            <li><a class="dropdown-item" href="#">AS &amp; A Level revision notes</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Practice &amp; Tests</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Topic questions</a></li>
                            <li><a class="dropdown-item" href="#">Topic tests</a></li>
                            <li><a class="dropdown-item" href="#">Worked solutions</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Workbooks</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Homework booklets</a></li>
                            <li><a class="dropdown-item" href="#">Revision workbooks</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#subjects" role="button" data-bs-toggle="dropdown" aria-expanded="false">Subjects</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#subjects">Mathematics</a></li>
                            <li><a class="dropdown-item" href="#subjects">Sciences</a></li>
                            <li><a class="dropdown-item" href="#subjects">Humanities</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#subjects">All subjects</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">A Level</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">AQA</a></li>
                            <li><a class="dropdown-item" href="#">Edexcel</a></li>
                            <li><a class="dropdown-item" href="#">OCR</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">GCSE / IGCSE</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">AQA</a></li>
                            <li><a class="dropdown-item" href="#">Edexcel</a></li>
                            <li><a class="dropdown-item" href="#">OCR</a></li>
                            <li><a class="dropdown-item" href="#">Cambridge (CIE)</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Help</a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="#">How to use this site</a></li>
                            <li><a class="dropdown-item" href="#">Choosing an exam board</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact-us') }}">Contact us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
