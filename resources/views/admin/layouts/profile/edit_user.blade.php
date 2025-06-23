@extends('admin.layouts.app')
@section('title', 'Edit User')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
@endpush

@section('admin_content')
    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-5 col-md-5 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4 style="display: inline-block"> Edit User</h4>
                    </div>
                    <div class="body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="form-group mb-4">
                                <label><b>Name</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">person</i></span>
                                    <div class="form-line" style="border: 1px solid #ccc">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $user->name) }}">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-4">
                                <label><b>Email</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">email</i></span>
                                    <div class="form-line" style="border: 1px solid #ccc">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group mb-4">
                                <label><b>Phone</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">phone</i></span>
                                    <div class="form-line" style="border: 1px solid #ccc">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="form-group mb-4">
                                <label><b>New Password</b> <small>(Leave blank if not changing)</small></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">lock</i></span>
                                    <div class="form-line" style="border: 1px solid #ccc">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter New Password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-4">
                                <label><b>Confirm New Password</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">lock</i></span>
                                    <div class="form-line" style="border: 1px solid #ccc">
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm New Password">
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Role -->
                            {{-- <div class="form-group mb-4">
                                <label><b>Role*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <select name="system_admin" class="form-control show-tick">
                                            <option disabled>Select Role</option>
                                            <option value="Admin" {{ $user->system_admin == 'Admin' ? 'selected' : '' }}>
                                                Admin</option>
                                            <option value="User" {{ $user->system_admin == 'User' ? 'selected' : '' }}>
                                                User</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}

                            <button type="submit"
                                class="btn btn-raised btn-warning text-white m-t-15 waves-effect right mb-3"
                                style="font-weight: 500">UPDATE</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
