
<section class="section-pad bg-mint" id="pricing">
    <div class="container">
        <div class="text-center mb-5">
            <span class="eyebrow"><span class="divider-dot"></span> OUR PRICING</span>
            <h2 class="mt-4 mb-3" style="font-size:2.2rem;">The right price for you, whoever you are</h2>
            <p class="lead-muted mx-auto" style="max-width:520px;">Paid plans unlock resources across every year
                group — switch or cancel anytime.</p>
        </div>

        <div class="d-flex flex-column align-items-center mb-5">
            <ul class="nav pill-tabs mb-4" id="audienceTabs" role="tablist">
                @guest()
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#school-pane"
                            type="button">School</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#student-pane"
                            type="button">Student</button>
                    </li>
                @endguest
                @auth()
                    @if (Auth::user()->type === \App\Enums\UserType::SCHOOL->value)
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#school-pane"
                                type="button">School</button>
                        </li>
                    @else
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#student-pane"
                                type="button">Student</button>
                        </li>
                    @endif
                @endauth
            </ul>
            <div class="seg-toggle">
                <button class="seg-btn active" id="yearlyBtn" onclick="setBilling('yearly')">Yearly Plan</button>
                <button class="seg-btn" id="monthlyBtn" onclick="setBilling('monthly')">Monthly Plan</button>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="school-pane">
                <div class="row g-4 justify-content-center">
                    @if ($subscriptionPricing->isNotEmpty())
                        @foreach ($subscriptionPricing as $k => $plan)
                            <div class="col-md-6 col-lg-4">
                                <div class="price-card {{ $k == 'standard' ? 'featured' : '' }}">
                                    @if ($k == 'standard')
                                        <span class="featured-tag">Most popular</span>
                                    @endif
                                    <h3 class="h6 text-muted-c text-uppercase"
                                        style="font-size:.8rem;letter-spacing:.06em;">
                                        {{ $plan['school']['yearly'][0]->name }}
                                    </h3>
                                    <div class="price-amount">
                                        <span class="price-display"
                                            data-yearly="£{{ $plan['school']['yearly'][0]->price }}"
                                            data-monthly="£{{ $plan['school']['monthly'][0]->price }}">
                                            £{{ $plan['school']['yearly'][0]->price }}
                                        </span>
                                        <span class="fs-6 text-muted-c">/
                                            <span class="period-label">yearly</span>
                                        </span>
                                    </div>
                                    <p class="lead-muted" style="font-size:.88rem;">Full access for whole-school
                                        rollout.
                                    </p>
                                    <div class="ticket-cut"></div>
                                    <ul class="price-list">
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>User limit: 10</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Unlimited package downloads</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Full library access</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Dedicated account manager</li>
                                    </ul>
                                    @if ($k == 'standard')
                                        <a href="#" class="btn-brand w-100 justify-content-center mt-4">Select
                                            Package</a>
                                    @else
                                        <a href="#"
                                            class="btn-ghost-navy w-100 justify-content-center mt-4">Select
                                            Package</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="student-pane">
                <div class="row g-4 justify-content-center">
                    @if ($subscriptionPricing->isNotEmpty())
                        @foreach ($subscriptionPricing as $k => $plan)
                            <div class="col-md-6 col-lg-4">
                                <div class="price-card {{ $k == 'standard' ? 'featured' : '' }}">
                                    @if ($k == 'standard')
                                        <span class="featured-tag">Most popular</span>
                                    @endif
                                    <h3 class="h6 text-muted-c text-uppercase"
                                        style="font-size:.8rem;letter-spacing:.06em;">
                                        {{ $plan['student']['yearly'][0]->name }}
                                    </h3>
                                    <div class="price-amount">
                                        <span class="price-display"
                                            data-yearly="£{{ $plan['student']['yearly'][0]->price }}"
                                            data-monthly="£{{ $plan['student']['monthly'][0]->price }}">
                                            £{{ $plan['student']['yearly'][0]->price }}
                                        </span>
                                        <span class="fs-6 text-muted-c">/
                                            <span class="period-label">yearly</span>
                                        </span>
                                    </div>
                                    <p class="lead-muted" style="font-size:.88rem;">Full access for whole-school
                                        rollout.
                                    </p>
                                    <div class="ticket-cut"></div>
                                    <ul class="price-list">
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>User limit: 10</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Unlimited package downloads</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Full library access</li>
                                        <li><svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                    stroke-linecap="round" />
                                            </svg>Dedicated account manager</li>
                                    </ul>
                                    @if ($k == 'standard')
                                        <a href="#" class="btn-brand w-100 justify-content-center mt-4">Select
                                            Package</a>
                                    @else
                                        <a href="#"
                                            class="btn-ghost-navy w-100 justify-content-center mt-4">Select
                                            Package</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
