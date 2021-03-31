<template>
    <div class="wrapper">
        <div class="formBox">
            <div class="formBox">
                <div class="text-right" @click="close">&times;</div>
                <h3 class="text-center mb-4">Редактировать</h3>
                <div v-if="messageFront" class="alert alert-danger" role="alert">
                    {{ messageFront }}
                </div>
                <div v-if="message.auth" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.auth"
                  :key="index"
            >{{ error }}</span>
                </div>
                <label>ФИО</label>
                <input v-model="newUserName" class="form-control">
                <div v-if="message.name" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.name"
                  :key="index"
            >{{ error }}</span>
                </div>
                <label>Роль</label>
                <input v-model="newUserRole" class="form-control">
                <div v-if="message.role" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.role"
                  :key="index"
            >{{ error }}</span>
                </div>
                <label>E-mail</label>
                <input type="email" v-model="newUserEmail" class="form-control" autocomplete="off">
                <div v-if="message.email" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.email"
                  :key="index"
            >{{ error }}</span>
                </div>
                <label>Пароль</label>
                <input type="password" v-model="newUserPassword" class="form-control" autocomplete="off">
                <div v-if="message.password" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.password"
                  :key="index"
            >{{ error }}</span>
                </div>
                <button class="btn btn-outline-success mt-4 actions" @click="addUser">
                    Сохранить
                </button>
                <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "newUser",
    data() {
        return {
            newUserName: '',
            newUserRole: '',
            newUserEmail: '',
            info: '',
            newUserPassword: '',
            message: '',
            messageFront: ''
        }
    },
    computed: {
        ...mapGetters([
            'MATERIALS'
        ]),
        complete() {
            return !!(this.name && this.role && this.email && this.password);

        },
        validation() {
            if (this.newUserName === '') {
                this.messageFront = 'ФИО не заполнено'
                return false
            }
            if (this.newUserName.length < 3) {
                this.messageFront = 'ФИО должно быть менее 3 символов'
                return false

            }
            if (this.newUserRole === '') {
                this.messageFront = 'Название роли не заполнино'
                return false

            }
            if (this.newUserRole.length < 3) {
                this.messageFront = 'Название роли не должно быть менее 3 символов'
                return false

            }
            var slugRE = new RegExp('/^[^\\s@]+@[^\\s@]+$/')
            if (slugRE.test(this.newUserEmail)) {
                this.messageFront = 'E-mail введен не корректно'
                return false
            }
            if (this.newUserPassword === '') {
                this.messageFront = 'Пароль не заполнен'
                return false
            }
            this.messageFront = ''
        }

    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ]),
        close() {
            this.$emit('close')
        },
        addUser() {
            if (this.validation === false) {
                return false
            } else {
                let data = JSON.stringify({
                    name: this.newUserName,
                    role: this.newUserRole,
                    email: this.newUserEmail,
                    password: this.newUserPassword
                })
                axios.post('/api/admin/users',
                    {data},
                    {
                        headers: {'Content-Type': 'application/json'}
                    })
                    .then(response => {
                        this.$emit('update')
                        this.$emit('close')
                        return response.data
                    })
                    .catch(error => {
                        if (error.response) {
                            this.message = error.response.data.errors
                        }
                        return error
                    })
            }
        }
    },
    mounted() {
    }
}
</script>

<style scoped>
.wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    flex-shrink: 0;
    flex-grow: 0;
    width: 100%;
    min-height: 100%;
    margin: auto;
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    justify-content: center;
}

.formBox {
    margin: 50px 0;
    flex-shrink: 0;
    flex-grow: 0;
    background: #fff;
    width: 600px;
    max-width: 100%;
    overflow: visible;
    transition: transform 0.2s ease 0s, opacity 0.2s ease 0s;
    transform: scale(0.9);
    opacity: 1;
}

.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
