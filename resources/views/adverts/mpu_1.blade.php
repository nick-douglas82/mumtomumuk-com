@if (App::environment('live'))
<div class="ad__mpu {{ ($last) ? 'ad__mpu--bottom' : '' }}">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
        style="display:block;width:300px;height:250px;"
        data-ad-client="ca-pub-3052712207939946"
        data-ad-slot="{{ $adslot }}"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
@endif
