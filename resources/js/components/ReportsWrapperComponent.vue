<template>
    <div class="test">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control" disabled></div>
        <div class="row justify-content-between">
            <div class="col-md-2">
                <div
                    class="mt-4"
                >
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Производство
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <h6 class="dropdown-header">Отчеты</h6>
                                <router-link :to="{ name: 'producedMonth' }">
                                    <li class="dropdown-item">За месяц</li>
                                </router-link>

                            <!--                            <a class="dropdown-item" href="#">За месяц</a>-->
                            <!--                            <a class="dropdown-item" href="#">За год</a>-->
                            <!--                            <a class="dropdown-item" href="#">План-факт</a>-->
                        </div>
                    </div>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Продукция
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <h6 class="dropdown-header">Отчеты</h6>
                            <a class="dropdown-item" href="#">Подробно</a>
                                <router-link :to="{ name: 'productUpload' }">
                                    <li class="dropdown-item">Отгрузки</li>
                                </router-link>

                            <a class="dropdown-item" href="#">Склад</a>
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
                            <a class="dropdown-item" href="#">Остатки</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <router-view
                    :commonDate="date"
                    :dateFormated="dateFormated"
                    @setDate="setDate"
                ></router-view>
            </div>

        </div>
    </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
import AdminMaterials from "./admin/materials";
import AdminMachines from "./admin/machines";

export default {
    name: "AdminWrapperComponent",
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
        dateFormated() {
            const dateSplit = this.date.split('-')
            const day = dateSplit[2]
            const mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            const ofMnths = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь']
            const month = mnths[parseInt(dateSplit[1]) - 1]
            const ofMonth = ofMnths[parseInt(dateSplit[1]) - 1]
            const year = dateSplit[0]
            return {day: day, month: month, ofMonth: ofMonth, year: year}
        }
    },
    methods: {
        setDate(newDate) {
            this.date = newDate
        }

    }
}
</script>

<style scoped>
.dropright {
    margin-bottom: 10px;
    width: 100%;
}
</style>
