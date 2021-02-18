<template>
    <div class="card">
        <div class="card-header">Информация по моточасам/километрам на {{ dateFormated.day }} {{ dateFormated.month }} {{ dateFormated.year }}г.</div>

        <div class="card-body">
         {{ MACHINES }}
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'motor',
    mounted() {
        console.log('Component mounted.')
    },
    data: function () {
        return {
            date: new Date()
        }
    },
    props: {
    },
    computed: {
        ...mapGetters([
           'MACHINES'
        ]),
        dateFormated () {
            var day = this.date.getDate()
            var mnths = ['января', 'февраля', 'марта', 'апреля', 'июля', 'июня', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            var month = mnths[this.date.getMonth()]
            var year = this.date.getFullYear()
            return { day: day, month: month, year: year}
        }
    }
}
</script>
<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
