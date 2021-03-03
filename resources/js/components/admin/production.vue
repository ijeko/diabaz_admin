<template>
    <div class="card">
        <div class="card-header">Производимая продукция
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th class="text-center">Наименование</th>
                    <!--                    <th>Остатки??</th>-->
                    <th class="text-center">Ед. изм.</th>
                    <th class="text-center">Действие</th>
                </tr>
                <tr v-for="(product, index) in PRODUCTS"
                    :key="index">
                    <td class="text-left"><span>{{ product.title }}</span></td>
                    <!--                    <td>1</td>-->
                    <td class="text-center"><span>{{ product.unit }}</span></td>
                    <td class="text-center"><span class="btn btn-link" @click="editProduct(index)">Изменить</span></td>
                </tr>
            </table>
            <div>
                <button class="btn btn-outline-dark mt-4" @click="showNewForm">Добавить</button>
            </div>
        </div>
        <admin-new-production-component
            v-if="isNewFormVisible"
            @update="GET_PRODUCTS"
            @close="closeNewForm"
        ></admin-new-production-component>
        <admin-edit-production-component
            v-if="isEditFormVisible"
            :selectedProduct="selectedProduct"
            @update="GET_PRODUCTS"
            @close="closeEditForm"
        ></admin-edit-production-component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "adminProduction",
    props: {},
    data() {
        return {
            isNewFormVisible: false,
            isEditFormVisible: false,
            selectedProduct: ''
        }
    },
    computed: {
        ...mapGetters([
            "PRODUCTS"
        ])
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        editProduct(index) {
            this.selectedProduct = index
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
        this.GET_PRODUCTS()
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
