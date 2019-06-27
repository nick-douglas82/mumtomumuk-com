@component('user.partials.activity.feed-item')
    @slot('heading')
        {{ $activity->created_at->diffForHumans() }}
    @endslot

    @slot('body')
    You wrote a review on
    @if ($activity->subject->subject_type == 'App\Directory')
        <a href="/{{ Request::segment(1) }}/directory/{{ $activity->subject->subject->slug }}">
    @elseif ($activity->subject->subject_type == 'App\Place')
        <a href="/{{ Request::segment(1) }}/places/{{ $activity->subject->subject->slug }}">
    @elseif ($activity->subject->subject_type == 'App\AfterSchoolClub')
        <a href="/{{ Request::segment(1) }}/after-school-clubs/{{ $activity->subject->subject->slug }}">
    @elseif ($activity->subject->subject_type == 'App\BabyToddlerGroup')
        <a href="/{{ Request::segment(1) }}/baby-toddler-groups/{{ $activity->subject->subject->slug }}">
    @endif
        {{ $activity->subject->subject->title }}</a>
    @endslot
@endcomponent
