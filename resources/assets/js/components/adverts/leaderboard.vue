<template>
    <div :class="rootClass">
        <script2 type="text/javascript" async :src="ADS_SCRIPT"></script2>
        <ins class="adsbygoogle"
             style="display:block"
             :data-ad-client="dataAdClient"
             :data-ad-slot="dataAdSlot"
             data-ad-format="auto"></ins>

        <script2>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script2>
    </div>
</template>

<script>
    import mixin from './mixins/mixins'

    export default {
        mixins: [ mixin ]
    }
</script>
