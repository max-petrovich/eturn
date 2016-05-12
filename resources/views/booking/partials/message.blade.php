@if (session('message'))
    <div class="container">
        <div class="alert alert-success" style="padding:20px;">
            {{ session('message') }}
        </div>
    </div>
@endif