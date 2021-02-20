<template>
    <div class="card">
        <div class="card-header">Информация по моточасам/километрам на {{ dateFormated.day }} {{ dateFormated.month }} {{ dateFormated.year }}г.</div>
        <div class="card-body">
         {{ MACHINES }}
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'motor',
    mounted() {
        console.log('Component mounted.')
    },
    data: function () {
        return {
            date: new Date()
        }
    },
    props: {
        user: '',
        dateFormated: ''
    },
    computed: {
        ...mapGetters([
           'MACHINES'
        ])
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
