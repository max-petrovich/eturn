@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('admin.users') }}</div>

                    <div class="panel-body">
                        @if ($users && $users->count())

                            @foreach($users->chunk(2) as $usersChunk)
                                <div class="row" style="margin-bottom: 20px;">
                                    @foreach($usersChunk as $user)
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ $user->photoLink }}" alt="{{ $user->fio }}" class="img-thumbnail">
                                                </div>
                                                <div class="col-md-8">
                                                    <h4><a href="{{ route('profile.edit', $user->id) }}" target="_blank">{{ $user->fio }}</a></h4>
                                                    <div>{{ $user->phone ? trans('admin_users.phone') . ' : ' . $user->phone  : '' }}</div>
                                                    @if (!is_null($user->roles))
                                                        <div>
                                                        @foreach($user->roles as $userRole)
                                                                <span class="badge">{{ $userRole->name }}</span>
                                                        @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                {{ trans('admin_users.users_not_found') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection