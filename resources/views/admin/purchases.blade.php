@extends('layouts.app')

@section('title', 'Purchases')

@section('content')

@include('includes.notification')

    <div class="table-container">
        @include('includes.breadcrumb', [
            'page_name' => 'Purchases',
            'button_title' => 'Purchase',
            'create' => true
        ])

        <form action="{{ route('admin.purchases.filter') }}" method="POST" class="filter-form">
            @csrf
            <div class="row align-items-center">
                <div class="col-4 position-relative">
                    <input type="text" class="form-control datepicker start_date" name="start_date" value="{{ $start_date }}" readonly>
                    <label for="name" class="form-label">Start Date</label>
                </div>

                <div class="col-4 position-relative">
                    <input type="text" class="form-control datepicker end_date" name="end_date" value="{{ $end_date }}" readonly>
                    <label for="name" class="form-label">End Date</label>
                </div>

                <div class="col-4 d-flex justify-content-between">
                    <input type="submit" class="btn filter-search-button" value="SEARCH">

                    <input type="submit" class="btn filter-reset-button" name="reset" value="RESET">

                    <input type="submit" class="btn filter-download-button" name="download" value="DOWNLOAD">
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
                                    <th scope="col">Product</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Amount</th>
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
                        <h1 class="modal-title">Add Purchase</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.purchases.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Product<span class="asterisk">*</span></label>
                                    <select class="form-control form-select product" name="product" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Date<span class="asterisk">*</span></label>
                                    <input class="form-control datepicker date" type="date" name="date" readonly required>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Quantity<span class="asterisk">*</span></label>
                                    <input class="form-control quantity" type="text" name="quantity" required>
                                </div>

                                <div class="col-12 mb-5">
                                    <label class="form-label">Amount<span class="asterisk">*</span></label>
                                    <input class="form-control amount" type="text" name="amount" required>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn form-btn" onclick="submitForm()">Submit</button>
                                </div>

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
                        <h1 class="modal-title">Edit Purchase</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Product<span class="asterisk">*</span></label>
                                    <select class="form-control form-select product" name="product" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Date<span class="asterisk">*</span></label>
                                    <input class="form-control datepicker date" type="date" name="date" readonly required>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Quantity<span class="asterisk">*</span></label>
                                    <input class="form-control quantity" type="text" name="quantity" required>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Amount<span class="asterisk">*</span></label>
                                    <input class="form-control amount" type="text" name="amount" required>
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
                        <h5 class="modal-title">Delete Purchase</h5>
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
                    url: "{{ route('admin.purchases.index') }}",
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
                    {"data": "product"},
                    {"data": "date"},
                    {"data": "quantity"},
                    {"data": "amount"},
                    {"data": "status"},
                    {"data": "action"}
                ],
                "drawCallback": function() {
                    $('.table-container .delete').on('click', function() {
                        let id = $(this).attr('id');
                        let url = "{{ route('admin.purchases.delete', [':id']) }}";
                        url = url.replace(':id', id);
                        deleteRow(url);
                    });

                    $('.table-container .edit').on('click', function() {
                        let value = $(this).attr('id');
                        let edit_url = '{{ route("admin.purchases.edit", ":value") }}';
                        let update_url = '{{ route("admin.purchases.update", ":value") }}';
                        edit_url = edit_url.replace(':value', value);
                        update_url = update_url.replace(':value', value);

                        $('.edit-modal').modal('show');
                        $('.edit-modal form').attr('action', update_url);
                        $('.edit-modal form')[0].reset();

                        $.ajax({
                            url: edit_url,
                            method: 'GET',
                            success: function(data) {
                                $('.edit-modal .product').val(data['product']);
                                $('.edit-modal .date').val(data['date']);
                                $('.edit-modal .quantity').val(data['quantity']);
                                $('.edit-modal .amount').val(data['amount']);
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
