<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('title', trans('forms.name'), ['class' => 'control-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            {!! Form::label('description', trans('forms.description'), ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) !!}
        </div>
    </div>
</div>

<div class="text-center">
    {!! Form::submit(trans('forms.save'), ['class' => 'btn btn-primary']) !!}
</div>