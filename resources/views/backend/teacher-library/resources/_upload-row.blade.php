{{-- One upload row on the lesson page. $i = row index (or __i__ in the template), $row = old input. --}}
<div class="upload-row border rounded p-3 mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">File type</label>
            <select name="files[{{ $i }}][resource_type_id]" class="form-select upload-type" required>
                <option value="">Choose…</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" data-name="{{ $type->name }}" @selected((string) ($row['resource_type_id'] ?? '') === (string) $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            @if (is_int($i)) @include('backend.teacher-library.partials.error', ['field' => "files.$i.resource_type_id"]) @endif
        </div>
        <div class="col-md-4">
            <label class="form-label">Title</label>
            <input type="text" name="files[{{ $i }}][title]" value="{{ $row['title'] ?? '' }}" maxlength="200" required
                   class="form-control upload-title" placeholder="Filled in when you pick a type">
            @if (is_int($i)) @include('backend.teacher-library.partials.error', ['field' => "files.$i.title"]) @endif
        </div>
        <div class="col-md-3">
            <label class="form-label">File</label>
            <input type="file" name="files[{{ $i }}][file]" class="form-control" accept=".pdf,.pptx,.docx,.xlsx" required>
            @if (is_int($i)) @include('backend.teacher-library.partials.error', ['field' => "files.$i.file"]) @endif
        </div>
        <div class="col-md-2 d-flex align-items-center gap-3">
            <div>
                <input type="checkbox" name="files[{{ $i }}][is_paid]" value="1" id="paid_{{ $i }}" class="filled-in chk-col-primary"
                       @checked(filter_var($row['is_paid'] ?? true, FILTER_VALIDATE_BOOLEAN))>
                <label for="paid_{{ $i }}" class="mb-0" title="Untick to make it free for everyone">Paid</label>
            </div>
            <div>
                <input type="checkbox" name="files[{{ $i }}][is_pro]" value="1" id="pro_{{ $i }}" class="filled-in chk-col-warning"
                       @checked(filter_var($row['is_pro'] ?? false, FILTER_VALIDATE_BOOLEAN))>
                <label for="pro_{{ $i }}" class="mb-0" title="Only Pro plans">Pro</label>
            </div>
            <button type="button" class="remove-upload-row btn btn-sm bg-transparent p-0 ms-auto" title="Remove row">
                <i class="fa fa-times text-danger"></i>
            </button>
        </div>
    </div>
</div>
