#!/usr/bin/env python3
"""Builds the static pages that share one header and footer.

Run from anywhere:  python3 tools/build-pages.py

Generates: login, register, blog, blog-post, privacy, terms, refund, cookies,
contact, faq, dashboard. Copy lives in tools/pages_content.py.
The homepage, resource page and subjects page are maintained separately.
"""

import os
import re
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from pages_content import (COMPANY, LEGAL_PAGES, FAQS, POSTS, BLOG_CATEGORIES)  # noqa: E402

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(HERE)


# --------------------------------------------------------------------------
# Shell
# --------------------------------------------------------------------------

def nav_item(label, href, active_key, key, dropdown=None):
    is_active = active_key == key
    cls = "nav-link" + (" active" if is_active else "")
    aria = ' aria-current="page"' if is_active else ""
    if not dropdown:
        return f'          <li class="nav-item"><a class="{cls}" href="{href}"{aria}>{label}</a></li>'
    items = "\n".join(
        '              <li><a class="dropdown-item" href="%s">%s</a></li>' % (h, t)
        if t != "-" else '              <li><hr class="dropdown-divider"></li>'
        for t, h in dropdown
    )
    return f'''          <li class="nav-item dropdown">
            <a class="{cls} dropdown-toggle" href="{href}" role="button" data-bs-toggle="dropdown" aria-expanded="false"{aria}>{label}</a>
            <ul class="dropdown-menu">
{items}
            </ul>
          </li>'''


def header(active_key):
    items = [
        nav_item("Home", "index.html", active_key, "home"),
        nav_item("Past Papers", "resources.html", active_key, "papers"),
        nav_item("Revision Notes", "resources.html#notes", active_key, "notes", [
            ("GCSE revision notes", "resources.html#notes"),
            ("IGCSE revision notes", "resources.html#notes"),
            ("AS &amp; A Level revision notes", "resources.html#notes"),
        ]),
        nav_item("Practice &amp; Tests", "resources.html#questions", active_key, "practice", [
            ("Topic questions", "resources.html#questions"),
            ("Topic tests", "resources.html#tests"),
            ("Worked solutions", "resources.html#solutions"),
        ]),
        nav_item("Subjects", "subjects.html", active_key, "subjects", [
            ("Core", "subjects.html#core"),
            ("Sciences", "subjects.html#sciences"),
            ("Humanities", "subjects.html#humanities"),
            ("-", "-"),
            ("All subjects", "subjects.html"),
        ]),
        nav_item("Blog", "blog.html", active_key, "blog"),
        nav_item("Help", "faq.html", active_key, "help", [
            ("FAQs", "faq.html"),
            ("Contact us", "contact.html"),
            ("-", "-"),
            ("Privacy policy", "privacy.html"),
            ("Terms &amp; conditions", "terms.html"),
        ]),
    ]

    account = '''          <li class="nav-item nav-account-item">
            <a class="nav-link nav-account-link" href="login.html"><i class="bi bi-person" aria-hidden="true"></i> Log in</a>
          </li>
          <li class="nav-item nav-account-item">
            <a class="btn btn-merit btn-sm nav-account-btn" href="register.html">Sign up free</a>
          </li>'''

    return '''<header class="site-header">
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center g-3">

        <div class="col-lg-4 col-6 order-1">
          <a class="brand" href="index.html">
            <img src="assets/images/logo.png" alt="Merit Study Resources logo" width="56" height="56" class="brand-mark">
            <span class="brand-text">
              <span class="brand-name">Merit Study<br><span class="brand-name-accent">Resources</span></span>
              <span class="brand-tagline">Learn &nbsp;Practise &nbsp;Succeed</span>
            </span>
          </a>
        </div>

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
''' + "\n".join(items) + '''
        </ul>
        <ul class="navbar-nav nav-account ms-auto">
''' + account + '''
        </ul>
      </div>
    </div>
  </nav>
</header>'''


FOOTER = '''<footer class="site-footer">
  <div class="container">
    <div class="row g-4 g-lg-5">

      <div class="col-12 col-lg-3">
        <div class="footer-brand">
          <img src="assets/images/logo.png" alt="" width="58" height="58" class="footer-mark">
          <span>
            <span class="footer-name">Merit Study<br><span class="footer-name-accent">Resources</span></span>
            <span class="footer-tagline">Learn · Practise · Succeed</span>
          </span>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <h2 class="footer-heading">Quick Links</h2>
        <ul class="footer-list list-unstyled">
          <li><a href="resources.html">Past Papers</a></li>
          <li><a href="resources.html#notes">Revision Notes</a></li>
          <li><a href="resources.html#questions">Practice &amp; Tests</a></li>
          <li><a href="blog.html">Blog</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <h2 class="footer-heading">Subjects</h2>
        <ul class="footer-list list-unstyled">
          <li><a href="subjects.html?qualification=gcse">GCSE / IGCSE</a></li>
          <li><a href="subjects.html?qualification=alevel">A Level / AS</a></li>
          <li><a href="subjects.html">All Subjects</a></li>
          <li><a href="resources.html">Exam Boards</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <h2 class="footer-heading">Information</h2>
        <ul class="footer-list list-unstyled">
          <li><a href="contact.html">Contact Us</a></li>
          <li><a href="faq.html">Help &amp; FAQs</a></li>
          <li><a href="privacy.html">Privacy Policy</a></li>
          <li><a href="terms.html">Terms &amp; Conditions</a></li>
          <li><a href="refund.html">Refund Policy</a></li>
          <li><a href="cookies.html">Cookie Policy</a></li>
        </ul>
      </div>

      <div class="col-12 col-lg-3">
        <figure class="footer-quote">
          <i class="bi bi-quote quote-mark" aria-hidden="true"></i>
          <blockquote>Education is the most powerful weapon you can use to change the world.</blockquote>
          <figcaption>— Nelson Mandela</figcaption>
        </figure>
      </div>

    </div>
  </div>

  <div class="footer-bar">
    <div class="container">
      <div class="row align-items-center g-3">
        <div class="col-lg-6">
          <p class="footer-copy">© 2026 Merit Study Resources. Free for all students. Learn · Practise · Succeed.</p>
        </div>
        <div class="col-lg-6">
          <div class="footer-bar-end">
            <ul class="social-list list-unstyled">
              <li><a href="#" aria-label="Merit Study Resources on YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a></li>
              <li><a href="#" aria-label="Merit Study Resources on Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a></li>
              <li><a href="#" aria-label="Merit Study Resources on TikTok"><i class="bi bi-tiktok" aria-hidden="true"></i></a></li>
              <li><a href="#" aria-label="Merit Study Resources on Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a></li>
            </ul>
            <p class="footer-motto">Study Today <span aria-hidden="true">|</span> Brighter Tomorrow</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>'''


