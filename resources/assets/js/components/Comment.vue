<template>
    <div class="comment__add">
        <h3 class="comments__sub-title">Add a comment</h3>
        <textarea v-model="comment"></textarea>
        <button class="btn btn--primary" @click="store">Add Comment</button>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {

        props: ['slug'],

        data() {
            return {
                comment: '',
            }
        },

        methods: {
            store() {
                axios.post(`${location.origin}/${window.App.site}/comments/${this.path()}/${this.slug}`, {
                    body: this.comment,
                })
                .then(response => {
                    if (response.data.status === 'success') {
                        this.comment = '';

                        flash(`Comment submitted for approval`);
                    }
                });
            },

            path() {
                let path = location.pathname.split('/');
                return path.slice(-2)[0];
            }
        }
    }
</script>
