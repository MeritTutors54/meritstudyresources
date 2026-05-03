<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Tag Title</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $blog_tag->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter blog title name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.blog-tags.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
