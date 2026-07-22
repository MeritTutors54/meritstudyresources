<section class="section-pad">
    <div class="container">
        <div class="newsletter-box bg-navy-2 p-5 p-md-5 text-center text-white">
            <span class="eyebrow eyebrow-light"><span class="divider-dot"></span> DEALS &amp; UPDATES</span>
            <h2 class="text-white mt-4 mb-2" style="font-size:1.9rem;">Unlock special offers &amp; must-have
                resources</h2>
            <p class="mb-4" style="color:#B7BEDB;">Subscribe now — it's free, and you can unsubscribe whenever
                you like.</p>
            <form id="newsletter-form" action="{{ route('collect-emails') }}" method="POST"
                  class="d-flex flex-column flex-sm-row gap-3 justify-content-center mx-auto" style="max-width:460px;">
                @csrf
                <input type="email" name="email" class="form-control input-pill" placeholder="Enter your email">
                <button type="submit" class="btn-light-pill flex-shrink-0">Subscribe</button>
            </form>
            <div id="form-error" class="text-danger mt-3 d-none"></div>
            <div id="form-success" class="text-success mt-3 d-none"></div>
        </div>
    </div>
</section>
