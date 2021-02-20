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
        <button class="btn btn-dark" @click="showAddForm">Нормы расхода</button>
        <add-mat-norm v-if="isAddFormVisible"
        @closeAddForm="closeAddForm"
        ></add-mat-norm>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: 'MaterialsComponent',
    mounted() {
        console.log('Component mounted.')
        this.GET_MATERIALS()

    },
    data: function () {
        return {
            date: new Date(),
            isAddFormVisible: false
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
        showAddForm () {
            return this.isAddFormVisible = true
        },
        closeAddForm () {
            return this.isAddFormVisible = false
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
