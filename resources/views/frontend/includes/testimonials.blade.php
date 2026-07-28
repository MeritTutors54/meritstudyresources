
<div class="container">
    <div class="text-center mx-auto mb-5" style="max-width:600px;">
        <span class="eyebrow"><span class="divider-dot"></span> TESTIMONIALS</span>
        <h2 class="mt-4" style="font-size:2.2rem;">They talk about us</h2>
        <p class="lead-muted">See what students, parents and teachers are saying about Merit Study Resources.
        </p>
    </div>
    <div class="row g-4">
        @if (!empty($testimonials))
            @foreach ($testimonials as $testimonial)
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path
                                    d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path
                                    d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path
                                    d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path
                                    d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path
                                    d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">
                            {{ $testimonial->description }}
                        </p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                                    <span class="testi-avatar" data-initial="{{ $testimonial->name }}"
                                          style="background:#3D6BFF;"></span>
                            <div>
                                <div class="fw-semibold small">{{ $testimonial->name }}</div>
                                <div class="text-muted-c" style="font-size:.78rem;">
                                    {{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
