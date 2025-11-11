  <div class="deal-update-resource-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="deal-update-resource">
                        <div class="default-title">
                            <span class="default-span">Deals. Updates. Resources.</span>
                            <h2>Unlock Special Offers & Must-Have Resources! Subscribe<span
                                    class="default-shape">e Now - <img
                                        src="{{ asset('frontend/assets/images/merithub/title-shape2.png') }}"
                                        alt=""></span>
                                It’s Free!</h2>
                            <div class="dur-enter-email">
                                <form action="{{ route('collect-emails') }}" method="POST">
                                    <input type="email" name="email" placeholder="Enter your email">
                                    @csrf
                                    <button type="submit"><img src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}" alt="">
                                    </button>
                                </form>

                            </div>
                            @error('email')
                            <div class="form-control-feedback text-danger mt-3">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