def shell(filename, title, description, body, active="", body_class="page-resources",
          extra_css=(), extra_js=(), note=""):
    css = "\n".join('<link href="css/%s" rel="stylesheet">' % f
                    for f in ("style.css", "resources.css") + tuple(extra_css))
    js = "\n".join('<script src="js/%s" defer></script>' % f
                   for f in ("main.js",) + tuple(extra_js))
    comment = "\n<!-- %s -->" % note if note else ""

    page = f'''<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title} — Merit Study Resources</title>
<meta name="description" content="{description}">

<link rel="icon" href="assets/images/logo.png" type="image/png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
{css}
{js}
</head>
{comment}
<body class="{body_class}">
<a class="skip-link" href="#main">Skip to main content</a>

{header(active)}

<main id="main">
{body}
</main>

{FOOTER}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
'''
    with open(os.path.join(ROOT, filename), "w") as fh:
        fh.write(page)
    return filename


def crumbs(*trail):
    """trail: (label, href) pairs; the last is the current page."""
    items = []
    for i, (label, href) in enumerate(trail):
        last = i == len(trail) - 1
        if last:
            items.append(f'<li class="breadcrumb-item active" aria-current="page">{label}</li>')
        else:
            items.append(f'<li class="breadcrumb-item"><a href="{href}">{label}</a></li>')
    return ('<nav aria-label="Breadcrumb"><ol class="breadcrumb course-crumbs">'
            + "".join(items) + '</ol></nav>')


EYEBROW = ('<p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources'
           '<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>')


def page_header(title, intro, trail, right="", accent=""):
    head_accent = f' <span class="course-title-board">{accent}</span>' if accent else ""
    return f'''  <section class="course-header" aria-labelledby="pageTitle">
    <div class="container">
      <div class="course-header-top">
        {crumbs(*trail)}
        {right}
      </div>
      {EYEBROW}
      <h1 class="course-title" id="pageTitle">{title}{head_accent}</h1>
      <p class="course-intro">{intro}</p>
    </div>
  </section>'''


# --------------------------------------------------------------------------
# 1 & 2. Auth pages
# --------------------------------------------------------------------------

AUTH_ASIDE = '''        <div class="col-lg-5 col-xl-4">
          <aside class="auth-aside">
            <h2 class="auth-aside-title">An account is optional — here is what it adds</h2>
            <ul class="auth-benefits list-unstyled">
              <li><span class="auth-benefit-icon"><i class="bi bi-bookmark-heart" aria-hidden="true"></i></span>
                <span><strong>Save resources</strong> and pick them up on any device.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-compass" aria-hidden="true"></i></span>
                <span><strong>Keep your course</strong> so the site opens on your subjects and exam board.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
                <span><strong>See what you have opened</strong> and carry on where you stopped.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-envelope-open" aria-hidden="true"></i></span>
                <span><strong>Hear when papers land</strong> for your subjects — only if you ask us to.</span></li>
            </ul>
            <p class="auth-aside-note">
              Everything on the site stays free and open without an account.
              <a href="privacy.html">How we handle your data</a>.
            </p>
          </aside>
        </div>'''


