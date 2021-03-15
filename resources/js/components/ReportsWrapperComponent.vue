<template>
    <div class="container">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control"></div>
        <div class="row justify-content-between">
            <div class="col-md-2">
                <div
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                >
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Производство
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <h6 class="dropdown-header">Отчеты</h6>
                            <a class="dropdown-item" href="#">За месяц</a>
                            <a class="dropdown-item" href="#">За год</a>
                            <a class="dropdown-item" href="#">План-факт</a>
                        </div>
                    </div>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Продукция
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <h6 class="dropdown-header">Отчеты</h6>
                            <a class="dropdown-item" href="#">Подробно</a>
                            <a class="dropdown-item" href="#">Отгрузки</a>
                            <a class="dropdown-item" href="#">Склад</a>
                        </div>
                    </div>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <production-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></production-component>
                <motor-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></motor-component>
            </div>
            <button class="btn btn-info" @click="test">TEST</button>
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
            var dateSplit = this.date.split('-')
            var day = dateSplit[2]
            var mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            var month = mnths[parseInt(dateSplit[1]) - 1]
            var year = dateSplit[0]
            return {day: day, month: month, year: year}
        }
    },
    methods: {
        test() {
            axios.get('http://127.0.0.1:8000/api/products/test', {
                headers: {'Content-Type': 'application/json'},
            })
                .then(function (response) {
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
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
