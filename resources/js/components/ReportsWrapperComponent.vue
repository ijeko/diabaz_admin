<template>
    <div class="test">
        <div class="row justify-content-between">
            <month-selector-component></month-selector-component>
            <delivery-calculator-component/>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-2">
                <div class="mt-4">
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Производство
                        </button>
                        <div class="dropdown-menu">
                            <h6 class="dropdown-header">Произведено</h6>
                            <router-link :to="{ name: 'producedMonth' }">
                                <li class="dropdown-item">За месяц</li>
                            </router-link>
                            <router-link :to="{ name: 'producedMonth' }">
                                <li class="dropdown-item">За год</li>
                            </router-link>
                        </div>
                    </div>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Отргузки
                        </button>
                        <div class="dropdown-menu">
                            <h6 class="dropdown-header">Отгружено</h6>
                            <router-link :to="{ name: 'productUpload' }">
                                <li class="dropdown-item">За месяц</li>
                            </router-link>
                            <router-link :to="{ name: 'productUpload' }">
                                <li class="dropdown-item">За год</li>
                            </router-link>

                        </div>
                    </div>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Материалы
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <h6 class="dropdown-header">Отчеты</h6>
                            <a class="dropdown-item" href="#">Поступления</a>
                            <a class="dropdown-item" href="#">Потрачено</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <router-view
                    :commonDate="DATE"
                    :dateFormated="FORMATED_DATE"
                    :key="UPDATE"
                ></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import AdminMaterials from "./admin/materials";
import AdminMachines from "./admin/machines";
import {mapGetters} from 'vuex'

export default {
    name: "ReportWrapperComponent",
    components: {AdminMachines, AdminMaterials},
    data: function () {
        return {
            date: new Date().toISOString().slice(0, 10)
        }
    },
    props: {
        user: {
            default: ''
        }
    },
    computed: {
        ...mapGetters([
            'DATE',
            'UPDATE',
            'FORMATED_DATE',
        ])
    },
    methods: {
    }
}
</script>

<style scoped>
.dropright {
    margin-bottom: 10px;
    width: 100%;
}
</style>