def auth_page(kind):
    login = kind == "login"
    title = "Welcome back" if login else "Create your free account"
    intro = ("Sign in to reach your saved resources and your course."
             if login else
             "It takes a minute, and everything on the site stays free either way.")

    if login:
        fields = '''              <div class="form-field">
                <label class="form-label" for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                       autocomplete="email" required placeholder="you@example.com">
                <p class="field-error" data-error-for="email">Enter the email address you signed up with.</p>
              </div>

              <div class="form-field">
                <div class="label-row">
                  <label class="form-label" for="password">Password</label>
                  <a class="label-link" href="#" data-demo="Password reset is not wired up in this preview.">Forgot password?</a>
                </div>
                <div class="password-field">
                  <input type="password" class="form-control" id="password" name="password"
                         autocomplete="current-password" required minlength="8" placeholder="••••••••">
                  <button type="button" class="password-toggle" data-password-toggle="password"
                          aria-label="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                <p class="field-error" data-error-for="password">Your password is at least 8 characters.</p>
              </div>

              <div class="form-check form-check-inline-row">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" checked>
                <label class="form-check-label" for="remember">Keep me signed in on this device</label>
              </div>

              <button type="submit" class="btn btn-merit btn-lg w-100">Sign in</button>

              <p class="auth-switch">New here? <a href="register.html">Create a free account</a></p>'''
    else:
        fields = '''              <div class="form-field">
                <label class="form-label" for="name">Your name</label>
                <input type="text" class="form-control" id="name" name="name"
                       autocomplete="name" required placeholder="First and last name">
                <p class="field-error" data-error-for="name">Tell us what to call you.</p>
              </div>

              <div class="form-field">
                <label class="form-label" for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                       autocomplete="email" required placeholder="you@example.com">
                <p class="field-hint">We use this to sign you in and reset your password. Nothing else.</p>
                <p class="field-error" data-error-for="email">That does not look like an email address.</p>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="role">I am a</label>
                    <select class="form-select" id="role" name="role" required>
                      <option value="" selected>Select one</option>
                      <option>Student</option>
                      <option>Parent or guardian</option>
                      <option>Teacher or tutor</option>
                    </select>
                    <p class="field-error" data-error-for="role">Pick one so we can set the site up for you.</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="qualification">Studying for</label>
                    <select class="form-select" id="qualification" name="qualification">
                      <option value="" selected>Select (optional)</option>
                      <option>GCSE</option>
                      <option>IGCSE</option>
                      <option>AS Level</option>
                      <option>A Level</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-field">
                <label class="form-label" for="password">Password</label>
                <div class="password-field">
                  <input type="password" class="form-control" id="password" name="password"
                         autocomplete="new-password" required minlength="8" placeholder="At least 8 characters">
                  <button type="button" class="password-toggle" data-password-toggle="password"
                          aria-label="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                <div class="strength" aria-hidden="true"><span class="strength-bar" data-strength-bar></span></div>
                <p class="field-hint" data-strength-label>Use 8 characters or more. A short phrase works well.</p>
                <p class="field-error" data-error-for="password">Passwords need at least 8 characters.</p>
              </div>

              <div class="form-check form-check-inline-row">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                  I agree to the <a href="terms.html">terms</a> and the <a href="privacy.html">privacy policy</a>.
                </label>
                <p class="field-error" data-error-for="terms">Please accept the terms to continue.</p>
              </div>

              <button type="submit" class="btn btn-merit btn-lg w-100">Create account</button>

              <p class="auth-switch">Already have an account? <a href="login.html">Sign in</a></p>'''

    body = f'''  <section class="auth-section">
    <div class="container">
      <div class="row g-4 justify-content-center align-items-start">

        <div class="col-lg-6 col-xl-5">
          <div class="auth-card">
            {EYEBROW}
            <h1 class="auth-title">{title}</h1>
            <p class="auth-intro">{intro}</p>

            <form class="auth-form" data-demo-form novalidate>
{fields}
              <p class="form-status" role="status" aria-live="polite" data-form-status></p>
            </form>
          </div>
        </div>

{AUTH_ASIDE}

      </div>
    </div>
  </section>'''

    return shell(f"{kind}.html",
                 "Sign in" if login else "Create an account",
                 "Sign in to Merit Study Resources." if login
                 else "Create a free Merit Study Resources account to save resources and keep your course.",
                 body, active="", body_class="page-resources page-auth",
                 extra_css=("pages.css",), extra_js=("pages.js",))


# --------------------------------------------------------------------------
# 3. Blog index
# --------------------------------------------------------------------------

def post_card(post, featured=False):
    cls = "post-card post-card-featured" if featured else "post-card"
    read_more = "Read the full post" if featured else "Read post"
    return f'''          <article class="{cls}" data-category="{post['category']}"
                   data-keywords="{post['title'].lower()} {post['category'].lower()}">
            <a class="post-thumb {post['tint']}" href="blog-post.html" aria-hidden="true" tabindex="-1">
              <i class="bi bi-{post['icon']}"></i>
            </a>
            <div class="post-body">
              <p class="post-meta"><span class="post-cat">{post['category']}</span> · {post['date']} · {post['read']}</p>
              <h3 class="post-title"><a href="blog-post.html">{post['title']}</a></h3>
              <p class="post-excerpt">{post['excerpt']}</p>
              <span class="post-more">{read_more} <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
            </div>
          </article>'''


