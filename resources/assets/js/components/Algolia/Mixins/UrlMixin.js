export default {
    methods: {
        postUrl(type, slug) {
            return `${location.href}/${type}/${slug}`;
        }
    }
}
