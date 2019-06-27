@foreach ($events as $date => $activity)

    <div class="content__group">
        <div class="group__title">{{ $date }}</div>

        @foreach ($activity as $record)

            <Userlistingitem slug="{{ $record->subject->slug }}" type="event">
                <a href="{{ url(Request::segment(1)) }}/events/{{ $record->subject->slug }}" slot="header">{{ $record->subject->title }}</a>

                <div class="item__time has-icon">
                    <i class="icon icon--time"></i>
                    {{ $record->subject->event_at->format('D jS F') }} : {{ $record->subject->event_at->format('H:s') }} - {{ $record->subject->event_end->format('H:s') }}
                </div>
            </Userlistingitem>

        @endforeach

    </div>

@endforeach
