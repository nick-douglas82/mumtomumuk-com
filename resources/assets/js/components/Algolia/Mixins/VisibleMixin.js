export default {
    data() {
        return {
            isVisible: false
        }
    },

    methods: {
        toggleVisibility() {
            this.isVisible = (this.isVisible) ? false : true;
        }
    }
}
