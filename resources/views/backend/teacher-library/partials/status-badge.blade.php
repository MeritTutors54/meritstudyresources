@if ((int) $status === \App\Enums\Status::ACTIVE->value)
    <span class="badge badge-success">Active</span>
@else
    <span class="badge badge-secondary">Inactive</span>
@endif
