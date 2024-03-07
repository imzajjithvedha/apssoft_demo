@extends('layouts.app')

@section('title', 'Users')

@section('content')

@include('includes.notification')

    <div class="table-container">
        @include('includes.breadcrumb', [
            'page_name' => 'Users',
            'button_title' => 'User',
            'create' => true
        ])

        <form action="{{ route('admin.users.filter') }}" method="POST" class="filter-form">
            @csrf
            <div class="row align-items-center">
                <div class="col-4 position-relative">
                    <input type="text" class="form-control name" name="name" value="{{ $name }}">
                    <label for="name" class="form-label">Name</label>
                </div>

                <div class="col-4 position-relative">
                    <select class="filter-single-dropdown role" name="role" value="{{ $role }}">
                        <option value="all" {{ $role == 'all' ? "selected" : "" }}>Select Role</option>
                        <option value="admin" {{ $role == 'admin' ? "selected" : "" }}>Admin</option>
                        <option value="user" {{ $role == 'user' ? "selected" : "" }}>User</option>
                    </select>
                </div>

                <div class="col-4 d-flex justify-content-between">
                    <input type="submit" class="btn filter-search-button" value="SEARCH">

                    <input type="submit" class="btn filter-reset-button" name="reset" value="RESET">
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create -->
        <div class="modal fade create-modal" id="create-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Add User</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                                    <input class="form-control first_name" type="text" name="first_name" value="{{ old('first_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                                    <input class="form-control last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email<span class="asterisk">*</span></label>
                                    <input class="form-control email" type="email" name="email" value="{{ old('email') }}" required>
                                    @include('includes.input_error', ['field' => 'email'])
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Role<span class="asterisk">*</span></label>
                                    <select class="form-control form-select role" name="role" value="{{ old('role') }}" required>
                                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Password<span class="asterisk">*</span></label>
                                    <input class="form-control password" type="password" name="password" required>
                                    @include('includes.input_error', ['field' => 'password'])
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Confirm Password<span class="asterisk">*</span></label>
                                    <input class="form-control password_confirmation" type="password" name="password_confirmation" required>
                                    @include('includes.input_error', ['field' => 'password_confirmation'])
                                </div>

                                @include('includes.create_data')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit -->
        <div class="modal fade edit-modal" id="edit-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title">Edit User</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">First Name<span class="asterisk">*</span></label>
                                    <input class="form-control first_name" type="text" name="first_name" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Last Name<span class="asterisk">*</span></label>
                                    <input class="form-control last_name" type="text" name="last_name" required>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Email<span class="asterisk">*</span></label>
                                    <input class="form-control email" type="email" name="email" required>
                                    @include('includes.input_error', ['field' => 'email'])
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Role<span class="asterisk">*</span></label>
                                    <select class="form-control form-select role" name="role" value="{{ old('role') }}" required>
                                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control password" type="password" name="password">
                                    @include('includes.input_error', ['field' => 'password'])
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control password_confirmation" type="password" name="password_confirmation">
                                    @include('includes.input_error', ['field' => 'password_confirmation'])
                                </div>

                                @include('includes.create_data')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete -->
        <div class="modal fade delete-modal" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                    </div>
                    <div class="modal-body">
                        <p class="modal-message">Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn form-btn close-btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                        <a class="btn form-btn confirm_delete" title="Delete">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                    data: function (d) {
                        d.length = d.length || 10;
                        d.page = d.start / d.length + 1;
                    },
                    dataSrc: function (response) {
                        const transformed_data = Object.values(response.data);
                        return transformed_data;
                    }
                },
                columns: [
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "role"},
                    {"data": "status"},
                    {"data": "action"},
                ],
                "drawCallback": function(settings) {
                    $('.table-container .delete').on('click', function() {
                        let id = $(this).attr('id');
                        let url = "{{ route('admin.users.delete', [':id']) }}";
                        url = url.replace(':id', id);
                        deleteRow(url);
                    });

                    $('.table-container .edit').on('click', function() {
                        let value = $(this).attr('id');
                        let edit_url = '{{ route("admin.users.edit", ":value") }}';
                        let update_url = '{{ route("admin.users.update", ":value") }}';
                        edit_url = edit_url.replace(':value', value);
                        update_url = update_url.replace(':value', value);

                        $('.edit-modal').modal('show');
                        $('.edit-modal form').attr('action', update_url);
                        $('.edit-modal form')[0].reset();

                        $.ajax({
                            url: edit_url,
                            method: 'GET',
                            success: function(data) {
                                $('.edit-modal .first_name').val(data['first_name']);
                                $('.edit-modal .last_name').val(data['last_name']);
                                $('.edit-modal .email').val(data['email']);
                                $('.edit-modal .role').val(data['role']);
                                $('.edit-modal .status').val(data['status']);
                            },
                            error: function() {
                                alert('Error getting data!');
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush