
<!-- Mobile Menu Section -->
<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($settings->site_logo)) }}" alt="Education Logo Images">
                    </a>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>

                <li>
                    <a href="{{ route('about-us') }}">About us</a>
                </li>
             {{--
                <li>
                    <a href="{{ route('products') }}">Products</a>
                </li>
                @auth()
                    @if(Auth::user()->type !== \App\Enums\UserType::TEACHER->value)
                        <li>
                            <a href="{{ route('pricing') }}">Pricing</a>
                        </li>
                    @endif
                @endauth

                @guest
                    <li>
                        <a href="{{ route('pricing') }}">Pricing</a>
                    </li>
                @endguest

                --}}
                <li>
                    <a href="{{ route('past.papers') }}">Past Papers</a>
                </li>

{{--                <li class="has-dropdown has-menu-child-item">--}}
{{--                    <a href="#">All Resources</a>--}}
{{--                    @if(!empty($allResource))--}}
{{--                        <ul class="submenu">--}}
{{--                            @foreach($allResource as $subjectTitle => $resource)--}}
{{--                                <li class="has-dropdown">--}}
{{--                                    <a href="#">{{ $subjectTitle }}</a>--}}
{{--                                    @if(!empty($resource))--}}
{{--                                        <ul class="submenu">--}}
{{--                                            @foreach($resource as $subject)--}}
{{--                                                <li>--}}
{{--                                                    <a href="{{ route('resources.topic', [$subject['education_level']['slug'], $subject['slug']]) }}">--}}
{{--                                                        {{ $subject['education_level']['name'] }}--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    @endif--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    @endif--}}
{{--                </li>--}}

{{--                <li class="has-dropdown has-menu-child-item">--}}
{{--                    <a href="#">Pages</a>--}}
{{--                    <ul class="submenu">--}}
{{--                        <li class="has-dropdown"><a href="#">All Pages</a>--}}
{{--                            <ul class="submenu">--}}
{{--                                <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>--}}
{{--                                <li><a href="{{ url('/faq') }}">FAQs</a></li>--}}
{{--                                <li><a href="{{ url('/terms-and-conditions') }}">Terms and Condition</a></li>--}}
{{--                                <li><a href="{{ url('/blogs') }}">Blogs</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        </nav>

        <div class="mobile-menu-bottom">
            <div class="rbt-btn-wrapper mb--20">
                @guest
                <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                   href="{{ url('/login') }}">
                    <span>Login</span>
                </a>
                @endguest
                @auth
                <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center" href="{{ route('user.dashboard') }}">
                    <span>Dashboard</span>
                </a>
                @endauth
            </div>


            @if(!empty($socials))
                <div class="social-share-wrapper">
                    <span class="rbt-short-title d-block">Find With Us</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                        @foreach($socials as $list)
                            <li>
                                <a target="_blank" href="{{ $list->url }}">
                                    {!! $list->icon !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- End Mobile Area  -->
