<div class="row page-details align-items-center justify-content-between">
    <div class="col-8">
        @if($page_name == 'Dashboard')
            <h3 class="page-title">Welcome {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}!</h3>
        @else
            <h3 class="page-title">{{ $page_name }}</h3>
        @endif

        <ul class="breadcrumb">
            @if($page_name == 'Dashboard')
                <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
            @else
                <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item">{{ $page_name }}</li>
            @endif
        </ul>
    </div>

    @isset($create)
        <div class="col-4 text-end">
            <button type="button" class="add-button" data-bs-toggle="modal" data-bs-target="#create-modal"><span>+</span>Add {{ $button_title }}</button>
        </div>
    @endisset
</div>