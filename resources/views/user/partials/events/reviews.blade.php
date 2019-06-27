@foreach ($events as $date => $activity)

    <div class="content__group">
        <div class="group__title">{{ $date }}</div>

        @foreach ($activity as $record)

            <Userreview :attributes="{{ $record }}" inline-template v-cloak>
                <div class="group__item">
                    <div class="item__title">
                        <a href="{{ url(Request::segment(1)) }}/events/{{ $record->subject->slug }}">{{ $record->subject->title }}</a>
                        <div class="item__time has-icon">
                            Reviewed {{ $record->created_at->format('d F Y') }}
                        </div>
                        <div class="item__content">
                            <div v-if="editing">
                                <textarea name="body" v-model="body"></textarea>
                                <button @click="update">Update</button>
                                <button @click="editing = false">Cancel</button>
                            </div>
                            <div v-else v-html="compiledMarkdown"></div>
                        </div>
                    </div>
                    <ul class="action__list">
                        <li class="action__item"><a href="#" @click.prevent="editing = true" v-if="!editing">Edit</a></li>
                        <li class="action__item" v-if="!editing"> || </li>
                        <li class="action__item"><a href="#">Remove <span>&times;</span></a></li>
                    </ul>
                </div>
            </Userreview>

        @endforeach

    </div>

@endforeach
