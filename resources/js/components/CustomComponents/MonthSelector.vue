<template>
    <div class="btn-group mr-2" role="group" aria-label="Second group">
        <button type="button" class="btn btn-link text-secondary"
                @click="decreaseMonth"
                :disabled="!IS_READY"
        > <
        </button>
        <button type="button" class="btn btn-link text-secondary month-name"
                @click="resetMonth"
                :disabled="!IS_READY"
        >{{ dateFormated.ofMonth }}
        </button>
        <button type="button" class="btn btn-link text-secondary"
                @click="increaseMonth"
                :disabled="!IS_READY"
        > >
        </button>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "MonthSelector",
    data: function () {
        return {
            date: new Date().toISOString().slice(0, 10),
        }
    },
    computed: {
        ...mapGetters([
            `DATE`,
            'IS_READY'
        ]),
        dateFormated() {
            const dateSplit = this.DATE.split('-')
            const day = dateSplit[2]
            const mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            const ofMnths = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь']
            const month = mnths[parseInt(dateSplit[1]) - 1]
            const ofMonth = ofMnths[parseInt(dateSplit[1]) - 1]
            const year = dateSplit[0]
            return {day: day, month: month, ofMonth: ofMonth, year: year}
        }
    },
    methods: {
        ...mapActions([
            `SET_DATE`,
            'SET_FORMATED_DATE'
        ]),
        setDate(date) {
            this.SET_DATE(date)
            this.SET_FORMATED_DATE(this.dateFormated)
        },
        decreaseMonth() {
            let currentDate = new Date(Date.parse(this.DATE))
            currentDate.setDate(1);
            currentDate.setMonth(currentDate.getMonth() - 1);
            this.localDate = currentDate.toISOString().slice(0, 10)
            this.setDate(currentDate.toISOString().slice(0, 10))
            // console.log(currentDate.toISOString().slice(0, 10))
        },
        increaseMonth() {
            let currentDate = new Date(Date.parse(this.DATE))
            currentDate.setDate(1);
            currentDate.setMonth(currentDate.getMonth() + 1);
            this.localDate = currentDate.toISOString().slice(0, 10)
            this.setDate(currentDate.toISOString().slice(0, 10))
            // console.log(currentDate.toISOString().slice(0, 10))
        },
        resetMonth() {
            this.localDate = new Date().toISOString().slice(0, 10)
            this.setDate(this.localDate)
        },
    },
    mounted() {
        this.SET_DATE(this.date)
        this.SET_FORMATED_DATE(this.dateFormated)
    }
}
</script>

<style scoped>

.btn-link {
    text-decoration: none !important;
    font-weight: bold;
}
.month-name {
    width: 100px!important;
}
</style>
