<template>
  <div class="modal fade" id="edit-status-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Редактировать статус</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Статус</label>
          <div v-if="message.status" class="alert alert-danger">
            <div v-for="(error, index) in message.status"
                 :key="index"
            >{{ error }}
            </div>
          </div>
          <input v-model="statusName1" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button"
                  class="btn btn-primary"
                  @click="editStatus"
                  :disabled="!statusName1"
          >
            Сохранить
          </button>
          <button type="button"
                  class="btn btn-danger"
                  @click="deleteStatus"
                  data-dismiss="modal"
          >
            Удалить
          </button>

          <button type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                  @click="$emit('closeEdit')"
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
  name: "EditStatusComponent",
  data() {
    return {
      message: '',
      statusName1: this.statusName
    }
  },
  props: {
    statusName: '',
    id: ''
  },
  methods: {
    ...mapActions([
      'UPDATE_KEY'
    ]),
    deleteStatus() {
      axios.delete('/api/admin/status',
          {
            headers: {'Content-Type': 'application/json'},
            params: {id: this.id}
          })
          .then(response => {
            this.UPDATE_KEY()
            $('#edit-status-modal').modal('hide')
            this.$emit('closeEdit')
            return response.data
          })
          .catch(error => {
            this.message = error.response.data.errors
          })
    },
    editStatus() {
      let data = {id: this.id, status: this.statusName1}
      axios.put('/api/admin/status',
          {data},
          {
            headers: {'Content-Type': 'application/json'}
          })
          .then(response => {
            this.UPDATE_KEY()
            $('#edit-status-modal').modal('hide')
            this.statusName1 = ''
            this.$emit('closeEdit')
            return response.data
          })
          .catch(error => {
            this.message = error.response.data.errors
          })
    }
  },
  mounted() {
    this.previousStatusName()
  }
}
</script>

<style scoped>

</style>
