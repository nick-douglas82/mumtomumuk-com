<script>
    import marked from 'marked';

    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body
            }
        },

        computed: {
            compiledMarkdown: function () {
                return marked(this.body, { sanitize: true })
            }
        },

        methods: {
            update() {
                axios.patch(`/${window.App.site}/users/reviews/${this.type()}/${this.attributes.id}`, {
                    body: this.body
                });

                this.editing = false;
            },

            type() {
                return this.attributes.reviewable_type.replace("App\\", "").toLowerCase();
            }
        }
    }
</script>
