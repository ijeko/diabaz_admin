<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        And the data is {{this.testnumber}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'app',
        mounted() {
            console.log('Component mounted.')
        },
        data () {
            return {
                testnumber: 28821
            }
        }
    }
</script>
