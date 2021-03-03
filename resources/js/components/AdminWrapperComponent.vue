<template>
    <div class="container">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control"></div>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <admin-production-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></admin-production-component>
            </div>
        </div>
    </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
export default {
    name: "AdminWrapperComponent",
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
           var dateSplit = this.date.split('-')
            var day = dateSplit[2]
            var mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            var month = mnths[parseInt(dateSplit[1])-1]
            var year = dateSplit[0]
            return {day: day, month: month, year: year}
        }
    }
}
</script>

<style scoped>

</style>
