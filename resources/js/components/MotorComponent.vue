<template>
    <div class="card">
        <div class="card-header">Использование техники за {{ dateFormated.day }} {{ dateFormated.month }}
            {{ dateFormated.year }}
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Техника</th>
                    <th>Моточасы / км</th>
                </tr>
                <tr v-for="(machine, index) in MACHINES"
                    :key="index">
                    <td>{{ machine.title }}</td>
                    <!--                    <td>1</td>-->
                    <td>{{ machine.monthUsage }} {{ machine.unit }}
                    </td>
                </tr>
            </table>
            <component-loader v-if="isLoading"></component-loader>
        </div>
        <enter-motohour
            v-if="isEnterVisible"
            class="popup"
            :machines="MACHINES"
            :user="user"
            @closePopup="closePopup"
            @sendMotohour="sendMotohour"
        ></enter-motohour>
        <button type="button"
                class="btn btn-outline-primary"
                data-toggle="modal"
                data-target="#staticBackdrop"
                @click="showPopup">Ввод данных</button>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'MachinesComponent',
    components: {},
    mounted() {
        this.GET_MACHINES(this.currentDate).then(res => {
            this.isLoading = false
        })
    },
    data: function () {
        return {
            isEnterVisible: '',
            produced: {},
            isLoading: true,
        }
    },
    props: {
        user: {
            default: {}
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
        ]),
        currentDate() {
            var date = {date: this.date}
            this.GET_MACHINES(date)
            return date
        }
    },
    methods: {
        ...mapActions([
            'GET_MACHINES',
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
            this.GET_MACHINES(this.currentDate)
            this.closePopup()
        },
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
