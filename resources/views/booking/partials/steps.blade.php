<div class="container">
    <ul class="progressbar bookingStepsProgress clearfix">
        @foreach($steps as $stepName=>$step)
            @if (Request::route()->hasParameter($stepName))
                <li class="active{{ $step['active'] ? '' : ' step_disabled' }}">
                    @if ($step['active'])
                    <a href="{{ route($step['route'], array_slice(array_values(Route::current()->parameters()), 0, $step['step']-1)) }}">{{ $step['title'] }}</a></li>
                    @else
                    {{ $step['title'] }}
                    @endif
            @else
                <li>{{ $step['title'] }}</li>
            @endif
        @endforeach
    </ul>
</div>