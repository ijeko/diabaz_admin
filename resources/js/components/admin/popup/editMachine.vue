<template>
    <div class="wrapper">
        <div class="text-right" @click="close">&times;</div>
        <h3 class="text-center mb-4">Редактировать</h3>
        <div v-if="message" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
        <label>Название техники</label>
        <input v-model="newMachineName" class="form-control">
        <label>Краткое название на английском</label>
        <input v-model="newMachineSlug" class="form-control">
        <label>Единица измерения</label>
        <input type="text" v-model="newMachineUnit" class="form-control">
        <button class="btn btn-outline-success mt-4 actions" @click="saveMachine">
            Сохранить
        </button>
        <button class="btn btn-outline-danger mt-4 actions" @click="deleteMachine(MACHINES[selectedMachine].id)">
            Удалить
        </button>
        <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "editMachine",
    data() {
        return {
            message: ''
        }
    },
    props: {
        selectedMachine: '',
        newMachineName: '',
        newMachineSlug: '',
        newMachineUnit: '',
    },
    computed: {
        ...mapGetters([
            'MACHINES',
        ]),
        validation () {
            if (this.newMachineName === '') {
                this.message = 'Название техники не заполнино'
                return false
            }
            if (this.newMachineName.length < 3) {
                this.message = 'Название техники не должно быть менее 3 символов'
                return false

            }
            if (this.newMachineSlug === '') {
                 this.message = 'сокращенное название не заполнино'
                return false

            }
            if (this.newMachineSlug.length < 3) {
                 this.message = 'Сокращенное не должно быть менее 3 символов'
                return false

            }
            var slugRE = new RegExp('^[a-zA-Z0-9]+$')
            if(!slugRE.test(this.newMachineSlug)) {
                 this.message = 'Сокращенное может состоять только из латинских букв и цифр'
                return false
            }
            if (this.newMachineUnit === '') {
                this.message = 'Едицина измерения не заполнена'
                return false
            }
            var unitRE = new RegExp('^[а-яА-ЯёЁa-zA-Z0-9]+$')
            if(!unitRE.test(this.newMachineUnit)) {
                this.message = 'Единица измерения не может быть цифрой'
                return false
            }
        }

    },
    methods: {
        ...mapActions([]),
        close() {
            this.$emit('close')
        },
        machineInfo() {
            // alert(this.PRODUCTS[this.selectedProduct].title)
            this.newMachineName = this.MACHINES[this.selectedMachine].title
            this.newMachineSlug = this.MACHINES[this.selectedMachine].name
            this.newMachineUnit = this.MACHINES[this.selectedMachine].unit
        },
        saveMachine() {
            if (this.validation === false) {
                return false
            } else {
                let data = JSON.stringify({
                    id: this.MACHINES[this.selectedMachine].id,
                    title: this.newMachineName,
                    name: this.newMachineSlug,
                    unit: this.newMachineUnit
                })
                axios.put('api/machines',
                    {data},
                    {
                        headers: {'Content-Type': 'application/json'}
                    })
                    .then(function (response) {
                        return data
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                this.$emit('update')
                this.$emit('close')
            }
        },
        deleteMachine(id) {
            axios.delete('/api/machines',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: {id: id}
                })
                .then(function (response) {
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            this.$emit('update')
            this.$emit('close')
        }
    },
    mounted() {
        this.machineInfo()
    }
}
</script>

<style scoped>
.wrapper {
    width: 500px;
    height: auto;
    position: absolute;
    bottom: 50px;
    left: 50%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.actions {
    width: 49%;
}
</style>
