<template>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ввод показателей работы техники</h5>
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
                        <label for="machine">Техника</label>
                        <select v-model="selectedMachine" name="machine" id="machine" class="form-control">
                            <option
                                :value="index"
                                v-for="(machine, index) in machines"
                            >{{ machine.title }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Количество, {{ machines[selectedMachine].unit }}</label>
                        <input v-model="qty" class="form-control" type="number" id="qty">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="sendMotohour" data-dismiss="modal">Сохранить
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closePopup">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="body">-->
    <!--        <div @click="closePopup">&times;</div>-->
    <!--        <div class="container">-->
    <!--            <div class="mt-1">-->
    <!--                <div class="text-center"><h3>Использование техники:</h3></div>-->
    <!--                <div v-if="message" class="alert alert-danger" role="alert">-->
    <!--                    {{ message }}-->
    <!--                </div>-->
    <!--                <form class="" action="">-->
    <!--                    <label for="date">Дата:</label>-->
    <!--                    <input v-model="inputDate" type="date" class="form-control" id="date">-->
    <!--                    <label for="machine">Техника</label>-->
    <!--                    <select  v-model="selectedMachine" name="machine" id="machine" class="form-control">-->
    <!--&lt;!&ndash;                        <option value="asd" disabled>Продукция</option>&ndash;&gt;-->
    <!--                        <option-->
    <!--                            :value="index"-->
    <!--                            v-for="(machine, index) in machines"-->
    <!--                           >{{machine.title}}</option>-->
    <!--                    </select>-->
    <!--                    <label for="qty">Количество, {{machines[selectedMachine].unit}}</label>-->
    <!--                    <input v-model="qty" class="form-control" type="number" id="qty">-->
    <!--                </form>-->
    <!--            </div>-->

    <!--            <div class="mt-3">-->
    <!--                <button class="btn btn-outline-dark mt-30" @click="sendMotohour">Сохранить</button>-->
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
        machines: {
            type: Array,
            default: [],
        },
        user: {}

    },
    methods: {
        closePopup() {
            this.$emit('closePopup')
        },
        sendMotohour() {
            if (this.qty <= 0) {
                this.message = 'Количество должно быть больше 0'
                return false
            }
            var data = {
                machine_id: this.machines[this.selectedMachine].id,
                qty: this.qty,
                date: this.inputDate,
                user_id: this.user.id
            }
            this.$emit('sendMotohour', data)
        }
    },
    data() {
        return {
            qty: 0,
            selectedMachine: 0,
            inputDate: new Date().toISOString().slice(0, 10),
            message: ''
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
