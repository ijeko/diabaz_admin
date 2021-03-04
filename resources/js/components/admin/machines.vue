<template>
    <div class="card">
        <div class="card-header">Техника
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th class="text-center">Наименование</th>
                    <!--                    <th>Остатки??</th>-->
                    <th class="text-center">Ед. учета</th>
                    <th class="text-center">Действие</th>
                </tr>
                <tr v-for="(machine, index) in MACHINES"
                    :key="index">
                    <td class="text-left"><span>{{ machine.title }}</span></td>
                    <!--                    <td>1</td>-->
                    <td class="text-center"><span>{{ machine.unit }}</span></td>
                    <td class="text-center"><span class="btn btn-link" @click="editMachine(index)">Изменить</span></td>
                </tr>
            </table>
            <div>
                <button class="btn btn-outline-dark mt-4" @click="showNewForm">Добавить</button>
            </div>
        </div>
        <admin-new-machine-component
            v-if="isNewFormVisible"
            @update="GET_MACHINES"
            @close="closeNewForm"
        ></admin-new-machine-component>
        <admin-edit-machine-component
            v-if="isEditFormVisible"
            :selectedMachine="selectedMachine"
            @update="GET_MACHINES"
            @close="closeEditForm"
        ></admin-edit-machine-component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "adminMachines",
    props: {},
    data() {
        return {
            isNewFormVisible: false,
            isEditFormVisible: false,
            selectedMachine: ''
        }
    },
    computed: {
        ...mapGetters([
            "MACHINES"
        ])
    },
    methods: {
        ...mapActions([
            'GET_MACHINES'
        ]),
        editMachine(index) {
            this.selectedMachine = index
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
        this.GET_MACHINES()
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
