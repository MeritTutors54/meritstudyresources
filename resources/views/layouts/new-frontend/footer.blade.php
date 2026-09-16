<!-- ============================================================
     8. FOOTER
============================================================ -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 g-lg-5">

            <div class="col-12 col-lg-3">
                <div class="footer-brand">
                    <img src="{{ asset('frontend/new/assets/images/logo.png') }}" alt="" width="58" height="58" class="footer-mark">
                    <span>
            <span class="footer-name">Merit Study<br><span class="footer-name-accent">Resources</span></span>
            <span class="footer-tagline">Learn · Practise · Succeed</span>
          </span>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <h2 class="footer-heading">Quick Links</h2>
                <ul class="footer-list list-unstyled">
                    <li><a href="{{ route('past.papers') }}">Past Papers</a></li>
                    <li><a href="#">Revision Notes</a></li>
                    <li><a href="#">Practice &amp; Tests</a></li>
                    <li><a href="#">Workbooks</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <h2 class="footer-heading">Subjects</h2>
                <ul class="footer-list list-unstyled">
                    <li><a href="#">GCSE / IGCSE</a></li>
                    <li><a href="#">A Level / AS</a></li>
                    <li><a href="#">All Subjects</a></li>
                    <li><a href="#">Exam Boards</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <h2 class="footer-heading">Information</h2>
                <ul class="footer-list list-unstyled">
                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                    <li><a href="{{ route('faq') }}">Help &amp; FAQs</a></li>
                    <li><a href="{{ route('terms-condition') }}">Terms &amp; Privacy</a></li>
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
</footer>
