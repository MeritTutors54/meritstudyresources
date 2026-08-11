    <!-- ============================= FOOTER ============================= -->
    <footer class="footer-msr pt-5">
        <div class="container">
            <div class="row gy-4 pb-4">
                <div class="col-lg-4">
                    {{-- <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="brand-mark" style="background:var(--green);">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M4 5.5C4 4.67 4.67 4 5.5 4H12V20H5.5C4.67 20 4 19.33 4 18.5V5.5Z" stroke="#fff"
                                    stroke-width="1.6" stroke-linejoin="round" />
                                <path d="M20 5.5C20 4.67 19.33 4 18.5 4H12V20H18.5C19.33 20 20 19.33 20 18.5V5.5Z"
                                    stroke="#0F2D1B" stroke-width="1.6" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="brand-wordmark text-white">MERIT STUDY<br><span
                                style="color:var(--green);">RESOURCES</span></span>
                    </div> --}}

                    <a class="navbar-brand d-flex align-items-center gap-2 mb-3" href="{{ route('home') }}">
                        <span class="brand-mark">
                            <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo-light.png') }}"
                                alt="logo">
                        </span>
                        <span class="brand-wordmark text-white">MERIT STUDY<br><span
                                style="color:var(--green);">RESOURCES</span></span>
                    </a>



                    <p style="max-width:300px;">Explore a vast collection of past papers, worksheets and revision
                        resources to excel in your exams.</p>
                    <p class="mb-0"><a href="mailto:info@meritstudyresource.co.uk">info@meritstudyresource.co.uk</a>
                    </p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Company</h6>
                    <ul>
                        <li><a href="{{ route('about-us') }}">About Us</a></li>
                        <li><a href="{{ route('past.papers') }}">Past Papers</a></li>
                        <li><a href="{{ route('blogs') }}">Blogs</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h6>Support</h6>
                    <ul>
                        <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                        <li><a href="{{ route('faq') }}">FAQs</a></li>
                        <li><a href="{{ route('terms-condition') }}">Terms of Condition</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('refund.policy') }}">Refund Policy</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h6>Connect</h6>

                    <div class="d-flex gap-2">

                        @if (!empty($socials))
                            @foreach ($socials as $link)
                                @if ($link->type === \App\Enums\Social::Facebook->name)
                                    <a target="_blank" href="{{ $link->url }}" class="social-ico">
                                        <svg viewBox="0 0 24 24" fill="#fff">
                                            <path
                                                d="M13.5 9H15V6.5h-1.5C12 6.5 11 7.6 11 9.5V11H9.5v2.3H11V18h2.3v-4.7h1.7l.3-2.3h-2V9.6c0-.4.2-.6.6-.6z" />
                                        </svg>
                                    </a>
                                @elseif ($link->type === \App\Enums\Social::Twitter->name)
                                    <a target="_blank" href="{{ $link->url }}" class="social-ico">
                                        <svg viewBox="0 0 24 24" fill="#fff">
                                            <path
                                                d="M21 5.9c-.7.3-1.5.5-2.3.6.8-.5 1.4-1.3 1.7-2.3-.8.5-1.7.8-2.6 1A3.7 3.7 0 0012 7.6c0 .3 0 .6.1.9C8.9 8.4 6 6.8 4 4.4c-.4.6-.6 1.3-.6 2.1 0 1.4.7 2.6 1.8 3.4-.7 0-1.3-.2-1.9-.5 0 2 1.4 3.6 3.2 4-.4.1-.7.1-1.1.1-.3 0-.5 0-.8-.1.5 1.6 2 2.8 3.8 2.8a7.5 7.5 0 01-4.6 1.6c-.3 0-.6 0-.9-.1A10.5 10.5 0 0010 19.5c6.4 0 9.9-5.3 9.9-9.9v-.5c.7-.5 1.3-1.2 1.8-1.9-.6.3-1.3.5-2 .6z" />
                                        </svg>
                                    </a>
                                @elseif ($link->type === \App\Enums\Social::Instagram->name)
                                    <a target="_blank" href="{{ $link->url }}" class="social-ico">
                                        <svg viewBox="0 0 24 24" fill="#fff">
                                            <rect x="4" y="4" width="16" height="16" rx="4"
                                                fill="none" stroke="#fff" stroke-width="1.6" />
                                            <circle cx="12" cy="12" r="3.4" fill="none" stroke="#fff"
                                                stroke-width="1.6" />
                                            <circle cx="16.6" cy="7.4" r="1" fill="#fff" />
                                        </svg>
                                    </a>
                                @elseif ($link->type === \App\Enums\Social::YouTube->name)
                                    <a target="_blank" href="{{ $link->url }}" class="social-ico">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21 6.5s-.2-1.4-.8-2c-.8-.8-1.7-.8-2.1-.9C15.5 3.4 12 3.4 12 3.4s-3.5 0-6.1.2c-.4 0-1.3.1-2.1.9-.6.6-.8 2-.8 2S2.8 8.2 2.8 9.9v1.5c0 1.7.2 3.4.2 3.4s.2 1.4.8 2c.8.8 1.9.8 2.4.9 1.7.2 7.2.2 7.2.2s3.5 0 6.1-.2c.4 0 1.3-.1 2.1-.9.6-.6.8-2 .8-2s.2-1.7.2-3.4V9.9c0-1.7-.2-3.4-.2-3.4z"
                                                stroke="#fff" stroke-width="1.3" />
                                            <path d="M10 8.5l5 3-5 3z" fill="#fff" />
                                        </svg>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <hr class="footer-line">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center py-4 gap-2">
                <div class="mb-0 small">
                    <a target="__blank" href="https://merittutors.co.uk/">Merit Tutors</a>
                    &nbsp;|&nbsp;
                    <a target="__blank" href="https://www.examcentrelondon.co.uk/">Exam Centre London</a>
                </div>
                <p class="mb-0 small">© Copyright Merit Study Resources 2026</p>
            </div>
        </div>
    </footer>
