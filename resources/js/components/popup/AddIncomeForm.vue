<template>
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Ввод поступления материлов</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeAddForm">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="date">Дата:</label>
            <input v-model="inputDate" type="date" class="form-control" id="date">
          </div>
          <div class="form-group">
            <label for="material">Материал:</label>
            <select v-model="selectedMaterial" name="material" id="material" class="form-control">
              <option value="" disabled>Выбирите материал</option>
              <option
                  v-for="(material, index) in MATERIALS"
                  :value="material"
              >{{ material.title }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="qty">Количество, {{ selectedMaterial.unit }} </label>
            <input v-model="qty" class="form-control" type="number" id="qty">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button"
                  class="btn btn-primary"
                  @click="sendIncome"
                  data-dismiss="modal"
                  :disabled="!isSelectedAndNoZero"
          >Сохранить</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeAddForm">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
  name: "AddIncomeForm",
  props: {
    user: {}

  },
  methods: {
    ...mapActions([
      'ADD_INCOME'
    ]),
    closeAddForm() {
      this.$emit('closeAddForm')
    },
    sendIncome() {
      if (this.qty <= 0) {
        this.message = 'Количество должно быть больше 0'
        return false
      }
      var data = {
        material_id: this.selectedMaterial.id,
        qty: this.qty,
        date: this.inputDate,
        user_id: this.user.id
      }
      this.ADD_INCOME(JSON.stringify(data)).then(res => {
        this.$emit('update')
        this.closeAddForm()
      })

    }
  },
  data() {
    return {
      qty: 0,
      selectedMaterial: 0,
      inputDate: new Date().toISOString().slice(0, 10),
      message: ''
    }
  },
  computed: {
    ...mapGetters([
      'MATERIALS'
    ]),
    isSelectedAndNoZero() {
      return !!(this.selectedMaterial && this.qty > 0);
    }
  }
}
</script>

<style scoped>
.body {
  padding: 10px;
  background-color: #cbd5e0;
  width: 400px;
  height: auto;
  position: absolute;
  left: 60px;
  top: 30%;
  z-index: 1;
  border-radius: 5px;
}

.btn {
  width: 100%;
}
</style>
