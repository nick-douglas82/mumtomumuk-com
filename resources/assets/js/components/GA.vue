<template></template>

<script>
    export default {
        mounted() {
            this.$ga.page({
                page: window.location.pathname,
                title: document.title,
                location: window.location.href
            })
        }
    }
</script>
