<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-10 col-12">
                <div class="form-group">
                    <label for="title"
                           class="form-label">Blog Title</label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $blog->title ?? "") }}"
                           class="form-control"
                           placeholder="Enter blog title name">
                    @error('title')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($statuses))
                            @foreach($statuses as $status)
                                <option
                                    {{ old('status', isset($blog) ? (string)$blog->status : "1") === (string)$status->value ? 'selected' : '' }}
                                    value="{{ $status->value }}">
                                    {{ ucfirst(strtolower($status->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('status')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="blog_category_id">Blog Categories</label>
                    <select name="blog_category_id"
                            id="blog_category_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($blogCategories))
                            @foreach($blogCategories as $blogCategory)
                                <option
                                    {{ old('blog_category_id', isset($blog) ? (string)$blog->blog_category_id : "") === (string)$blogCategory->id ? 'selected' : '' }}
                                    value="{{ $blogCategory->id }}">
                                    {{ $blogCategory->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('blog_category_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            @php

                $tagBox = isset($blog) ? $blog->tags->pluck('name')->toArray() : '';
//                foreach($tags as $tag) {
//                dd(old('blog_tags', isset($blog) ? $tagBox : ""));
//
//                }
            @endphp

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="blog_tags">Tags</label>
                    <select name="blog_tags[]"
                            id="blog_tags" multiple="multiple"
                            class="form-select js-example-basic-single">
                        <option value="">Select...</option>
                        @if(!empty($tags))
                            @foreach($tags as $tag)
                                <option
                                    {{  in_array($tag->name, old('blog_tags', isset($blog) ?  $tagBox : [])) ? 'selected' : '' }}
                                    value="{{ $tag->name }}">
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('blog_tags')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="blog_image">Image</label>
                    <input type="file"
                           accept="image/*"
                           name="blog_image" id="blog_image" class="form-control">
                    @error('blog_image')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="description">Blog Description</label>
                    <textarea
                        class="form-control"
                        placeholder="Type the content here!"
                        id="description" name="description" rows="4"
                    >{{ old('description', $blog->description ?? '') }}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="blog_category_id">Blog Content</label>
                    <textarea
                        placeholder="Type the content here!"
                        id="editor1" name="details" rows="10"
                        cols="80">{!! old('details', $blog->details ?? '') !!}</textarea>
                    @error('blog_category_id')
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
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
