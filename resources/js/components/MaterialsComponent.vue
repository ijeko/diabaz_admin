<template>
    <div class="card">
        <div class="card-header">Данные по материалам на {{ dateFormated.day }} {{ dateFormated.month }} {{ dateFormated.year }}г.</div>

        <div class="card-body">
            <div class="materials"
                 v-for="(material, index) in MATERIALS"
                 :key="index">
                <div class="material-name">
                    <div>{{ material.title }}
                    </div>
                </div>
                <div class="material-qty">{{ material.qty }} {{ material.unit }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'MaterialsComponent',
    mounted() {
        console.log('Component mounted.')
        this.GET_MATERIALS()

    },
    data: function () {
        return {
            date: new Date()
        }
    },
    props: {
        materials: {
            type: Array,
            default: {}
        }
    },
    computed: {
        ...mapGetters([
            'MATERIALS'
        ]),
        dateFormated () {
            var day = this.date.getDate()
            var mnths = ['января', 'февраля', 'марта', 'апреля', 'июля', 'июня', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            var month = mnths[this.date.getMonth()]
            var year = this.date.getFullYear()
            return { day: day, month: month, year: year}
        }
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ])
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