def blog_page():
    featured = POSTS[0]
    rest = POSTS[1:]

    pills = "\n".join(
        '          <button type="button" class="filter-pill%s" data-category="%s" aria-pressed="%s">%s</button>'
        % (" is-active" if i == 0 else "", "" if i == 0 else c, "true" if i == 0 else "false", c)
        for i, c in enumerate(BLOG_CATEGORIES)
    )

    cards = "\n".join('        <div class="col">%s</div>' % post_card(p) for p in rest)

    body = page_header(
        "Study advice from the", 
        "Short, practical posts on revising, using past papers and making sense of exams — "
        "written by the tutors who put this library together.",
        [("Home", "index.html"), ("Blog", "blog.html")],
        right='<p class="spec-code"><span>%d</span> posts</p>' % len(POSTS),
        accent="Merit blog",
    ) + f'''

  <div class="blog-body">
    <div class="container">

      <div class="blog-controls">
        <div class="filter-pills blog-filter" role="group" aria-label="Filter posts by category">
{pills}
        </div>
        <form class="blog-search" role="search" onsubmit="return false">
          <label class="visually-hidden" for="postSearch">Search posts</label>
          <div class="search-shell search-shell-sm">
            <i class="bi bi-search search-icon" aria-hidden="true"></i>
            <input type="search" class="form-control search-input" id="postSearch" placeholder="Search posts...">
          </div>
        </form>
      </div>

      <div class="featured-wrap" data-post-wrap>
{post_card(featured, featured=True)}
      </div>

      <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-xl-3 post-grid" data-post-wrap>
{cards}
      </div>

      <p class="empty-state" id="postEmpty" role="status" aria-live="polite" hidden>
        <i class="bi bi-search" aria-hidden="true"></i>
        No posts match that. Try another word or choose "All posts".
      </p>

      <nav class="blog-pagination" aria-label="Blog pages">
        <span class="page-btn is-disabled" aria-disabled="true"><i class="bi bi-arrow-left" aria-hidden="true"></i> Newer</span>
        <span class="page-status">Page 1 of 1</span>
        <span class="page-btn is-disabled" aria-disabled="true">Older <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
      </nav>

    </div>
  </div>'''

    return shell("blog.html", "Blog",
                 "Revision advice, exam explainers and subject guides from Merit Study Resources.",
                 body, active="blog", extra_css=("pages.css",), extra_js=("pages.js",))


# --------------------------------------------------------------------------
# 4. Blog post
# --------------------------------------------------------------------------

def blog_post_page():
    post = POSTS[0]
    related = "\n".join('        <div class="col">%s</div>' % post_card(p) for p in POSTS[1:4])

    body = f'''  <article class="post-page">

    <header class="course-header post-header">
      <div class="container">
        <div class="course-header-top">
          {crumbs(("Home", "index.html"), ("Blog", "blog.html"), (post['category'], "blog.html"))}
          <p class="spec-code">{post['read']}</p>
        </div>
        <p class="post-cat post-cat-lead">{post['category']}</p>
        <h1 class="course-title post-page-title">{post['title']}</h1>
        <p class="course-intro">{post['excerpt']}</p>
        <div class="post-byline">
          <span class="byline-avatar" aria-hidden="true">MS</span>
          <span>
            <span class="byline-name">Merit Study Resources team</span>
            <span class="byline-date">Published {post['date']}</span>
          </span>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row g-4 g-xl-5 post-layout">

        <div class="col-lg-8">
          <div class="prose">
            <p class="prose-lead">
              Most students do past papers the same way: sit one, mark it, note the score, move on to the next.
              It feels productive. It is mostly wasted effort, because the score tells you where you are, not
              what to change.
            </p>

            <h2 id="why-scores-mislead">Why the score misleads you</h2>
            <p>
              A mark out of 80 is one number covering thirty separate skills. Two students can both get 48 and
              need completely different weeks of work — one dropped everything on algebra, the other lost marks
              in ones and twos across the paper for missing working. The number hides the difference.
            </p>
            <p>
              What you actually need from a past paper is a list: the specific things you could not do. That
              list is worth more than the grade, and you only get it if you mark honestly and write it down.
            </p>

            <h2 id="the-loop">The four-step loop</h2>
            <p>Use each paper four times, not once.</p>
            <ol>
              <li><strong>Attempt it properly.</strong> Timed, no notes, no phone. If you stop at every hard
                question to look something up, you are revising, not practising — and you will not find out
                what happens under pressure.</li>
              <li><strong>Mark it against the scheme, strictly.</strong> Half-right is wrong. Mark like the
                examiner who has never met you and cannot guess what you meant.</li>
              <li><strong>Redo every lost mark the same day.</strong> Not read the solution — redo the question
                on blank paper until you can produce the answer yourself.</li>
              <li><strong>Re-attempt the paper cold a week later.</strong> This is the step nearly everyone
                skips, and it is the one that proves the fix held.</li>
            </ol>

            <div class="callout">
              <p class="callout-title"><i class="bi bi-lightbulb" aria-hidden="true"></i> One rule worth keeping</p>
              <p>If you cannot redo a question from a blank page a week later, you have not learnt it — you have
                recognised it. Recognition disappears in an exam hall.</p>
            </div>

            <h2 id="honest-marking">Marking honestly is the hard part</h2>
            <p>
              Self-marking fails because you know what you meant. The mark scheme does not care. When it awards
              M1 for a method and A1 for the answer, it is telling you the method earns marks on its own — which
              is why writing nothing down on a question you half-know costs you marks you had.
            </p>
            <p>
              If you find yourself arguing with a mark scheme, that argument is the most useful thing on the
              page. Write the disagreement down and take it to your teacher. Either you have found a genuine
              ambiguity, or you have found a gap in how you are reading questions.
            </p>

            <h3>A quick test</h3>
            <p>
              Cover your working and read only the question and your final answer. Would a stranger know how you
              got there? If not, you would lose method marks even where the answer is right.
            </p>

            <h2 id="which-papers">Which papers to use, in what order</h2>
            <p>
              Start with the most recent series and work backwards, but check the specification date. Papers
              from before a specification change can still be useful for topics that did not change, and useless
              for topics that did — which is why every paper in our library is labelled with its series.
            </p>
            <ul>
              <li><strong>Eight weeks out</strong> — topic questions, not whole papers. Fix the content first.</li>
              <li><strong>Four weeks out</strong> — one full paper a week, timed, marked properly.</li>
              <li><strong>Final fortnight</strong> — re-attempt papers you already did badly on, not new ones.</li>
            </ul>

            <h2 id="start">Where to start today</h2>
            <p>
              Pick one paper from last summer for your subject and board, set a timer, and do it without notes.
              Then mark it and write your list. That list is your revision plan for the week — everything else
              is decoration.
            </p>

            <div class="prose-cta">
              <p><strong>Ready to try it?</strong> Every paper in the library comes with its mark scheme and a
                worked solution, so you can run all four steps without hunting for files.</p>
              <a class="btn btn-merit" href="resources.html">Find past papers <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
          </div>

          <div class="post-foot">
            <ul class="post-tags list-unstyled">
              <li>Past papers</li><li>Revision technique</li><li>Exam skills</li>
            </ul>
            <div class="post-share">
              <span class="share-label">Share</span>
              <a href="#" aria-label="Share on Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
              <a href="#" aria-label="Share on X"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
              <a href="#" aria-label="Share on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
              <button type="button" class="share-copy" data-copy-link>
                <i class="bi bi-link-45deg" aria-hidden="true"></i> Copy link
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <aside class="post-aside">
            <nav class="toc" aria-label="On this page">
              <h2 class="toc-heading">On this page</h2>
              <ul class="toc-list list-unstyled">
                <li><a href="#why-scores-mislead">Why the score misleads you</a></li>
                <li><a href="#the-loop">The four-step loop</a></li>
                <li><a href="#honest-marking">Marking honestly is the hard part</a></li>
                <li><a href="#which-papers">Which papers, in what order</a></li>
                <li><a href="#start">Where to start today</a></li>
              </ul>
            </nav>

            <div class="aside-card">
              <h2 class="aside-title">Get the papers</h2>
              <p class="aside-text">Question paper, mark scheme and worked solution together, free, by board.</p>
              <a class="btn btn-soft" href="resources.html">Browse past papers <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
          </aside>
        </div>

      </div>

      <section class="related" aria-labelledby="relatedHeading">
        <div class="group-head">
          <h2 class="group-heading" id="relatedHeading">Keep reading</h2>
          <a class="section-link" href="blog.html">All posts <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="row g-4 row-cols-1 row-cols-md-3 post-grid">
{related}
        </div>
      </section>
    </div>
  </article>'''

    return shell("blog-post.html", post["title"],
                 post["excerpt"], body, active="blog",
                 extra_css=("pages.css",), extra_js=("pages.js",))


