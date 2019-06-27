@foreach ($events as $date => $activity)

    <div class="content__group">
        <div class="group__title">{{ $date }}</div>

        @foreach ($activity as $record)

            <Userlistingitem slug="{{ $record->subject->slug }}" type="4-plus-activites">
                <a href="{{ url(Request::segment(1)) }}/4-plus-activites/{{ $record->subject->slug }}" slot="header">{{ $record->subject->title }}</a>

                @if ($record->subject->event_times)
                    <div class="item__time has-icon">
                        <i class="icon icon--time"></i>
                        {{ $record->subject->event_times }}
                    </div>
                @endif
            </Userlistingitem>

        @endforeach

    </div>

@endforeach
