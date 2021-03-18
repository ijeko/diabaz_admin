<template>
    <div class="container">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control"></div>
        <div class="editButtons">
            <div class="btn btn-link" @click="editSoldControl">Изменить отгрузки</div>
            <div class="btn btn-link">Изменить произведено</div>

        </div>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <admin-production-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></admin-production-component>
            </div>
            <div class="col-md-6">
                <admin-materials-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></admin-materials-component>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <admin-machines-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></admin-machines-component>
            </div>
        </div>
        <admin-edit-sold-component
            v-if="showEditSold"
            @colse="editSoldControl"
            :user="user"
            :dateFormated="dateFormated"
            :commonDate="date"
            @setDate="setDate"
        ></admin-edit-sold-component>
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
            date: new Date().toISOString().slice(0, 10),
            showEditSold: false,
            showEditProduced: false
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
        editSoldControl () {
            this.showEditSold = !this.showEditSold;
        },
        setDate(newDate) {
            this.date = newDate
        }
    }
}
</script>

<style scoped>

</style>
