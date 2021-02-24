<template>
    <div class="card">
        <div class="card-header">Данные по материалам на {{ dateFormated.day }} {{ dateFormated.month }} {{ dateFormated.year }}г.</div>
        <div class="card-body">
            <div class="materials"
                 v-for="(material, index) in MATERIALS"
                 :key="index">
                <div class="material-name">
                    <div>{{ material.title }}
                    </div>
                </div>
                <div class="material-qty">{{ material.qty }} {{ material.unit }}</div>
            </div>
        </div>
        <button class="btn btn-dark" @click="showShowNorm">Нормы расхода</button>
        <show-norm v-if="isShowNormVisible"
        @closeShowNorm="closeShowNorm"
        ></show-norm>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import ShowNorm from "./popup/ShowNorm";
export default {
    name: 'MaterialsComponent',
    components: {ShowNorm},
    mounted() {
        console.log('Component mounted.')
        this.GET_MATERIALS()

    },
    data: function () {
        return {
            date: new Date(),
            isShowNormVisible: false
        }
    },
    props: {
        dateFormated: '',
        user: ''
    },
    computed: {
        ...mapGetters([
            'MATERIALS'
        ])
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ]),
        showShowNorm () {
            return this.isShowNormVisible = true
        },
        closeShowNorm () {
            return this.isShowNormVisible = false
        }
    }
}
</script>
<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
