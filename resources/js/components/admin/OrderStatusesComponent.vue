<template>
    <div class="card">
        <div class="card-header">Статусы заказа
        </div>
        <div class="card-body">
            <table class="w-100">
                <tr>
                    <th class="text-center">Статус</th>
                    <th class="text-center">Действие</th>
                </tr>
                <tr v-for="(status, index) in statuses"
                    :key="index">
                    <td class="text-left"><span>{{ status.status }}</span></td>
                    <td class="text-center"><span class="btn btn-link" @click="editStatus(status.id)">Изменить</span></td>
                </tr>
            </table>
            <div>
                <button type="button"
                        class="btn btn-outline-dark mt-4 w-100"
                        data-toggle="modal"
                        data-target="#new-status-modal"
                        @click=""
                >Добавить поступление
                </button>
            </div>
        </div>
        <new-status-component></new-status-component>
        <edit-status-component></edit-status-component>
    </div>
</template>

<script>

import NewStatusComponent from "./popup/NewStatusComponent";
import EditStatusComponent from "./popup/EditStatusComponent";
export default {
    name: "OrderStatusesComponent",
    components: {EditStatusComponent, NewStatusComponent},
    data () {
        return {
            statuses: []
        }
    },
    methods: {
        getStatuses () {
            axios.get('/api/admin/status',
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.statuses = response.data
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        },
        editStatus(id) {
            alert(id)
        }
    },
    mounted() {
        this.getStatuses()
    }
}
</script>

<style scoped>

</style>
