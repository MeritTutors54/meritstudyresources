<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-৬">
                <div class="form-group">
                    @php
                        $solution=DB::table('product_solutions')->get();
                    @endphp
                    <select name="solution_type[]" class="form-control">
                        <option >Select</option>
                        @foreach($solution as $sol)
                        <option value="{{ $sol->id }}">{{ $sol->solution_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-৬">
                <div class="form-group">
                    <div>
                        <input  id="pdf_sample"
                                name="pdf_sample[]"
                                type="file"
                                class="form-control"
                                accept="">
                    </div>

                    @error('pdf_sample')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="" id="sample-holder">

        </div>
    </div>
</div>
