<template>
    <div class="card">
        <div class="card-header">Управление пользователями
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th class="text-center align-text-top">ФИО</th>
                    <th class="text-center align-text-top">Роль</th>
                    <th class="text-center align-text-top">E-mail</th>
                    <th class="text-center align-text-top">Действие</th>
                </tr>
                <tr v-for="(user, index) in usersList"
                    :key="index">
                    <td class="text-left"><span>{{ user.name }}</span></td>
                    <td class="text-center"><span>{{ user.role }}</span></td>
                    <td class="text-center"><span>{{ user.email }}</span></td>
                    <td class="text-center"><span class="btn btn-link" @click="EditUser(user)">Изменить</span></td>
                </tr>
            </table>
            <div>
                <button class="btn btn-outline-dark mt-4" @click="NewUser()">Добавить</button>
            </div>
        </div>
        <admin-new-user-component
            v-if="isNewFormVisible"
            @update="GetUsersList"
            @close="NewUser"
        ></admin-new-user-component>
        <admin-edit-user-component
            v-if="isEditFormVisible"
            :user="selectedUser"
            @update="GetUsersList"
            @close="EditUser"
        ></admin-edit-user-component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "adminUsers",
    props: {},
    data() {
        return {
            isNewFormVisible: false,
            isEditFormVisible: false,
            usersList: '',
            selectedUser: {}
        }
    },
    computed: {
        ...mapGetters([
            "MATERIALS"
        ])
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS'
        ]),
        GetUsersList() {
            axios.get('/api/admin/users', {
                headers: {'Content-Type': 'application/json'},
            })
                .then(response => {
                    this.usersList = response.data
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        EditUser (user = {}) {
            this.isEditFormVisible = this.isEditFormVisible !== true;
            this.selectedUser = user
        },
        NewUser () {
            this.isNewFormVisible = this.isNewFormVisible !== true;
        }
    },
    mounted() {
        this.GetUsersList()
    }
}
</script>

<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}

td {
    width: 25%;
}

.btn {
    width: 100%;
}
</style>
