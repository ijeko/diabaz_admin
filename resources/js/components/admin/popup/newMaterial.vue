<template>
    <div class="wrapper">
        <div class="text-right" @click="close">&times;</div>
        <h3 class="text-center mb-4">Новая продукция</h3>
        <label>Название продукции</label> <span v-if="info"
                                                class="badge bg-danger text-white">{{ info.data.title }}</span>
        <input v-model="title" class="form-control" list="materials">
        <datalist id="materials">
            <option v-for="material in MATERIALS">{{ material.title }}</option>
        </datalist>
        <label>Краткое название на английском</label> <span v-if="info" class="badge bg-danger text-white">{{info.data.name }}</span>
        <input v-model="name" class="form-control">
        <label>Единица измерения</label>
        <input type="text" v-model="unit" class="form-control">
        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="addMaterial" :disabled="!complete">
            Сохранить
        </button>
        <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "newMaterial",
    data() {
        return {
            title: '',
            name: '',
            unit: '',
            info: '',
        }
    },
    computed: {
        ...mapGetters([
            'MATERIALS'
        ]),
        complete() {
            if (this.title && this.name && this.unit) {
                return true
            }
            return false
        }
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ]),
        close() {
            this.$emit('close')
        },
        addMaterial() {
            let data = JSON.stringify({
                title: this.title,
                name: this.name,
                unit: this.unit
            })
            axios.post('http://127.0.0.1:8000/api/materials/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                }).then(response => {
                this.info = response
                if (response.data === 200) {
                    alert('200')
                    this.$emit('close')
                    this.$emit('update')
                } else return false
            })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })

        }
    },
    mounted() {
        this.GET_MATERIALS()
    }
}
</script>

<style scoped>
.wrapper {
    width: 500px;
    height: auto;
    position: absolute;
    top: 50px;
    right: 50%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
