<template>
    <div class="container">
        <month-selector-component></month-selector-component>
        <div class="editButtons">
            <admin-edit-inputs-component
                :user="user"
                :dateFormated="FORMATED_DATE"
                :commonDate="date"
                @setDate="setDate"
            ></admin-edit-inputs-component>
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
            <div class="col-md-6">
                <admin-user-component
                    class="mt-4"
                    :user="user"
                    :dateFormated="dateFormated"
                    :date="date"
                ></admin-user-component>
            </div>
            <div class="col-md-6">
                <order-statuses-component
                    class="mt-4"
                ></order-statuses-component>
            </div>
        </div>

    </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
import AdminMaterials from "./admin/materials";
import AdminMachines from "./admin/machines";
import {mapGetters} from 'vuex'
import OrderStatusesComponent from "./admin/OrderStatusesComponent";

export default {
    name: "AdminWrapperComponent",
    components: {OrderStatusesComponent, AdminMachines, AdminMaterials},
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
        ...mapGetters([
            'FORMATED_DATE',
        ]),
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
