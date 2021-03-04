<template>
    <div class="card">
        <div class="card-header">Использование техники за {{ dateFormated.day }} {{ dateFormated.month }}
            {{ dateFormated.year }}
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Техника</th>
                    <!--                    <th>Остатки??</th>-->
                    <th>Моточасы / км </th>
                </tr>
                <tr v-for="(machine, index) in MACHINES"
                    :key="index">
                    <td>{{ machine.title }}</td>
                    <!--                    <td>1</td>-->
                    <td>{{ producedOf(machine.id) }} <span v-if="!producedOf(machine.id)">0</span> {{ machine.unit }}
                    </td>
                </tr>
            </table>

        </div>
        <enter-motohour
            v-if="isEnterVisible"
            class="popup"
            :machines="MACHINES"
            :user="user"
            @closePopup="closePopup"
            @sendMotohour="sendMotohour"
        ></enter-motohour>
        <button class="btn btn-outline-dark" @click="showPopup">Внести данные</button>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'MachinesComponent',
    components: {},
    mounted() {
        this.GET_MACHINES()
    },
    data: function () {
        return {
            isEnterVisible: '',
            produced: {}
        }
    },
    props: {
        user: {
            default: ''
        },
        dateFormated: {
            type: Object,
            default: ''
        },
        date: ''

    },
    computed: {
        ...mapGetters([
            'MACHINES',
            'MOTOHOURS'
        ]),
        currentDate() {
            var date = {date: this.date}
            this.GET_MOTOHOURS(date)
            return date
        }
    },
    methods: {
        ...mapActions([
            'GET_MACHINES',
            'GET_MOTOHOURS',
            'ADD_MOTOHOURS'
        ]),
        showPopup() {
            this.isEnterVisible = true
        },
        closePopup() {
            this.isEnterVisible = ''
        },
        sendMotohour(data) {
            this.ADD_MOTOHOURS(JSON.stringify(data))
            console.log(data)
            this.GET_MOTOHOURS(this.currentDate)
            this.closePopup()
        },
        producedOf: function (id) {
            var p = []
            this.currentDate
            for (var mh of this.MOTOHOURS) {
                if (mh.machine_id === id) {
                    return mh.qty
                }
            }
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

td {
    width: 25%;
}
</style>