# --------------------------------------------------------------------------
# 5–8. Legal pages
# --------------------------------------------------------------------------

def anchor(text):
    return re.sub(r"[^a-z0-9]+", "-", text.lower()).strip("-")


def render_blocks(blocks):
    out = []
    for block in blocks:
        if isinstance(block, str):
            out.append(f"            <p>{block}</p>")
        elif block[0] == "list":
            items = "\n".join(f"              <li>{i}</li>" for i in block[1])
            out.append(f"            <ul>\n{items}\n            </ul>")
        elif block[0] == "table":
            head = "".join(f"<th scope=\"col\">{h}</th>" for h in block[1])
            rows = "\n".join(
                "                <tr>" + "".join(f"<td>{c}</td>" for c in row) + "</tr>"
                for row in block[2]
            )
            out.append(f'''            <div class="table-wrap">
              <table class="policy-table">
                <thead><tr>{head}</tr></thead>
                <tbody>
{rows}
                </tbody>
              </table>
            </div>''')
    return "\n".join(out)


def legal_page(page):
    toc = "\n".join(
        f'                <li><a href="#{anchor(h)}">{h}</a></li>' for h, _ in page["sections"]
    )
    sections = "\n".join(
        f'''          <section class="policy-section" id="{anchor(h)}" aria-labelledby="{anchor(h)}-h">
            <h2 id="{anchor(h)}-h">{h}</h2>
{render_blocks(blocks)}
          </section>'''
        for h, blocks in page["sections"]
    )

    others = [(p["title"], p["slug"] + ".html") for p in LEGAL_PAGES if p["slug"] != page["slug"]]
    other_links = "".join(f'<li><a href="{href}">{title}</a></li>' for title, href in others)

    body = page_header(
        page["title"], page["intro"],
        [("Home", "index.html"), (page["title"], page["slug"] + ".html")],
        right=f'<p class="spec-code">Last updated <span>{COMPANY["updated"]}</span></p>',
    ) + f'''

  <div class="policy-body">
    <div class="container">
      <div class="row g-4 g-xl-5">

        <div class="col-lg-4 order-lg-2">
          <aside class="post-aside">
            <nav class="toc" aria-label="On this page">
              <h2 class="toc-heading">On this page</h2>
              <ul class="toc-list list-unstyled">
{toc}
              </ul>
            </nav>
            <div class="aside-card">
              <h2 class="aside-title">Other policies</h2>
              <ul class="aside-links list-unstyled">{other_links}</ul>
            </div>
          </aside>
        </div>

        <div class="col-lg-8 order-lg-1">
          <div class="prose policy-prose">
{sections}
          </div>

          <div class="policy-contact">
            <p><strong>Questions about this page?</strong> Email
              <a href="mailto:{COMPANY['email']}">{COMPANY['email']}</a> or use the
              <a href="contact.html">contact form</a>.</p>
          </div>
        </div>

      </div>
    </div>
  </div>'''

    return shell(page["slug"] + ".html", page["title"],
                 page["intro"][:150], body, active="",
                 extra_css=("pages.css",), extra_js=("pages.js",),
                 note="TEMPLATE COPY — have this reviewed by a solicitor and replace every "
                      "[bracketed] placeholder before publishing.")


