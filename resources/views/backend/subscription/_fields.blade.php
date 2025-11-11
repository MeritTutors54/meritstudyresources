<div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <h4>
                    Price : £{{ number_format($subscription_plan->price) ?? '' }}
                </h4>
            </div>
            <div class="col-md-4">
                <h4>
                    Duration : <span class="badge badge-primary">{{ $subscription_plan->duration_name }}</span>
                </h4>
            </div>
            <div class="col-md-4">
                <h4>
                    Type : <span class="badge badge-primary">{{ $subscription_plan->type_name }}</span>
                </h4>
            </div>
        </div>
        <div class="row" style="margin-top: 2rem">
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Subscription Plan Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $subscription_plan->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter category name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="stripe_price_id"
                           class="form-label">Stripe Price ID</label>
                    <input type="text"
                           name="stripe_price_id"
                           id="stripe_price_id"
                           value="{{ old('stripe_price_id', $subscription_plan->stripe_price_id ?? "") }}"
                           class="form-control"
                           placeholder="Enter stripe price id">
                    @error('stripe_price_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="price"
                           class="form-label">Plan Price</label>
                    <input type="text"
                           name="price"
                           id="price"
                           value="{{ old('price', $subscription_plan->price ?? "") }}"
                           class="form-control"
                           placeholder="Enter price">
                    @error('price')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="duration">Duration</label>
                    <select name="duration"
                            id="duration"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($durations))
                            @foreach($durations as $duration)
                                <option
                                    {{ old('status', isset($subscription_plan) ? (string)$subscription_plan->duration : "1") === (string)$duration->value ? 'selected' : '' }}
                                    value="{{ $duration->value }}">
                                    {{ ucfirst(strtolower($duration->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('duration')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="type">Type</label>
                    <select name="type"
                            id="type"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($types))
                            @foreach($types as $type)
                                <option
                                    {{ old('type', isset($subscription_plan) ? (string)$subscription_plan->type : "1") === (string)$type->value ? 'selected' : '' }}
                                    value="{{ $type->value }}">
                                    {{ ucfirst(strtolower($type->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('type')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="description" class="form-label">Plan Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control"
                              placeholder="Description">{{ old('description', $subscription_plan->description ?? "") }}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="user_limit"
                           class="form-label">User Limit</label>
                    <input type="text"
                           name="user_limit"
                           id="user_limit"
                           value="{{ old('user_limit', $subscription_plan->user_limit ?? "") }}"
                           class="form-control"
                           placeholder="Enter user limit">
                    @error('user_limit')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="download_limit"
                           class="form-label">Download Limit</label>
                    <input type="text"
                           name="download_limit"
                           id="download_limit"
                           value="{{ old('download_limit', $subscription_plan->download_limit ?? "") }}"
                           class="form-control"
                           placeholder="Enter download limit">
                    @error('download_limit')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($statuses))
                            @foreach($statuses as $status)
                                <option
                                    {{ old('status', isset($subscription_plan) ? (string)$subscription_plan->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
