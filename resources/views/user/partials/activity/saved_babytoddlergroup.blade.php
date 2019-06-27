@component('user.partials.activity.feed-item')
    @slot('heading')
        {{ $activity->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        You added <a href="/{{ Request::segment(1) }}/baby-toddler-groups/{{ $activity->subject->slug }}">{{ $activity->subject->title }}</a> to my Baby &amp; Toddler Groups
    @endslot
@endcomponent
