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
                    <label>Новый статус</label>
                    <input v-model="statusName" class="form-control">
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
export default {
    name: "EditStatusComponent",
    data() {
        return {
            newStatusName: this.statusName,
            message: ''
        }
    },
    props: {
      status_id: '',
      statusName: ''
    },
    methods: {
        deleteStatus() {

            axios.delete('/api/admin/status',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: this.status_id
                })
                .then(response => {
                    $('#new-status-modal').modal('hide')
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        },
        editStatus () {
            let data = {id: this.status_id, status: this.newStatusName}
            axios.put('/api/admin/status',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    $('#new-status-modal').modal('hide')
                    this.statusName = ''
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        }
    }
}
</script>

<style scoped>

</style>
