export default {
    filters: {
        lowercase(value) {
            if (!value) return '';
            value = value.toString();

            return value.toLowerCase();
        }
    }
}
