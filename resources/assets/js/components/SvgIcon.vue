<template>
    <img :src="`./../../images/svg/${icon}.svg`" :title="title" :alt="title">
</template>

<script>
export default {
    props: ['icon', 'title']
}
</script>
