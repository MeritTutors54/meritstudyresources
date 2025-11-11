<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <div id="sample-holder">
                        <input  id="pdf_sample"
                                name="pdf_sample[]"
                                type="file"
                                class="form-control"
                                accept="image/*">
                    </div>

                    @error('pdf_sample')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