# --------------------------------------------------------------------------
# 9. Contact
# --------------------------------------------------------------------------

def contact_page():
    body = page_header(
        "Contact", 
        "Corrections, requests for a subject, or a question about a resource — this is the fastest "
        "way to reach us. We reply within two working days.",
        [("Home", "index.html"), ("Contact", "contact.html")],
        right='<p class="spec-code">Replies within <span>2 working days</span></p>',
        accent="us",
    ) + f'''

  <div class="contact-body">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-7">
          <div class="auth-card contact-card">
            <h2 class="pane-title">Send us a message</h2>
            <p class="pane-sub">Fields marked with * are required.</p>

            <form class="auth-form" data-demo-form novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="name">Your name *</label>
                    <input type="text" class="form-control" id="name" name="name" autocomplete="name" required>
                    <p class="field-error" data-error-for="name">Please tell us your name.</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="email">Email address *</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="email" required>
                    <p class="field-error" data-error-for="email">We need a valid address to reply to.</p>
                  </div>
                </div>
              </div>

              <div class="form-field">
                <label class="form-label" for="topic">What is it about? *</label>
                <select class="form-select" id="topic" name="topic" required>
                  <option value="" selected>Choose a topic</option>
                  <option>A mistake in a resource</option>
                  <option>Request a subject or paper</option>
                  <option>A file will not open</option>
                  <option>Copyright or takedown</option>
                  <option>Working with us</option>
                  <option>Something else</option>
                </select>
                <p class="field-error" data-error-for="topic">Pick the closest option.</p>
              </div>

              <div class="form-field">
                <label class="form-label" for="message">Message *</label>
                <textarea class="form-control" id="message" name="message" rows="6" required
                          placeholder="If it is about a specific resource, include the subject, board and paper."></textarea>
                <p class="field-hint">The more specific you are, the faster we can fix it.</p>
                <p class="field-error" data-error-for="message">Add a few details so we can help.</p>
              </div>

              <div class="form-check form-check-inline-row">
                <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                <label class="form-check-label" for="consent">
                  I am happy for you to use my details to reply. See the <a href="privacy.html">privacy policy</a>. *
                </label>
                <p class="field-error" data-error-for="consent">We need this to write back to you.</p>
              </div>

              <button type="submit" class="btn btn-merit btn-lg">Send message <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
              <p class="form-status" role="status" aria-live="polite" data-form-status></p>
            </form>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="contact-side">

            <div class="contact-tile">
              <span class="resource-icon res-green-chip"><i class="bi bi-envelope" aria-hidden="true"></i></span>
              <div>
                <h2 class="contact-tile-title">Email us</h2>
                <p class="contact-tile-text"><a href="mailto:{COMPANY['email']}">{COMPANY['email']}</a></p>
              </div>
            </div>

            <div class="contact-tile">
              <span class="resource-icon res-blue-chip"><i class="bi bi-clock" aria-hidden="true"></i></span>
              <div>
                <h2 class="contact-tile-title">When we reply</h2>
                <p class="contact-tile-text">Monday to Friday, within two working days. Corrections to resources are usually same-day.</p>
              </div>
            </div>

            <div class="contact-tile">
              <span class="resource-icon res-amber-chip"><i class="bi bi-shield-check" aria-hidden="true"></i></span>
              <div>
                <h2 class="contact-tile-title">Copyright and takedowns</h2>
                <p class="contact-tile-text">Rights holders: email us with the resource and we will act promptly. See the <a href="terms.html">terms</a>.</p>
              </div>
            </div>

            <div class="contact-tile">
              <span class="resource-icon res-purple-chip"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
              <div>
                <h2 class="contact-tile-title">Postal address</h2>
                <p class="contact-tile-text">{COMPANY['legal']}<br>{COMPANY['address']}</p>
              </div>
            </div>

            <div class="request-panel contact-faq">
              <div>
                <h2 class="request-heading">Try the FAQs first</h2>
                <p class="request-text">Most questions — file formats, exam boards, accounts — are answered there.</p>
              </div>
              <a class="btn btn-soft" href="faq.html">Read the FAQs <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>'''

    return shell("contact.html", "Contact",
                 "Contact Merit Study Resources — corrections, requests and questions.",
                 body, active="help", extra_css=("pages.css",), extra_js=("pages.js",))


# --------------------------------------------------------------------------
# 10. FAQ
# --------------------------------------------------------------------------

