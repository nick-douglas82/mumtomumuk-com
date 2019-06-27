@foreach ($events as $date => $activity)

    <div class="content__group">
        <div class="group__title">{{ $date }}</div>

        @foreach ($activity as $record)

            <Userlistingitem slug="{{ $record->subject->slug }}" type="places">
                <a href="{{ url(Request::segment(1)) }}/places/{{ $record->subject->slug }}" slot="header">{{ $record->subject->title }}</a>

                <div>{{ $record->subject->town }}</div>
            </Userlistingitem>

        @endforeach

    </div>

@endforeach
