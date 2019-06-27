@component('user.partials.activity.feed-item')
    @slot('heading')
        {{ $activity->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        You added <a href="/{{ Request::segment(1) }}/4-plus-activites/{{ $activity->subject->slug }}">{{ $activity->subject->title }}</a> to my 4+ Activities
    @endslot
@endcomponent
