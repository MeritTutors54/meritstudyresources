<div>
    <div class="box-body">
        <div class="row">
            @if($view === 'delivery-charge')
                <div class="col-lg-12 col-12">
                    <div class="form-group">
                        <label for="delivery_charge"
                               class="form-label">(£) Delivery Charge</label>
                        <input type="text"
                               name="delivery_charge"
                               id="delivery_charge"
                               value="{{ old('delivery_charge', $siteSettings->mirror_delivery ?? "") }}"
                               class="form-control"
                               placeholder="Enter delivery charge">
                        @error('delivery_charge')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            @else
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="name"
                               class="form-label">Company Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $siteSettings->name ?? "") }}"
                               class="form-control"
                               placeholder="Enter company name">
                        @error('name')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="email"
                               class="form-label">Company Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $siteSettings->email ?? "") }}"
                               class="form-control"
                               placeholder="Enter company email">
                        @error('email')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="phone"
                               class="form-label">Company Phone</label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               value="{{ old('phone', $siteSettings->phone ?? "") }}"
                               class="form-control"
                               placeholder="Enter company phone">
                        @error('phone')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="fax"
                               class="form-label">Company Fax</label>
                        <input type="text"
                               name="fax"
                               id="fax"
                               value="{{ old('fax', $siteSettings->fax ?? "") }}"
                               class="form-control"
                               placeholder="Enter category name">
                        @error('fax')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="address"
                               class="form-label">Company Address</label>
                        <textarea type="text"
                                  name="address"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter company address"
                                  id="address">{{ old('address', $siteSettings->address ?? "") }}</textarea>
                        @error('address')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <div class="form-group">
                        <label for="logo"
                               class="form-label">Company Logo</label>
                        <input type="file"
                               name="logo"
                               id="logo"
                               class="form-control"
                        >
                        @error('logo')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12 col-12">
                    <div class="form-group">
                        <label for="fab_logo"
                               class="form-label">Company Faviocn</label>
                        <input type="file"
                               name="fab_logo"
                               id="fab_logo"
                               class="form-control"
                        >
                        @error('fab_logo')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

            @endif

        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Cancel</a>
        @can('updateSiteSettings', Auth::user())
            <button type="submit" class="btn btn-success pull-right">Submit</button>
        @endcan
    </div>
</div>
