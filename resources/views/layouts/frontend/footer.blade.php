<!--================== Start Footer Area ==================-->
<div class="footer-area-main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-area">
                    <div class="footer-contents">
                        <div class="footer-left">

                            <a href="{{ route('home') }}">@if(!empty($settings->site_logo))
                                    <img
                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($settings->site_logo)) }}"
                                        alt="logo">
                                @else
                                    <img src="{{ asset('frontend/assets/images/merithub/logo.png') }}"
                                         alt="Education Logo Images">
                                @endif
                            </a>
                            <p>Explore a vast collection of past papers and</p>
                            <p>resources to excel in your exams.</p>
                            <a href="mailto:{{ $settings->email ?? '' }}">{{ $settings->email ?? '' }}</a>
                        </div>
                        <div class="footer-right">
                            <ul>
                                <p>Company</p>
                                <li><a href="{{ route('about-us') }}">About Us</a></li>
                                <li><a href="{{ route('past.papers') }}">Past Papers</a></li>
                                <li><a href="{{ route('blogs') }}">Blogs</a></li>

                            </ul>
                            <ul>
                                <p>Support</p>
                                <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                                <li><a href="{{ route('faq') }}">FAQs</a></li>
                                <li><a href="{{ route('terms-condition') }}">Terms of Condition</a></li>
                                <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('refund.policy') }}">Refund Policy</a></li>
                            </ul>
                            <ul>
                                <p>Connect</p>
                                @if (!empty($socials))
                                    @foreach ($socials as $link)
                                        <li>
                                            <a target="_blank" href="{{ $link->url }}">{{ $link->type }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="footer-copyright">
                        <ul>
                            <li><a target="__blank" href="https://merittutors.co.uk/">Merit Tutors</a></li>
                            <li><a target="__blank" href="https://www.examcentrelondon.co.uk/">Exam Centre London</a></li>
                            {{-- <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li> --}}
                        </ul>
                        <p>© Copyright Merit Study Resources. {{ now()->year }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================== End Footer Area ==================-->


<!-- Back to Top -->
<div class="rbt-progress-parent">
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<!--================== Modal Area ==================-->
<!-- Modal -->
<div class="modal fade" id="subscription-pause-modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="width: 560px !important;">
            <div class="modal-header bg-warning">
                <h5>Pause Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Are you sure want to pause the subscription?</small>
            </div>
            <div class="modal-footer">
                <form id="subscription-pause-modal-action" method="post">
                    @csrf
                    <button type="button" class="btn btn-secondary modal-button" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning modal-button">Pause Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="subscription-cancel-modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="width: 560px">
            <div class="modal-header bg-danger">
                <h5 class="text-white">Subscription Cancellation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Are you sure want to cancel the subscription?</small>
            </div>
            <div class="modal-footer">
                <form id="subscription-cancel-modal-action" method="post">
                    @csrf
                    <button type="button" class="btn btn-secondary modal-button" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger modal-button">Cancel Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="subscription-resume-modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="width: 560px !important;">
            <div class="modal-header bg-success">
                <h5 class="text-white">Subscription Cancellation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Are you sure want to resume the subscription?</small>
            </div>
            <div class="modal-footer">
                <form id="subscription-resume-modal-action" method="post">
                    @csrf
                    <button type="button" class="btn btn-secondary modal-button" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success modal-button">Resume Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>
