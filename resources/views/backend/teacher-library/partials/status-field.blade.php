{{-- @include('backend.teacher-library.partials.status-field', ['value' => $model->status ?? 1]) --}}
<div class="form-group">
    <label class="form-label" for="status">Status</label>
    <select name="status" id="status" class="form-select">
        <option value="1" @selected((string) old('status', $value ?? 1) === '1')>Active</option>
        <option value="0" @selected((string) old('status', $value ?? 1) === '0')>Inactive</option>
    </select>
    @include('backend.teacher-library.partials.error', ['field' => 'status'])
</div>
