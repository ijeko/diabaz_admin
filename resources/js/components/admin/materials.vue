<template>
    <div class="card">
        <div class="card-header">Используемые материалы
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th class="text-center">Наименование</th>
                    <!--                    <th>Остатки??</th>-->
                    <th class="text-center">Ед. изм.</th>
                    <th class="text-center">Действие</th>
                </tr>
                <tr v-for="(material, index) in MATERIALS"
                    :key="index">
                    <td class="text-left"><span>{{ material.title }}</span></td>
                    <!--                    <td>1</td>-->
                    <td class="text-center"><span>{{ material.unit }}</span></td>
                    <td class="text-center"><span class="btn btn-link" @click="editMaterial(index)">Изменить</span></td>
                </tr>
            </table>
            <div>
                <button class="btn btn-outline-dark mt-4" @click="showNewForm">Добавить</button>
            </div>
        </div>
        <admin-new-material-component
            v-if="isNewFormVisible"
            @update="GET_MATERIALS"
            @close="closeNewForm"
        ></admin-new-material-component>
        <admin-edit-material-component
            v-if="isEditFormVisible"
            :selectedMaterial="selectedMaterial"
            @update="GET_MATERIALS"
            @close="closeEditForm"
        ></admin-edit-material-component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "adminMaterials",
    props: {},
    data() {
        return {
            isNewFormVisible: false,
            isEditFormVisible: false,
            selectedMaterial: ''
        }
    },
    computed: {
        ...mapGetters([
            "MATERIALS"
        ])
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ]),
        editMaterial(index) {
            this.selectedMaterial = index
            this.isEditFormVisible = true
        },
        closeEditForm() {
            this.isEditFormVisible = false
        },
        showNewForm() {
            this.isNewFormVisible = true
        },
        closeNewForm() {
            this.isNewFormVisible = false
        },
    },
    mounted() {
        this.GET_MATERIALS()
    }
}
</script>

<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}

td {
    width: 25%;
}

.btn {
    width: 100%;
}
</style>
