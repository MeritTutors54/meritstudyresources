<div class="testimonials-area-main">
    <div class="testimonials">
        <div class="default-title">
            <span class="default-span">Testimonials</span>
            <h2>They talk <span class="default-shape">about us<img
                        src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}" alt=""></span>
            </h2>
            <p>See What Students and Teachers Are Saying About Merit Hub!</p>
        </div>
        <div class="testimonials-carousel">
            <div class="testimonials-track">
                @if(!empty($testimonials))
                    @foreach($testimonials as $testimonial)
                            <div class="testimonials-single">
                                <div class="testimonials-single-contents">
                                    <img src="{{ asset('frontend/assets/images/merithub/review.png') }}" alt="">
                                    <p>{{ $testimonial->description }}</p>
                                </div>
                                <div class="ts-profile">
                                    <div class="ts-profile-left">
                                        <div class="ts-profile-img">
                                            <img src="https://ui-avatars.com/api/?name={{ $testimonial->name }}" alt="{{ $testimonial->name }}">
                                        </div>
                                        <div class="ts-profile-text">
                                            <p>{{ $testimonial->name }}</p>
                                            <span>{{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ts-profile-right"><img
                                            src="{{ asset('frontend/assets/images/merithub/favicon2.png') }}" alt=""></div>
                                </div>
                            </div>
                    @endforeach


                    <!-- Repeat again for infinite effect -->
                    @foreach($testimonials as $testimonial)
                        <div class="testimonials-single">
                            <div class="testimonials-single-contents">
                                <img src="{{ asset('frontend/assets/images/merithub/review.png') }}" alt="">
                                <p>{{ $testimonial->description }}</p>
                            </div>
                            <div class="ts-profile">
                                <div class="ts-profile-left">
                                    <div class="ts-profile-img">
                                        <img src="https://ui-avatars.com/api/?name={{ $testimonial->name }}"
                                             alt="{{ $testimonial->name }}">
                                    </div>
                                    <div class="ts-profile-text">
                                        <p>{{ $testimonial->name }}</p>
                                        <span>{{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}</span>
                                    </div>
                                </div>
                                <div class="ts-profile-right"><img
                                        src="{{ asset('frontend/assets/images/merithub/favicon2.png') }}" alt=""></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- TESTIMONIALS CAROUSEL-2 -->
        <div class="testimonials-carousel testimonials-carousel2">
            <div class="testimonials-track">
                @if(!empty($testimonials))
                    @foreach($testimonials as $testimonial)
                        <div class="testimonials-single">
                            <div class="testimonials-single-contents">
                                <img src="{{ asset('frontend/assets/images/merithub/review.png') }}" alt="">
                                <p>{{ $testimonial->description }}</p>
                            </div>
                            <div class="ts-profile">
                                <div class="ts-profile-left">
                                    <div class="ts-profile-img">
                                        <img src="https://ui-avatars.com/api/?name={{ $testimonial->name }}" alt="{{ $testimonial->name }}">
                                    </div>
                                    <div class="ts-profile-text">
                                        <p>{{ $testimonial->name }}</p>
                                        <span>{{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}</span>
                                    </div>
                                </div>
                                <div class="ts-profile-right"><img
                                        src="{{ asset('frontend/assets/images/merithub/favicon2.png') }}" alt=""></div>
                            </div>
                        </div>
                    @endforeach


                    <!-- Repeat again for infinite effect -->
                    @foreach($testimonials as $testimonial)
                        <div class="testimonials-single">
                            <div class="testimonials-single-contents">
                                <img src="{{ asset('frontend/assets/images/merithub/review.png') }}" alt="">
                                <p>{{ $testimonial->description }}</p>
                            </div>
                            <div class="ts-profile">
                                <div class="ts-profile-left">
                                    <div class="ts-profile-img">
                                        <img src="https://ui-avatars.com/api/?name={{ $testimonial->name }}"
                                             alt="{{ $testimonial->name }}">
                                    </div>
                                    <div class="ts-profile-text">
                                        <p>{{ $testimonial->name }}</p>
                                        <span>{{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}</span>
                                    </div>
                                </div>
                                <div class="ts-profile-right"><img
                                        src="{{ asset('frontend/assets/images/merithub/favicon2.png') }}" alt=""></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

{{--        <div class="discuss-and-discover-btn"><a href="#" class="btn-style">View All</a></div>--}}
    </div>
</div>
