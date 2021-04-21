<template>
    <div class="container">
        <month-selector-component></month-selector-component>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <materials-component
                    class="mt-4"
                    :user="user"
                    :date="date"
                    :key="UPDATE"
                ></materials-component>
            </div>
            <div class="col-md-6">
                <production-component
                    class="mt-4"
                    :user="user"
                    :date="date"
                ></production-component>
                <motor-component
                    class="mt-4"
                    :user="user"
                    :date="date"
                ></motor-component>
            </div>
        </div>
    </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "HomeWrapperComponent",
    data: function () {
        return {
            date: new Date().toISOString().slice(0, 10),
        }
    },
    props: {
        user: {
            default: ''
        }
    },
    computed: {
        ...mapGetters([
            `DATE`,
            'UPDATE'
        ]),
    },
    methods: {
        ...mapActions([
            `SET_DATE`,
            'SET_FORMATED_DATE'
        ]),
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
