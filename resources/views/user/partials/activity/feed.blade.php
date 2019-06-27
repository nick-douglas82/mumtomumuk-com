@if ($userActivity->count() > 0)
    <ul class="activity-feed__list">
        @foreach ($userActivity as $activity)
            @include ("user.partials.activity.{$activity->type}")
            @if(!$loop->last)
                <li class="activity-feed__item activity-feed__item--spacer"></li>
            @endif
        @endforeach
    </ul>
@else
    <div class="feed__empty">
        <p>There is no activity yet...</p>
        <p>Visit the <a href="{{ url(Request::segment(1)) }}"> site</a> to see if anything takes your fancy!</p>
    </div>
@endif
