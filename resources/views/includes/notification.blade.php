@if(session('success'))
    <div class="notification-box">
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="notification-box">
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        </div>
    </div>
@endif