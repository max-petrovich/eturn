<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('price', trans('admin_service_user.price') . ' '.trans('all.rub'), ['class' => 'control-label']) !!}
            {!! Form::text('price', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('duration', trans('admin_service_user.duration') . ' '.trans('datetime.min'), ['class' => 'control-label']) !!}
            {!! Form::text('duration', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-md-2" style="padding-top:25px;">
        {!! Form::submit(trans('forms.save'), ['class' => 'btn btn-primary']) !!}
    </div>
</div>