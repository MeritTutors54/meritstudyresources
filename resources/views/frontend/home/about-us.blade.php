<div class="about-area-main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="about-area">
                    <div class="countdown-main" id="about-area-countdown">
                        <div class="countdown-single">
                            <div class="countdown-single-icon"><img
                                    src="{{ asset('frontend/assets/images/merithub/icon1.png') }}" alt=""></div>
                            <h2>{{ $counter['past_papers'] }}+</h2>
                            <p>Past Papers</p>
                        </div>
                        <div class="countdown-single">
                            <div class="countdown-single-icon"><img
                                    src="{{ asset('frontend/assets/images/merithub/icon2.png') }}" alt=""></div>
                            <h2>{{ $counter['resources'] }}+</h2>
                            <p>Worksheet</p>
                        </div>
                        <div class="countdown-single">
                            <div class="countdown-single-icon"><img
                                    src="{{ asset('frontend/assets/images/merithub/icon3.png') }}" alt=""></div>
                            <h2>{{ $counter['users'] }}+</h2>
                            <p>Users</p>
                        </div>
                        <div class="countdown-single">
                            <div class="countdown-single-icon"><img
                                    src="{{ asset('frontend/assets/images/merithub/icon4.png') }}" alt=""></div>
                            <h2>{{ $counter['students'] }}+</h2>
                            <p>Certified Students</p>
                        </div>
                    </div>
                    <div class="about-us-contents">
                        <div class="about-us-left">
                            <img src="{{ asset('frontend/assets/images/merithub/banner.png') }}" alt="">
                        </div>
                        <div class="about-us-right">
                            <div class="default-title">
                                <span class="default-span">About Us</span>
                                <h1>With expert-crafted revision resources from <span
                                        class="default-shape">MeritStudyResource <img
                                            src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}"
                                            alt=""></span></h1>
                            </div>
                            <div class="about-us-right-contents">
                                <div class="aurc-single">
                                    <div class="aurc-single-left"><i class="fa-solid fa-circle-check"></i></div>
                                    <div class="aurc-single-right">
                                        <p><b>Available Resources</b></p>
                                        <p>Access expertly crafted study guides and revision materials tailored to
                                            your
                                            specific exam board requirements</p>
                                    </div>
                                </div>
                                <div class="aurc-single">
                                    <div class="aurc-single-left"><i class="fa-solid fa-circle-check"></i></div>
                                    <div class="aurc-single-right">
                                        <p><b>Affordable Fees</b></p>
                                        <p>Boost your confidence with resources designed to help you achieve top
                                            grades
                                            and excel in your studies.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('past.papers') }}" class="btn-style2 btn-style2c">View All Resources <span><img
                                        src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}" alt=""></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Utility: Count-up function
    function countUp(element, target, duration) {
        let start = 0;
        let startTime = null;

        function animate(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            element.textContent = Math.floor(progress * target) + "+";
            if (progress < 1) requestAnimationFrame(animate);
        }

        requestAnimationFrame(animate);
    }

    // Scroll trigger: Only run once
    let hasAnimated = false;
    window.addEventListener("scroll", function () {
        const section = document.getElementById("about-area-countdown");
        const position = section.getBoundingClientRect().top;
        const screenHeight = window.innerHeight;

        if (!hasAnimated && position < screenHeight) {
            hasAnimated = true;
            const counters = section.querySelectorAll("h2");

            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace("+", ""));
                countUp(counter, target, 2000); // 2 sec duration
            });
        }
    });
</script>
