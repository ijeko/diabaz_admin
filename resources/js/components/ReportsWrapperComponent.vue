<template>
    <div class="container">
        <div class="bg-light text-center"><input v-model="date" type="date" class="form-control"></div>
        <div class="row justify-content-between">
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
            date: new Date().toISOString().slice(0,10)
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
            var month = mnths[parseInt(dateSplit[1])-1]
            var year = dateSplit[0]
            return {day: day, month: month, year: year}
        }
    },
    methods: {
        test () {
            axios.get('http://127.0.0.1:8000/api/products/test', {
                headers: {'Content-Type': 'application/json'}
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

</style>
