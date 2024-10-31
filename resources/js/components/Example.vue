<script>
export default {
    render() {
        return this.$scopedSlots.default({
            someData: this.someData,
            someMethod: this.someMethod,
            someComputed: this.someComputed,
        })
    },

    props: {
        someProp: {
            type: String,
        }
    },

    data: () => {
        return {
            someData: '',
        }
    },

    methods: {
        someMethod(param) {
            //
        },
    },

    computed: {
        someComputed: function () {
            return this.someProp;
        }
    }
}
</script>
