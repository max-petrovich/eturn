@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('user.edit_profile') }}</div>
                    {{ Form::model($user, ['method' => 'PUT', 'route' => ['profile.update', $user->id], 'files' => true]) }}
                    <div class="panel-body">

                        <h3>{{ trans('user.personal_information') }}</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('photo', trans('user.photo'), ['class' => 'control-label']) !!}
                                    <div><img src="{{ $user->photoLink }}" class="img-thumbnail"></div><br/>
                                    {!! Form::file('photo') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('fio', trans('user.fio'), ['class' => 'control-label']) !!}
                                    {!! Form::text('fio', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', trans('user.email'), ['class' => 'control-label']) !!}
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone', trans('user.phone'), ['class' => 'control-label']) !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('password', trans('user.password'), ['class' => 'control-label']) !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->is(['admin', 'master']) && $user->isMaster())
                            <h3>{{ trans('user.master_information') }}</h3>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('data[minimum_service_duration]', trans('user.minimum_service_duration'), ['class' => 'control-label']) !!}
                                        {!! Form::select('data[minimum_service_duration]', array_combine($minimum_serivce_durations, $minimum_serivce_durations), null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="panel-footer text-center">
                        {!! Form::submit(trans('user.save'), ['class' => 'btn btn-primary']) !!}
                    </div>
                    {{ Form::close() }}
                    @if(Auth::user()->is(['admin']))
                        @if($user->isClient())
                            <div class="panel-footer text-center">
                                {{ Form::open(['route' => ['profile.makeMasters', $user->id],'method' => 'PUT']) }}
                                {{ Form::submit(trans('user.make_master'), ['class' => 'btn btn-danger']) }}
                                {{ Form::close() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection