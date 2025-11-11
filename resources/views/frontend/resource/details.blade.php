@extends('layouts.frontend', ['main_title' => 'All Resource - MeritStudyResource.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $seo['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['meta_keywords'] ?? '' }}">
    <meta name="author" content="{{ $seo['meta_author'] ?? '' }}">
@endsection
@section('page-css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
@endsection
@section('content')
    <div class="resources-page-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="resources-page-area">
                        <div class="search-bar active mb-5">
                            <form action="{{ route('resource.search') }}">
                                <input type="search"
                                       name="q"
                                       placeholder="search any topic/content">
                                <button type="submit">Search</button>
                                <img src="{{ asset("frontend/assets/images/all-resources/search.png")}}" alt="">
                            </form>
                        </div>
                        <div class="resources_page_contents">
                            <!-- Start Left Site -->
                            @include('frontend.resource.support._left_side')
                            <!-- End Left Site -->

                            <!-- Start Right Site -->
                            @if(!empty($resource))
                                <div class="resources_page_right">
                                    <div class="resources_page_right_pagination">
                                        <ul>
                                            @if(!empty($levelModel))
                                                <li>
                                                    <a href="{{ route('resource.category', [$levelModel->slug]) }}">
                                                        {{ ucfirst($levelModel->name) }}
                                                    </a>
                                                </li>
                                            @endif

                                            @if(!empty($subjectModel))
                                                <li><i class="fa-solid fa-angle-right"></i></li>
                                                <li>
                                                    <a href="{{ route('resources.topic', [$levelModel->slug, $subjectModel->slug]) }}">
                                                        {{ ucfirst($subjectModel->name) }} WorkSheet
                                                    </a>
                                                </li>
                                            @endif

                                            @if(!empty($groupModel))
                                                <li><i class="fa-solid fa-angle-right"></i></li>
                                                <li><a href="">{{ ucfirst($groupModel->name) }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="resources_page_right_title_main">
                                        <div class="resources_page_right_title">
                                            <div class="rprt_h3title d-flex align-items-center justify-content-between">
                                                <h3>{{ ucfirst($resource?->name) }}</h3>
                                                <div class="rprt_page_count">
                                                    <a href="#" class="rpri_pages"><img
                                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                                            alt="">
                                                        {{ $resource->allPage->count() }} pages
                                                    </a>
                                                </div>
                                            </div>
                                            <p>{{ $resource->description }}</p>
                                        </div>

                                    </div>


                                    @guest()
                                        <div class="single_full_image">
                                            <img
                                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                                alt="">
                                            <div class="single_resources_popup">
                                                <div class="sr_popup_title">
                                                    <h5>Please Login to continue</h5>
                                                    {{--                                                        <p>Including a 7 day free trial of everything</p>--}}
                                                </div>
                                                <div class="sr_popup_form">
                                                    <form id="loginForm" action="{{ route('ajax.login') }}"
                                                          method="post">
                                                        <div class="sr_popup_form_single">
                                                            <label for="email">Email</label>
                                                            <input type="text" id="email"
                                                                   placeholder="Type Your Email">
                                                            <svg width="15" height="11" viewBox="0 0 15 11"
                                                                 fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.5 0H1.5C0.675 0 0.00749999 0.61875 0.00749999 1.375L0 9.625C0 10.3813 0.675 11 1.5 11H13.5C14.325 11 15 10.3813 15 9.625V1.375C15 0.61875 14.325 0 13.5 0ZM13.2 2.92188L7.8975 5.96063C7.6575 6.09812 7.3425 6.09812 7.1025 5.96063L1.8 2.92188C1.7248 2.88318 1.65894 2.83089 1.60642 2.76819C1.55389 2.70548 1.5158 2.63366 1.49443 2.55707C1.47307 2.48048 1.46888 2.40071 1.48212 2.32259C1.49536 2.24447 1.52575 2.16962 1.57146 2.10258C1.61717 2.03554 1.67724 1.9777 1.74804 1.93256C1.81885 1.88742 1.8989 1.85591 1.98337 1.83996C2.06784 1.824 2.15496 1.82391 2.23947 1.83971C2.32397 1.85551 2.4041 1.88687 2.475 1.93187L7.5 4.8125L12.525 1.93187C12.5959 1.88687 12.676 1.85551 12.7605 1.83971C12.845 1.82391 12.9322 1.824 13.0166 1.83996C13.1011 1.85591 13.1812 1.88742 13.252 1.93256C13.3228 1.9777 13.3828 2.03554 13.4285 2.10258C13.4742 2.16962 13.5046 2.24447 13.5179 2.32259C13.5311 2.40071 13.5269 2.48048 13.5056 2.55707C13.4842 2.63366 13.4461 2.70548 13.3936 2.76819C13.3411 2.83089 13.2752 2.88318 13.2 2.92188Z"
                                                                    fill="#B0B0B0"></path>
                                                            </svg>
                                                        </div>
                                                        <small class="text-danger d-none email_warning_one">Email is
                                                            required!</small>
                                                        <small class="text-danger d-none email_warning_two">Please enter
                                                            a valid email address.</small>
                                                        <div class="sr_popup_form_single">
                                                            <label for="password">Password</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i
                                                                            class="fas fa-eye-slash" id="eye"></i>
                                                                    </div>
                                                                </div>
                                                                <input type="password" id="password"
                                                                       placeholder="Enter Password">
                                                                <svg width="12" height="16" viewBox="0 0 12 16"
                                                                     fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M9.75 5.00002H9V3.58252C9 2.78687 8.68393 2.02381 8.12132 1.4612C7.55871 0.89859 6.79565 0.58252 6 0.58252C5.20435 0.58252 4.44129 0.89859 3.87868 1.4612C3.31607 2.02381 3 2.78687 3 3.58252V5.00002H2.25C1.65326 5.00002 1.08097 5.23707 0.65901 5.65903C0.237053 6.08099 0 6.65328 0 7.25002V13.25C0 13.8468 0.237053 14.4191 0.65901 14.841C1.08097 15.263 1.65326 15.5 2.25 15.5H9.75C10.3467 15.5 10.919 15.263 11.341 14.841C11.7629 14.4191 12 13.8468 12 13.25V7.25002C12 6.65328 11.7629 6.08099 11.341 5.65903C10.919 5.23707 10.3467 5.00002 9.75 5.00002ZM4.5 3.58252C4.48991 3.17399 4.64209 2.77811 4.92321 2.48152C5.20434 2.18493 5.59152 2.0118 6 2.00002C6.40848 2.0118 6.79566 2.18493 7.07679 2.48152C7.35791 2.77811 7.51009 3.17399 7.5 3.58252V5.00002H4.5V3.58252ZM6 12.5C5.55499 12.5 5.11998 12.3681 4.74997 12.1208C4.37996 11.8736 4.09157 11.5222 3.92127 11.1111C3.75097 10.6999 3.70642 10.2475 3.79323 9.81107C3.88005 9.37461 4.09434 8.9737 4.40901 8.65903C4.72368 8.34436 5.12459 8.13007 5.56105 8.04325C5.9975 7.95644 6.4499 8.00099 6.86104 8.17129C7.27217 8.34159 7.62357 8.62998 7.87081 8.99999C8.11804 9.37 8.25 9.80501 8.25 10.25C8.25 10.8468 8.01295 11.4191 7.59099 11.841C7.16903 12.263 6.59674 12.5 6 12.5Z"
                                                                        fill="#B0B0B0"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger d-none password_warning">Password is
                                                            required!</small>
                                                        <div
                                                            class="sr_popup_form_single d-flex align-items-center mb-0">
                                                            <input type="checkbox" id="check_agree" value="1">
                                                            <label for="check_agree">I agree to the <a target="_blank"
                                                                                                       href="{{ route('terms-condition') }}">Terms
                                                                    and
                                                                    Conditions</a> and <a
                                                                    href="{{ route('privacy.policy') }}"
                                                                    target="_blank">Privacy
                                                                    Policy</a></label>
                                                        </div>
                                                        <small class="text-danger d-none check_agree_warning">You must
                                                            check this box!</small>
                                                        <div class="srpf_submit mt-5">
                                                            <button type="submit" class="btn-style">
                                                                Login to my account
                                                            </button>
                                                        </div>

                                                        <div
                                                            class="max-width-auto google-login-button mt-5 form-submit-group text-center">
                                                            <a href="{{ url('auth/google') }}"
                                                               class="login-with-google-btn">
                                                                Sign in with Google
                                                            </a>
                                                        </div>


                                                        <div class="srpf_signin"><p>Do not have an account? <a
                                                                    href="{{ route('register') }}">Sign
                                                                    Up</a></p></div>
                                                        <div class="srpf_feature_list">
                                                            <p>Free Accounts Include</p>
                                                            <ul>
                                                                <li><i class="fa-solid fa-circle-check"></i> View /
                                                                    Print
                                                                    monthly free resources forever
                                                                </li>
                                                                <li><i class="fa-solid fa-circle-check"></i> View
                                                                    everything
                                                                    for 7 days
                                                                </li>
                                                                <li><i class="fa-solid fa-circle-check"></i> Choose
                                                                    any
                                                                    5
                                                                    resources to download
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endguest

                                    @auth()
                                        @if($resource->is_paid === \App\Enums\Statement::YES->value)
                                            @if(Auth::user()->hasActiveSubscription())
                                                <div class="single_full_image">
                                                    <img
                                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                                        alt="">
                                                    <div class="single_resources_popup my-padding">
                                                        <div class="sr_popup_title">
                                                            <div
                                                                class="position-absolute top-0 start-50 translate-middle-x my-download-button"
                                                                style="z-index: 9">
                                                                <button
                                                                    type="button"
                                                                    data-slug="{{ $resource->slug }}"
                                                                    data-name="{{ $resource->name }}"
                                                                    class="btn-style downloadFile">
                                                                    Download
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="single_full_image">
                                                    <img
                                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                                        alt="">
                                                    <div class="single_resources_popup">
                                                        <div class="sr_popup_title">
                                                            <img
                                                                src="{{ asset("frontend/assets/images/all-resources/lock.png") }}"
                                                                alt="">
                                                            <h5>Access Premium Content!</h5>
                                                            <p>Unlock this Resource with a Subscription</p>
                                                            <p class="mt-4">You’ve reached a premium resource. Your free
                                                                trial lets you preview selected content - but to
                                                                continue
                                                                exploring this, you’ll need to subscribe.</p>
                                                        </div>
                                                        <div class="sr_popup_form">
                                                            <div class="srpf_feature_list">
                                                                <p>Features List</p>
                                                                <ul>
                                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                                        Unlimited
                                                                        access to 1000+ curated resource
                                                                    </li>
                                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                                        Expert-picked learning paths
                                                                    </li>
                                                                    <li><i class="fa-solid fa-circle-check"></i>
                                                                        Download
                                                                        &amp; offline reading
                                                                    </li>
                                                                    <li><i class="fa-solid fa-circle-check"></i> Early
                                                                        access to new content
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="srpf_subscriptions">
                                                                <a href="{{ route('pricing') }}" class="btn-style2">Explore
                                                                    Our Subscriptions <span><img
                                                                            src="{{ asset("frontend/assets/images/merithub/arrow-right.png")}}"
                                                                            alt=""></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h1>hello</h1>
                                            <div class="pdf-image-holder">
                                                @if(!empty($resource->getAllPageAsBase64()))
                                                    <div class="bridge-box">
                                                        @foreach($resource->getAllPageAsBase64() as $k => $page)
                                                            <a href="{{ $page->base64 }}" data-fancybox="gallery-a"
                                                               data-caption="Gallery A #1">
                                                                <img src="{{ $page->base64 }}"
                                                                     alt="{{ $resource->name . '-' . $k+1 }}">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            @if(Auth::user()->hasActiveSubscription() !== false)
                                                <div class="mt-5">
                                                    <button
                                                        type="button"
                                                        data-slug="{{ $resource->slug }}"
                                                        data-name="{{ $resource->name }}"
                                                        class="btn-style downloadFile">
                                                        Download
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    @endauth


                                    @if(!empty($relatedResources))
                                        <div class="resources_page_right_items_all">
                                            <div class="rpri_title">
                                                <h5>Related Resources</h5>
                                                <p>View other related resources that matches with your choices.</p>
                                            </div>
                                            <div class="resources_page_right_items">
                                                @foreach($relatedResources as $item)
                                                    <div class="rpr_single_item clickable"
                                                         data-link="{{ route("resources.topic.details", [$item, $item->slug]) }}">
                                                        <img
                                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->thumbnail_image)) }}"
                                                            alt="">
                                                        <a href="#" class="rpri_pages">
                                                            <img
                                                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->thumbnail_image)) }}"
                                                                alt="">
                                                            {{ $item->allPage->count() }}
                                                        </a>
                                                        <div class="rpri_writen">
                                                            <h6>{{ ucfirst($item->name) }}</h6>
                                                            <p>{{ ucfirst($item->description) }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endif
                            <!-- End Right Site -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {});


        function downloadFile(url, filename) {
            console.log(url)
            // Create a temporary anchor element
            var a = document.createElement('a');
            a.href = url;
            a.download = filename + '.pdf' || 'download.pdf';

            // Trigger the click programmatically
            document.body.appendChild(a);
            a.click();

            // Clean up
            document.body.removeChild(a);
            $(".downloadFile").prop("disabled", false);
        }

        let downloadButton = $(".downloadFile");

        downloadButton.on('click', function () {
            console.log('download is processing....')
            downloadButton.prop("disabled", true);
            let slug = $(this).data('slug');
            let name = $(this).data('name');
            const url = '{{ route('user.ajax.download.pdf') }}';

            $.ajax({
                url: url, // your actual filename
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    _slug: slug
                },
                success: function (response) {
                    if (response.fileUrl) {
                        downloadFile(response.fileUrl, response.filename);
                    }
                },
                error: function (error) {
                    downloadButton.prop("disabled", false);
                    // alert(error.responseJSON.message);
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON.message,
                        icon: 'error',
                        customClass: 'swal-wide',
                        confirmButtonText: 'Close'
                    })
                }
            });
        });

        $(".clickable").on("click", function () {
            let href = $(this).data('link');
            window.location.replace(href);
        })

        $("#loginForm").submit(function (e) {
            e.preventDefault();

            const smallTags = $('#loginForm').find('small');
            smallTags.each(function (index, element) {
                $(element).addClass('d-none'); // Apply changes to each element
            });

            let url = $(this).attr('action');
            let email = $("#email").val();
            let password = $("#password").val();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;

            if (!email) {
                $(".email_warning_one").removeClass('d-none');
                return;
            } else if (!emailRegex.test(email)) {
                $(".email_warning_two").removeClass('d-none');
                return;
            }

            if (!password) {
                $(".password_warning").removeClass('d-none');
                return;
            }

            if (!$('#check_agree').is(':checked')) {
                $('.check_agree_warning').removeClass("d-none");
                return;
            }


            $.ajax({
                url: url,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,
                    password: password
                },
                success: function (response) {
                    if (response.success) {
                        // Handle successful login
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'Success',
                            customClass: 'swal-wide',
                        })
                        location.reload();
                    }
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON.message,
                        icon: 'error',
                        customClass: 'swal-wide',
                        confirmButtonText: 'Close'
                    })
                }
            });
        })
    </script>
@endsection
