<div>
    <div class="box-body">
        <style>
            .site-logo {
                width: 200px; /* set fixed width */
                height: 60px; /* set fixed height */
                object-fit: contain; /* keeps aspect ratio inside box */
                display: block; /* avoids inline spacing issues */
                margin: 0 auto; /* centers if needed */
            }
        </style>
        <div class="row">
            @if(isset($siteSettings) && !empty($siteSettings->site_logo))
                <div class="col-lg-12 col-12">
                    <label>Site Logo</label>
                    <img class="site-logo"
                         src="{{ asset(\Illuminate\Support\Facades\Storage::url($siteSettings->site_logo)) }}"
                         alt="site logo">
                </div>
            @endif

            @if(isset($siteSettings) && !empty($siteSettings->site_favicon))
                <div class="col-lg-12 col-12">
                    <label>Site Favicon</label>
                    <img class="site-logo"
                         src="{{ asset(\Illuminate\Support\Facades\Storage::url($siteSettings->site_favicon)) }}"
                         alt="site favicon">
                </div>
            @endif
        </div>
    </div>
</div>
