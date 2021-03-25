<template>
    <div class="wrapper">
        <div class="formBox">
            <div class="text-right" @click="close">&times;</div>
            <h3 class="text-center mb-4">Новая продукция</h3>
            <div v-if="message" class="alert alert-danger" role="alert">
                {{ message }}
            </div>
            <label>Название продукции</label> <span v-if="info"
                                                    class="badge bg-danger text-white">{{ info.data.title }}</span>
            <input v-model="title" class="form-control" list="materials">
            <datalist id="materials">
                <option v-for="material in MATERIALS">{{ material.title }}</option>
            </datalist>
            <label>Краткое название на английском</label> <span v-if="info" class="badge bg-danger text-white">{{
                info.data.name
            }}</span>
            <input v-model="name" class="form-control">
            <label>Единица измерения</label>
            <input type="text" v-model="unit" class="form-control">
            <label>Минимальное количество</label>
            <input type="number" v-model="minQty" class="form-control">
            <button class="btn btn-outline-success mt-4" style="width: 100%" @click="addMaterial" :disabled="!complete">
                Сохранить
            </button>
            <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
        </div>
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
            minQty: 0,
            message: ''
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
        },
        validation() {
            if (this.title === '') {
                this.message = 'Название техники не заполнино'
                return false
            }
            if (this.title.length < 3) {
                this.message = 'Название техники не должно быть менее 3 символов'
                return false

            }
            if (this.name === '') {
                this.message = 'сокращенное название не заполнино'
                return false

            }
            if (this.name.length < 3) {
                this.message = 'Сокращенное название не должно быть менее 3 символов'
                return false

            }
            var slugRE = new RegExp('^[a-zA-Z0-9]+$')
            if (!slugRE.test(this.name)) {
                this.message = 'Сокращенное может состоять только из латинских букв и цифр'
                return false
            }
            if (this.unit === '') {
                this.message = 'Едицина измерения не заполнена'
                return false
            }
            var unitRE = new RegExp('^[а-яА-ЯёЁa-zA-Z0-9]+$')
            if (!unitRE.test(this.unit)) {
                this.message = 'Единица измерения не может быть цифрой'
                return false
            }
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
            if (this.validation === false) {
                return false
            } else {
                let data = JSON.stringify({
                    title: this.title,
                    name: this.name,
                    unit: this.unit,
                    minQty: this.minQty
                })
                axios.post('/api/materials/admin',
                    {data},
                    {
                        headers: {'Content-Type': 'application/json'}
                    }).then(response => {
                    this.info = response
                    if (response.data === 200) {
                        this.$emit('close')
                        this.$emit('update')
                    } else return false
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            }
        }
    },
    mounted() {
        this.GET_MATERIALS()
    }
}
</script>

<style scoped>
.wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    flex-shrink: 0;
    flex-grow: 0;
    width: 100%;
    min-height: 100%;
    margin: auto;
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    justify-content: center;
}

.formBox {
    margin: 50px 0;
    flex-shrink: 0;
    flex-grow: 0;
    background: #fff;
    width: 600px;
    max-width: 100%;
    overflow: visible;
    transition: transform 0.2s ease 0s, opacity 0.2s ease 0s;
    transform: scale(0.9);
    opacity: 1;
}

.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
