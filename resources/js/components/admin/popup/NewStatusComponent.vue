<template>
    <div class="modal fade" id="new-status-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Новый статус</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Новый статус:</label>
                    <div v-if="message.status" class="alert alert-danger">
                        <div v-for="(error, index) in message.status"
                             :key="index"
                        >{{ error }}
                        </div>
                    </div>
                    <input :class="statusColor" v-model="statusName" class="form-control">
                    <div>Цвет:</div>
                    <select class="form-control" name="color" id="color" v-model="statusColor">
                        <option v-for="(color, index) in colors"
                                :key="index"
                                :class="color"
                                :value="color"
                        ></option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-primary"
                            @click="sendNewStatus"
                            :disabled="!statusName"
                    >
                        Сохранить
                    </button>
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                    >
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "NewStatusComponent",
    data() {
        return {
            statusName: '',
            statusColor: '',
            message: '',
            colors: ['alert alert-primary', 'alert alert-secondary', 'alert alert-success', 'alert alert-danger', 'alert alert-warning', 'alert alert-info', 'alert alert-light', 'alert alert-dark']
        }
    },
    methods: {
        ...mapActions([
            'UPDATE_KEY'
        ]),
        sendNewStatus() {
            let data = {status: this.statusName, color: this.statusColor}
            axios.post('/api/admin/status',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    $('#new-status-modal').modal('hide')
                    this.statusName = ''
                    this.UPDATE_KEY()
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data.errors
                })
        }
    }
}
</script>

<style scoped>

</style>
