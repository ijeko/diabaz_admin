<template>
    <div class="wrapper">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                Расчет перевозки
            </button>
            <div class="dropdown-menu p-3" aria-labelledby="dropdownMenu2">
                <form>
                    <div class="form-group">
                        <label for="cityFrom">Из города: </label>
                        <input id="cityFrom" v-model="cityFrom" ref="input" class="form-control" autofocus
                               autocomplete="off" list="cityFromList"
                               placeholder="Новосибирск"
                               @focus="currentInput = 'cityFrom'"
                               @input="test()">
                        <div id="cityFromList" class="list-group" v-show="showFromList">
                            <button
                                type="button"
                                class="list-group-item list-group-item-action"
                                v-for="city in cityList"
                                @click="selectCity(city)"
                            >{{ city.city_name }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cityTo">В город:</label>
                        <input id="cityTo" v-model="cityTo" ref="input" class="form-control" autocomplete="off"
                               list="cityToList"
                               placeholder="Душанбе"
                               @focus="currentInput = 'cityTo'"
                               @input="test()">
                        <div id="cityToList" class="list-group" v-show="showToList">
                            <button
                                type="button"
                                class="list-group-item list-group-item-action"
                                v-for="city in cityList"
                                @click="selectCity(city)"
                            >{{ city.city_name }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <div class="d-flex"><component-loader v-if="isLoading"></component-loader></div>
                            <div v-if="message"
                                 class="alert alert-danger"
                                 role="alert"
                                 @click="message => {this.message=''}"
                            >
                                {{ message.error}}
                                <div v-for="(item, index) in message.data"
                                     :key="index"
                                >
                                    {{ item.title }} - {{ item.qty }} {{ item.unit }}
                                </div>
                            </div>
                            <span v-if="result">Средняя стоимость перевозки {{result}} руб за 20 тонн</span>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn btn-primary"
                        :disabled=!isSelectedAndNoZero
                        @click="sendInputData">Расчитать</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeliveryCalculatorModal",
    data() {
        return {
            message: '',
            cityFrom: '',
            cityTo: '',
            cityList: [],
            currentInput: '',
            selectedCityFrom: {},
            selectedCityTo: {},
            showFromList: false,
            showToList: false,
            result:'',
            isLoading: false
        }
    },
    methods: {
        test() {
            axios.post('/api/instrument/transport/city',
                {prefix: this.cityInput, geo_types: 7},
                {
                    headers: {'Content-Type': 'application/json'},
                })
                .then(response => {
                    this.cityList = response.data
                    return response.data
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        selectCity(city) {

            if (this.currentInput == 'cityFrom') {
                this.cityFrom = city.city_name
                this.selectedCityFrom = city
                console.log(this.selectedCityFrom)
                this.showFromList = false
            }
            if (this.currentInput == 'cityTo') {
                this.cityTo = city.city_name
                this.selectedCityTo = city
                console.log(this.selectedCityTo)

                this.showToList = false
            }
        },
        sendInputData() {
            this.message = ''
            this.isLoading = true
            this.result = ''
            let data = {
                from: {"id": this.selectedCityFrom.id, "type": this.selectedCityFrom.type, "exact_only": false},
                to: {"id": this.selectedCityTo.id, "type": this.selectedCityTo.type, "exact_only": false}
            }
            axios.post('/api/instrument/transport/tax',
                {data},
                {
                    headers: {'Content-Type': 'application/json'},
                })
                .then(response => {
                    this.result = response.data
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
                .then(response => {
                        this.isLoading = false
                })
        }
    },
    computed: {
        cityInput() {
            if (this.currentInput == 'cityFrom') {
                this.showToList = false
                this.showFromList = true
                return this.cityFrom
            }
            if (this.currentInput == 'cityTo') {
                this.showToList = true
                this.showFromList = false
                return this.cityTo
            }
        },
        isSelectedAndNoZero() {
            if (this.selectedCityTo.id && this.selectedCityFrom.id)
            {
                return true
            }
            else  return false
        }
    }
}
</script>

<style scoped>

</style>
