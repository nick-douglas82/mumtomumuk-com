@if (isset($adverts['mpu'][0]) && !empty($adverts['mpu'][0]))
    @include('adverts.mpu_0', ['adslot' => $adverts['mpu'][0]['adsense_id'], 'last' => false])
@else
    @include('adverts.mpu_0', ['adslot' => '9328726462', 'last' => false])
@endif

@if (isset($adverts['mpu'][1]) && !empty($adverts['mpu'][1]))
    @include('adverts.mpu_1', ['adslot' => $adverts['mpu'][1]['adsense_id'], 'last' => true])
@else
    @include('adverts.mpu_1', ['adslot' => '5470152757', 'last' => true])
@endif