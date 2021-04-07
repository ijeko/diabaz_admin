<template>
    <div class="container">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control"></div>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <materials-component
                    class="mt-4"
                :user="user"
                :dateFormated="dateFormated"
                :date="date"
                ></materials-component>
            </div>
            <div class="col-md-6">
                <production-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></production-component>
                <motor-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></motor-component>
            </div>
        </div>
    </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
export default {
    name: "HomeWrapperComponent",
    data: function () {
        return {
            date: new Date().toISOString().slice(0,10)
        }
    },
    props: {
        user: {
            default: ''
        }

    },
    computed: {
        dateFormated() {
            const dateSplit = this.date.split('-')
            const day = dateSplit[2]
            const mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            const ofMnths = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь']
            const month = mnths[parseInt(dateSplit[1]) - 1]
            const ofMonth = ofMnths[parseInt(dateSplit[1]) - 1]
            const year = dateSplit[0]
            return {day: day, month: month, ofMonth: ofMonth, year: year}
        }
    }
}
</script>

<style scoped>

</style>
