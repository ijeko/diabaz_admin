<template>
    <div class="body">
        <div @click="closeAddForm">&times;</div>
        <div class="container">
            <div class="mt-1">
                <div class="text-center"><h3>Поступление:</h3></div>
                <div v-if="message" class="alert alert-danger" role="alert">
                    {{ message }}
                </div>
                <form class="" action="">
                    <label for="date">Дата:</label>
                    <input v-model="inputDate" type="date" class="form-control" id="date">
                    <label for="material">Материал:</label>
                    <select  v-model="selectedMaterial" name="material" id="material" class="form-control">
<!--                        <option value="" disabled>Материал...</option>-->
                        <option
                            v-for="(material, index) in MATERIALS"
                            :value="index"

                           >{{material.title}}</option>
                    </select>
                    <label for="qty">Количество, {{MATERIALS[selectedMaterial].unit}} </label>
                    <input v-model="qty" class="form-control" type="number" id="qty">
                </form>
            </div>

            <div class="">
                <button class="btn btn-outline-dark mt-3" @click="sendIncome">Сохранить</button>
                <button class="btn btn-outline-danger mt-3" @click="closeAddForm">Закрыть</button>
            </div>
        </div>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: "AddIncomeForm",
    props: {
        user: ''

    },
    methods: {
        ...mapActions([
            'ADD_INCOME'
        ]),
        closeAddForm () {
            this.$emit('closeAddForm')
        },
        sendIncome () {
            if (this.qty <=0) {
                this.message = 'Количество должно быть больше 0'
                return false
            }
                var data = {material_id: this.MATERIALS[this.selectedMaterial].id, qty: this.qty, date: this.inputDate, user_id: this.user}
            this.ADD_INCOME(JSON.stringify(data))
            this.$emit('update')

            this.closeAddForm()
        }
    },
    data () {
        return {
            qty: 0,
            selectedMaterial: 0,
            inputDate: new Date().toISOString().slice(0,10),
            message: ''
        }
    },
    computed: {
        ...mapGetters([
            'MATERIALS'
        ])
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
