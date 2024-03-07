<div class="table-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="table-title"><i class="{{ $icon }}"></i>{{ $title }}</h6>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="table" style="width:100%">
                        <thead>
                            <tr>
                                @foreach($table_headers as $header)
                                    <th scope="col">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>