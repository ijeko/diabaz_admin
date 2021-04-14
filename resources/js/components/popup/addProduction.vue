<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ввод произведенной или списанной продукции</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="date">Дата:</label>
            <input v-model="inputDate" type="date" class="form-control" id="date">
          </div>
          <div class="form-group">
            <label for="product">Продукция</label>
            <select v-model="selectedProduct" name="product" id="product" class="form-control">
              <option
                  :value="index"
                  v-for="(product, index) in products"
              >{{ product.title }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="qty">Количество, {{ products[selectedProduct].unit }}</label>
            <input v-model="qty" class="form-control" type="number" id="qty">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="check" id="spoil" v-model="spoilCheck">
              <label class="form-check-label" for="spoil">
                Списать продукцию
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"
                  v-if="!spoilCheck"
                  @click="sendProduced"
                  data-dismiss="modal"
            >Добавить</button>
          <button type="button" class="btn btn-primary"
                  v-else
                  @click="sendProduced"
                  data-dismiss="modal"
          >Списать</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

        </div>
      </div>
    </div>
  </div>

  <!--    <div class=" body
          ">-->
          <!--        <div @click="closePopup">&times;</div>-->
          <!--        <div class="container">-->
          <!--            <div class="mt-1">-->
          <!--                <div class="text-center"><h3>Произведено:</h3></div>-->
          <!--                <div v-if="message" class="alert alert-danger" role="alert">-->
          <!--                    {{ message }}-->
          <!--                </div>-->
          <!--                <form class="" action="">-->
          <!--                    <label for="date">Дата:</label>-->
          <!--                    <input v-model="inputDate" type="date" class="form-control" id="date">-->
          <!--                    <label for="product">Материал</label>-->
          <!--                    <select v-model="selectedProduct" name="product" id="product" class="form-control">-->
          <!--                        &lt;!&ndash;                        <option value="asd" disabled>Продукция</option>&ndash;&gt;-->
          <!--                        <option-->
          <!--                            :value="index"-->
          <!--                            v-for="(product, index) in products"-->
          <!--                        >{{ product.title }}-->
          <!--                        </option>-->
          <!--                    </select>-->
          <!--                    <label for="qty">Количество, {{ products[selectedProduct].unit }}</label>-->
          <!--                    <input v-model="qty" class="form-control" type="number" id="qty">-->
          <!--                </form>-->
          <!--            </div>-->
          <!--            <input type="checkbox" id="jack" value="check" v-model="spoilCheck">-->
          <!--            <label for="jack">Списать продукцию</label>-->
          <!--            <div class="mt-3">-->
          <!--                <button class="btn btn-outline-dark mt-30"-->
          <!--                        v-if="!spoilCheck"-->
          <!--                        @click="sendProduced">Добавить-->
          <!--                </button>-->
          <!--            </div>-->
          <!--            <div class="mt-3">-->
          <!--                <button class="btn btn-outline-dark mt-30"-->
          <!--                        v-if="spoilCheck"-->
          <!--                        @click="sendProduced">Списать-->
          <!--                </button>-->
          <!--            </div>-->
          <!--            <div class="mt-3">-->
          <!--                <button class="btn btn-outline-danger mt-30" @click="closePopup">Закрыть</button>-->
          <!--            </div>-->
          <!--        </div>-->
          <!--    </div>-->
</template>

<script>

export default {
  name: "popup",
  props: {
    products: {
      type: Array,
      default: [],
    },
    user: {}

  },
  methods: {
    closePopup() {
      this.$emit('closePopup')
    },
    sendProduced() {
      if (this.qty <= 0) {
        this.message = 'Количество должно быть больше 0'
        return false
      }
      var data = {
        product_id: this.products[this.selectedProduct].id,
        qty: this.qty,
        date: this.inputDate,
        user_id: this.user.id
      }
      if (this.spoilCheck) {
        this.$emit('sendSpoiled', data)
      } else
        this.$emit('sendProduced', data)
    }
  },
  data() {
    return {
      qty: 0,
      selectedProduct: 0,
      inputDate: new Date().toISOString().slice(0, 10),
      message: '',
      spoilCheck: ''

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
