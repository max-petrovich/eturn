<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('title', trans('forms.name'), ['class' => 'control-label']) !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="text-center">
    {!! Form::submit(trans('forms.save'), ['class' => 'btn btn-primary']) !!}
</div>