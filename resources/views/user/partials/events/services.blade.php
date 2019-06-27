@foreach ($events as $date => $activity)

    <div class="content__group">
        <div class="group__title">{{ $date }}</div>

        @foreach ($activity as $record)

            <Userlistingitem slug="{{ $record->subject->slug }}" type="directory">
                <a href="{{ url(Request::segment(1)) }}/directory/{{ $record->subject->slug }}">{{ $record->subject->title }}</a>

                <div class="item__time has-icon">
                    <i class="icon icon--phone"></i>
                    {{ $record->subject->phone }}
                </div>
                <a href="{{ $record->subject->website }}">{{ $record->subject->website }}</a>
            </Userlistingitem>

        @endforeach

    </div>

@endforeach