def faq_page():
    blocks = []
    jump = []
    n = 0
    for gi, (category, items) in enumerate(FAQS):
        gid = anchor(category)
        jump.append(f'<li><a class="jump-chip" href="#{gid}">{category} '
                    f'<span class="jump-count">{len(items)}</span></a></li>')
        entries = []
        for qi, (question, answer) in enumerate(items):
            n += 1
            entries.append(f'''            <div class="accordion-item faq-item" data-keywords="{question.lower()}">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-{n}" aria-expanded="false" aria-controls="faq-{n}">
                  {question}
                </button>
              </h3>
              <div id="faq-{n}" class="accordion-collapse collapse">
                <div class="accordion-body"><p>{answer}</p></div>
              </div>
            </div>''')
        blocks.append(f'''      <section class="subject-group faq-group" id="{gid}" aria-labelledby="{gid}-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="{gid}-h">{category}</h2>
          <span class="group-count">{len(items)} questions</span>
        </div>
        <div class="accordion topic-accordion">
{chr(10).join(entries)}
        </div>
      </section>''')

    body = page_header(
        "Frequently asked", 
        "How the site works, what we cover, and what to do when something is not right. "
        "If your question is not here, just ask us.",
        [("Home", "index.html"), ("Help", "faq.html"), ("FAQs", "faq.html")],
        right=f'<p class="spec-code"><span>{n}</span> questions</p>',
        accent="questions",
    ) + f'''

  <div class="faq-search-bar">
    <div class="container">
      <form class="faq-search" role="search" onsubmit="return false">
        <label class="visually-hidden" for="faqSearch">Search the FAQs</label>
        <div class="search-shell">
          <i class="bi bi-search search-icon" aria-hidden="true"></i>
          <input type="search" class="form-control search-input" id="faqSearch"
                 placeholder="Search questions — try &quot;print&quot; or &quot;exam board&quot;">
        </div>
      </form>
      <nav aria-label="Jump to a question category">
        <ul class="jump-list list-unstyled">{"".join(jump)}</ul>
      </nav>
    </div>
  </div>

  <div class="subject-body">
    <div class="container">

{chr(10).join(blocks)}

      <p class="empty-state" id="faqEmpty" role="status" aria-live="polite" hidden>
        <i class="bi bi-search" aria-hidden="true"></i>
        Nothing matches that. Try a shorter word, or <a href="contact.html">ask us directly</a>.
      </p>

      <section class="request-panel" aria-labelledby="stillHeading">
        <div>
          <h2 class="request-heading" id="stillHeading">Still stuck?</h2>
          <p class="request-text">Send us the details and we will get back to you within two working days.</p>
        </div>
        <a class="btn btn-merit" href="contact.html">Contact us <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
      </section>

    </div>
  </div>'''

    return shell("faq.html", "FAQs",
                 "Answers to common questions about Merit Study Resources.",
                 body, active="help", body_class="page-resources page-subjects",
                 extra_css=("subjects.css", "pages.css"), extra_js=("pages.js",))


# --------------------------------------------------------------------------
# 11. Dashboard
# --------------------------------------------------------------------------

