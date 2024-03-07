@extends('layouts.app')

@section('title', 'Profile')

@section('content')

@include('includes.notification')
    
    <div class="table-container">

        @include('includes.breadcrumb', [
            'page_name' => 'Profile'
        ])

        <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" class="static-form">
            @csrf
            <div class="row">
                <div class="col-4 mb-3">
                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                    <input class="form-control first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                    <input class="form-control last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Email<span class="asterisk">*</span></label>
                    <input class="form-control email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @include('includes.input_error', ['field' => 'email'])
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Old Password</label>
                    <input class="form-control old_password" type="password" name="old_password">
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control new_password" type="password" name="new_password" onChange="onChange()">
                </div>  

                <div class="col-4 mb-5">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control confirm_password" type="password" name="confirm_password" onChange="onChange()">
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn form-btn" onclick="updateForm()">Update</button>
                </div>
            </div>
        </form>
    </div>

@endsection


@push('after-scripts')
    <script>
        $('.old_password').on('change', function() {
            if($(this).val() != '') {
                $('.new_password').attr('required', true);
                $('.confirm_password').attr('required', true);
            }
            else {
                $('.new_password').removeAttr('required');
                $('.confirm_password').removeAttr('required');
            }
        });
    </script>

    <script>
        function onChange() {
            const password = document.querySelector('input[name=new_password]');
            const confirm = document.querySelector('input[name=confirm_password]');

            if(confirm.value != '' || password.value != '') {
                $('.old_password').attr('required', true);

                if(confirm.value === password.value) {
                    confirm.setCustomValidity('');
                }
                else {
                    confirm.setCustomValidity('Passwords do not match');
                }
            }
            else {
                $('.old_password').removeAttr('required');
                confirm.setCustomValidity('');
            }
        }
    </script>
@endpush