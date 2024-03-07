@extends('layouts.app')

@section('title', 'Brands')

@section('content')

@include('includes.notification')

    <div class="table-container">
        @include('includes.breadcrumb', [
            'page_name' => 'Brands',
            'button_title' => 'Brand',
            'create' => true
        ])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
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
                        <h1 class="modal-title">Add Brand</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.brands.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" required>
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
                        <h1 class="modal-title">Edit Brand</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name<span class="asterisk">*</span></label>
                                    <input class="form-control name" type="text" name="name" required>
                                </div>

                                @include('includes.edit_data')
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
                        <h5 class="modal-title">Delete Brand</h5>
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
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.brands.index') }}",
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
                    {"data": "status"},
                    {"data": "action"}
                ],
                "drawCallback": function() {
                    $('.table-container .delete').on('click', function() {
                        let id = $(this).attr('id');
                        let url = "{{ route('admin.brands.delete', [':id']) }}";
                        url = url.replace(':id', id);
                        deleteRow(url);
                    });

                    $('.table-container .edit').on('click', function() {
                        let value = $(this).attr('id');
                        let edit_url = '{{ route("admin.brands.edit", ":value") }}';
                        let update_url = '{{ route("admin.brands.update", ":value") }}';
                        edit_url = edit_url.replace(':value', value);
                        update_url = update_url.replace(':value', value);

                        $('.edit-modal').modal('show');
                        $('.edit-modal form').attr('action', update_url);
                        $('.edit-modal form')[0].reset();

                        $.ajax({
                            url: edit_url,
                            method: 'GET',
                            success: function(data) {
                                $('.edit-modal .name').val(data['name']);
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
