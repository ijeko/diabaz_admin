<template>
    <div class="wrapper">
        <div class="text-right" @click="close">&times;</div>
        <h3 class="text-center mb-4">Редактировать</h3>
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
        return {}
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
            let data = JSON.stringify({
                id: this.MACHINES[this.selectedMachine].id,
                title: this.newMachineName,
                name: this.newMachineSlug,
                unit: this.newMachineUnit
            })
            axios.post('http://127.0.0.1:8000/api/machines/edit',
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
        },
        deleteMachine(id) {
            axios.delete('http://127.0.0.1:8000/api/machines/remove',
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
