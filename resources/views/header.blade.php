<div class="flex-center position-ref full-height">
    @if ($active != 0)
        <div class="top-right links">
            <a href="/">Home</a>
            <a href="{{ route('parse.index') }}">Parser</a>
            <a href="{{ route('deals.index') }}">Deals</a>
            <a href="{{ route('activities.index') }}">Activities</a>
        </div>
    @endif
