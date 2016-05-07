@if ($errors->has())
<div class="container">
    <div class="alert alert-danger">
        <strong>{{ trans('all.system_message') }}</strong>
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif