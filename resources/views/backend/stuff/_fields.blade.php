<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $stuff->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter stuff name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="username"
                           class="form-label">Username</label>
                    <input type="text"
                           name="username"
                           id="username"
                           value="{{ old('username', $stuff->username ?? "") }}"
                           class="form-control"
                           placeholder="Enter username">
                    @error('username')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="email"
                           class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $stuff->email ?? "") }}"
                           class="form-control"
                           placeholder="Enter stuff email">
                    @error('email')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="password"
                           class="form-label">Password</label>
                    <input type="text"
                           name="password"
                           id="password"
                           value="{{ old('password') }}"
                           class="form-control"
                           placeholder="Enter password">
                    @error('password')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            @php
                $getRole = !empty($stuff) ? $stuff->getRoleNames()->first() : '';
            @endphp

            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="role">Role</label>
                    <select name="role"
                            id="role"
                            class="form-select">
                        <option value="">Select...</option>

                        @if(!empty($roles))
                            @foreach($roles as $role)
                                @if($role->name != 'super-admin' || auth()->user()->hasRole('super-admin'))
                                    <option
                                        {{ old('role', isset($stuff) ? (string)$getRole : "") === (string)$role->name ? 'selected' : '' }}
                                        value="{{ $role->name }}">
                                        {{ ucfirst(strtolower($role->name))  }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @error('role')
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
                                    {{ old('status', isset($stuff) ? (string)$stuff->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.stuffs.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
