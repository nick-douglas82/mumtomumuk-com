<div class="review__wrap">
    <ul class="review">
        @for ($i = 0; $i < 5; $i++)
            @if ($i != $rating && $i <= $rating)
                <li class="review__item">
                    <span class="review__star review__star--full"></span>
                </li>
            @else
                <li class="review__item">
                    <span class="review__star review__star--empty"></span>
                </li>
            @endif
        @endfor
    </ul>

</div>
