<template>
    <div class="container">
        <div class="row justify-content-between w-100">
            <month-selector-component class="w-25"></month-selector-component>
            <delivery-calculator-component class="w-25"/>
        </div>
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
                    :key="UPDATE"
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
