<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="page_title">Page Reference</label>
                    <select name="page_title"
                            id="page_title"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($pages))
                            @foreach($pages as $page)
                                <option
                                    {{ old('page_title', isset($seo_setting) ? $seo_setting->page_title : "") === $page->value ? 'selected' : '' }}
                                    value="{{ $page->value }}">
                                    {{ $page->value }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('page_title')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="meta_title"
                           class="form-label">Meta Title</label>
                    <textarea name="meta_title"
                              id="meta_title"
                              class="form-control"
                              placeholder="Enter meta title"
                              rows="3">{{ old('meta_title', $seo_setting->meta_title ?? "") }}</textarea>
                    @error('meta_title')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="meta_author"
                           class="form-label">Meta Author</label>
                    <textarea name="meta_author"
                              id="meta_author"
                              class="form-control"
                              placeholder="Enter meta author"
                              rows="3">{{ old('meta_author', $seo_setting->meta_author ?? "") }}</textarea>
                    @error('meta_author')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="meta_keywords"
                           class="form-label">Meta Keywords</label>
                    <textarea name="meta_keywords"
                              id="meta_keywords"
                              class="form-control"
                              placeholder="Enter meta keywords"
                              rows="3">{{ old('meta_keywords', $seo_setting->meta_keywords ?? "") }}</textarea>
                    @error('meta_keywords')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="meta_description"
                           class="form-label">Meta Description</label>
                    <textarea name="meta_description"
                              id="meta_description"
                              class="form-control"
                              placeholder="Enter meta description"
                              rows="3">{{ old('meta_description', $seo_setting->meta_description ?? "") }}</textarea>
                    @error('meta_description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div>
                {{--            <div class="col-lg-6 col-12">--}}
                {{--                <div class="form-group">--}}
                {{--                    <label for="google_verification"--}}
                {{--                           class="form-label">Google Verification</label>--}}
                {{--                    <textarea name="google_verification"--}}
                {{--                              id="google_verification"--}}
                {{--                              class="form-control"--}}
                {{--                              placeholder="Enter meta verification"--}}
                {{--                              rows="3">{{ old('google_verification', $seo->google_verification ?? "") }}</textarea>--}}
                {{--                    @error('google_verification')--}}
                {{--                    <div class="form-control-feedback text-danger mt-1">--}}
                {{--                        {{ $message }}--}}
                {{--                    </div>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}
                {{--            </div>--}}

                {{--            <div class="col-lg-6 col-12">--}}
                {{--                <div class="form-group">--}}
                {{--                    <label for="bing_verification"--}}
                {{--                           class="form-label">Bing Verification</label>--}}
                {{--                    <textarea name="bing_verification"--}}
                {{--                              id="bing_verification"--}}
                {{--                              class="form-control"--}}
                {{--                              placeholder="Enter bing verification"--}}
                {{--                              rows="3">{{ old('bing_verification', $seo->bing_verification ?? "") }}</textarea>--}}
                {{--                    @error('bing_verification')--}}
                {{--                    <div class="form-control-feedback text-danger mt-1">--}}
                {{--                        {{ $message }}--}}
                {{--                    </div>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}
                {{--            </div>--}}

                {{--            <div class="col-lg-6 col-12">--}}
                {{--                <div class="form-group">--}}
                {{--                    <label for="google_analytics"--}}
                {{--                           class="form-label">Google Analytics</label>--}}
                {{--                    <textarea name="google_analytics"--}}
                {{--                              id="google_analytics"--}}
                {{--                              class="form-control"--}}
                {{--                              placeholder="Enter google analytics"--}}
                {{--                              rows="3">{{ old('google_analytics', $seo->google_analytics ?? "") }}</textarea>--}}
                {{--                    @error('google_analytics')--}}
                {{--                    <div class="form-control-feedback text-danger mt-1">--}}
                {{--                        {{ $message }}--}}
                {{--                    </div>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.seo-settings.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