def dashboard_page():
    side_links = [
        ("Overview", "speedometer2", True),
        ("Saved resources", "bookmark", False),
        ("Recently opened", "clock-history", False),
        ("My course", "mortarboard", False),
        ("Downloads", "download", False),
        ("Account settings", "gear", False),
    ]
    side = "\n".join(
        '              <li><a class="dash-nav-link%s" href="#%s"%s><i class="bi bi-%s" aria-hidden="true"></i> %s</a></li>'
        % (" is-active" if active else "", anchor(label), ' aria-current="page"' if active else "", icon, label)
        for label, icon, active in side_links
    )

    stats = [
        ("Saved resources", "12", "bookmark-fill", "res-blue"),
        ("Papers opened", "28", "file-earmark-text-fill", "res-rose"),
        ("Tests completed", "5", "stopwatch-fill", "res-purple"),
        ("Topics covered", "19", "check2-circle", "res-green"),
    ]
    stat_cards = "\n".join(f'''          <div class="col">
            <div class="stat-card {cls}">
              <span class="resource-icon"><i class="bi bi-{icon}" aria-hidden="true"></i></span>
              <span class="stat-value">{value}</span>
              <span class="stat-label">{label}</span>
            </div>
          </div>''' for label, value, icon, cls in stats)

    continue_rows = [
        ("Algebra · Quadratics", "Revision notes · 4 of 6 pages read", "65", "journal-text", "row-icon-note"),
        ("June 2024 · Paper 1", "Past paper · started 2 days ago", "30", "file-earmark-text", ""),
        ("Number · End of unit test", "Topic test · not started", "0", "stopwatch", "row-icon-purple"),
    ]
    continues = "\n".join(f'''            <li class="resource-row">
              <span class="row-icon {cls}"><i class="bi bi-{icon}" aria-hidden="true"></i></span>
              <div class="row-body">
                <h3 class="row-title">{title}</h3>
                <p class="row-meta">{meta}</p>
                <div class="progress-track" role="img" aria-label="{pct}% complete">
                  <span class="progress-fill" style="width: {pct}%"></span>
                </div>
              </div>
              <div class="row-actions">
                <a class="btn btn-merit btn-sm" href="resources.html">{'Continue' if pct != '0' else 'Start'}</a>
              </div>
            </li>''' for title, meta, pct, icon, cls in continue_rows)

    saved_rows = [
        ("GCSE Maths · June 2023 Paper 2", "Edexcel · Higher · Past paper", "file-earmark-text", ""),
        ("Circle theorems", "Edexcel · Higher · Revision notes", "journal-text", "row-icon-note"),
        ("Trigonometry topic questions", "Edexcel · Higher · 15 questions", "check2-square", "row-icon-green"),
        ("Algebra workbook", "Edexcel · Higher · 24 pages", "book-half", "row-icon-teal"),
    ]
    saved = "\n".join(f'''            <li class="resource-row">
              <span class="row-icon {cls}"><i class="bi bi-{icon}" aria-hidden="true"></i></span>
              <div class="row-body">
                <h3 class="row-title">{title}</h3>
                <p class="row-meta">{meta}</p>
              </div>
              <div class="row-actions">
                <a class="btn btn-merit btn-sm" href="resources.html">Open</a>
                <button type="button" class="btn btn-soft" data-demo="Removing a saved item needs the backend.">Remove</button>
              </div>
            </li>''' for title, meta, icon, cls in saved_rows)

    body = f'''  <!-- Dashboard content below is SAMPLE DATA for the design preview. -->
  <section class="course-header dash-header">
    <div class="container">
      <div class="course-header-top">
        {crumbs(("Home", "index.html"), ("Dashboard", "dashboard.html"))}
        <p class="spec-code">Signed in as <span>amina@example.com</span></p>
      </div>
      <div class="course-header-main">
        <div>
          <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Your study space</p>
          <h1 class="course-title">Welcome back, <span class="course-title-board">Amina</span></h1>
          <p class="course-intro">Pick up where you left off, or jump straight to your course.</p>
          <ul class="course-chips list-unstyled">
            <li class="course-chip">GCSE</li>
            <li class="course-chip">Mathematics</li>
            <li class="course-chip">Edexcel</li>
            <li class="course-chip course-chip-tier">Higher Tier</li>
          </ul>
        </div>
        <div class="course-actions">
          <a class="btn btn-outline-merit" href="index.html#finderHeading"><i class="bi bi-pencil" aria-hidden="true"></i> Change course</a>
          <a class="btn btn-soft" href="login.html">Sign out</a>
        </div>
      </div>
    </div>
  </section>

  <div class="dash-body">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-3">
          <aside class="dash-nav" aria-label="Dashboard sections">
            <ul class="list-unstyled">
{side}
            </ul>
            <div class="dash-nav-foot">
              <p class="filter-note">Sample dashboard. Figures and rows are placeholders for the design.</p>
            </div>
          </aside>
        </div>

        <div class="col-lg-9">

          <section id="overview" aria-labelledby="overviewHeading">
            <div class="pane-head">
              <h2 class="pane-title" id="overviewHeading">Overview</h2>
              <p class="pane-sub">Your activity this term.</p>
            </div>
            <div class="row g-3 row-cols-2 row-cols-lg-4">
{stat_cards}
            </div>
          </section>

          <section id="recently-opened" class="dash-section" aria-labelledby="continueHeading">
            <div class="section-head">
              <h2 class="pane-title" id="continueHeading">Continue where you left off</h2>
              <a class="section-link" href="resources.html">All resources <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
            <ul class="resource-list list-unstyled">
{continues}
            </ul>
          </section>

          <section id="saved-resources" class="dash-section" aria-labelledby="savedHeading">
            <div class="section-head">
              <h2 class="pane-title" id="savedHeading">Saved resources</h2>
              <a class="section-link" href="resources.html">Find more <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
            <ul class="resource-list list-unstyled">
{saved}
            </ul>
          </section>

          <section id="my-course" class="dash-section" aria-labelledby="courseHeading">
            <div class="pane-head">
              <h2 class="pane-title" id="courseHeading">My course</h2>
              <p class="pane-sub">What the site opens on by default.</p>
            </div>
            <div class="row g-3 row-cols-1 row-cols-md-3">
              <div class="col"><div class="dash-fact"><span class="dash-fact-label">Qualification</span><span class="dash-fact-value">GCSE</span></div></div>
              <div class="col"><div class="dash-fact"><span class="dash-fact-label">Subject</span><span class="dash-fact-value">Mathematics</span></div></div>
              <div class="col"><div class="dash-fact"><span class="dash-fact-label">Exam board</span><span class="dash-fact-value">Edexcel · Higher</span></div></div>
            </div>
          </section>

          <section id="account-settings" class="dash-section" aria-labelledby="settingsHeading">
            <div class="pane-head">
              <h2 class="pane-title" id="settingsHeading">Account settings</h2>
              <p class="pane-sub">Nothing here is wired to a backend in this preview.</p>
            </div>

            <form class="auth-form dash-settings" data-demo-form novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="dash-name">Name</label>
                    <input type="text" class="form-control" id="dash-name" value="Amina Rahman" required>
                    <p class="field-error" data-error-for="dash-name">Names cannot be blank.</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="dash-email">Email address</label>
                    <input type="email" class="form-control" id="dash-email" value="amina@example.com" required>
                    <p class="field-error" data-error-for="dash-email">Enter a valid address.</p>
                  </div>
                </div>
              </div>

              <div class="form-check form-check-inline-row">
                <input class="form-check-input" type="checkbox" id="notify" checked>
                <label class="form-check-label" for="notify">Email me when new papers are added for my subjects</label>
              </div>

              <div class="dash-settings-actions">
                <button type="submit" class="btn btn-merit">Save changes</button>
                <button type="button" class="btn btn-soft" data-demo="Account deletion needs the backend. See the privacy policy for what we hold.">Delete account</button>
              </div>
              <p class="form-status" role="status" aria-live="polite" data-form-status></p>
            </form>
          </section>

        </div>
      </div>
    </div>
  </div>'''

    return shell("dashboard.html", "Your dashboard",
                 "Your saved resources, recent activity and course settings.",
                 body, active="", extra_css=("pages.css",), extra_js=("pages.js",))


# --------------------------------------------------------------------------

def main():
    built = [
        auth_page("login"),
        auth_page("register"),
        blog_page(),
        blog_post_page(),
        contact_page(),
        faq_page(),
        dashboard_page(),
    ]
    built += [legal_page(p) for p in LEGAL_PAGES]
    print("built %d pages:" % len(built))
    for name in sorted(built):
        print("  " + name)


if __name__ == "__main__":
    main()
