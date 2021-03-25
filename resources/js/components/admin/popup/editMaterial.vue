<template>
    <div class="wrapper">
        <div class="formBox">
            <div class="text-right" @click="close">&times;</div>
            <h3 class="text-center mb-4">Редактировать</h3>
            <div v-if="message" class="alert alert-danger" role="alert">
                {{ message }}
            </div>
            <label>Название материала</label>
            <input v-model="newMaterialName" class="form-control">
            <label>Краткое название на английском</label>
            <input v-model="newMaterialSlug" class="form-control">
            <label>Минимальное количество</label>
            <input type="number" v-model="newMinQty" class="form-control">
            <label>Единица измерения</label>
            <input type="text" v-model="newMaterialUnit" class="form-control">
            <button class="btn btn-outline-success mt-4 actions" @click="saveMaterial">
                Сохранить
            </button>
            <button class="btn btn-outline-danger mt-4 actions" @click="deleteMaterial(MATERIALS[selectedMaterial].id)">
                Удалить
            </button>
            <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "editMaterial",
    data() {
        return {}
    },
    props: {
        selectedMaterial: '',
        newMaterialName: '',
        newMaterialSlug: '',
        newMaterialUnit: '',
        newMinQty: '',
        message: ''
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
        ]),
        validation() {
            if (this.newMaterialName === '') {
                this.message = 'Название техники не заполнино'
                return false
            }
            if (this.newMaterialName.length < 3) {
                this.message = 'Название техники не должно быть менее 3 символов'
                return false

            }
            if (this.newMaterialSlug === '') {
                this.message = 'сокращенное название не заполнино'
                return false

            }
            if (this.newMaterialSlug.length < 3) {
                this.message = 'Сокращенное не должно быть менее 3 символов'
                return false

            }
            var slugRE = new RegExp('^[a-zA-Z0-9]+$')
            if (!slugRE.test(this.newMaterialSlug)) {
                this.message = 'Сокращенное может состоять только из латинских букв и цифр'
                return false
            }
            if (this.newMaterialUnit === '') {
                this.message = 'Едицина измерения не заполнена'
                return false
            }
            var unitRE = new RegExp('^[а-яА-ЯёЁa-zA-Z0-9]+$')
            if (!unitRE.test(this.newMaterialUnit)) {
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
        materialInfo() {
            // alert(this.PRODUCTS[this.selectedProduct].title)
            this.newMaterialName = this.MATERIALS[this.selectedMaterial].title
            this.newMaterialSlug = this.MATERIALS[this.selectedMaterial].name
            this.newMaterialUnit = this.MATERIALS[this.selectedMaterial].unit
            this.newMinQty = this.MATERIALS[this.selectedMaterial].minQty
        },
        saveMaterial() {
            if (this.validation === false) {
                return false
            } else {
                let data = JSON.stringify({
                    id: this.MATERIALS[this.selectedMaterial].id,
                    title: this.newMaterialName,
                    name: this.newMaterialSlug,
                    unit: this.newMaterialUnit,
                    minQty: this.newMinQty
                })
                axios.put('/api/materials/admin',
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
        deleteMaterial(id) {
            axios.delete('/api/materials/admin',
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
        this.materialInfo()
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

.actions {
    width: 49%;
}
</style>
