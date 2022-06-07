<template>
    <div>
        <admin-up-header/>

        <div class="container">
            <div class="admin-wrapper">
                <div class="admin-nav">
                    <ul class="admin-nav__list">
                        <li class="admin-nav__item"><router-link to="/admin/users">Users</router-link></li>
                        <li class="admin-nav__item"><router-link to="/admin/nfts/all-nfts">Beatoken NFT</router-link></li>
                    </ul>
                </div>

                <div class="admin-main">
                    <div class="admin-main__nav">
                        <div class="admin-main__title-block">
                            <h3 class="admin-main__title">Beatoken Users</h3>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">User Avatar</th>
                                <th scope="col">User name</th>
                                <th scope="col">User Email</th>
                                <th scope="col">Date of registration</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="item in users">
                                <tr>
                                    <th scope="row">{{item.id}}</th>
                                    <td><img :src="item.full_uri_avatar" alt="user-avatar"/></td>
                                    <td><small>{{item.name}}</small></td>
                                    <td><small>{{item.email}}</small></td>
                                    <td><small>{{item.created_at | formatDate}}</small></td>
                                    <td>
                                        <router-link :to="'/admin/user/' + item.id + '/profile'" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></router-link>
                                        <button disabled class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import AdminUpHeader from './components/AdminUpHeader'

export default {
    name: 'all-users',
    components: {
        AdminUpHeader,
    },
    data() {
        return  {
            users: {}
        }
    },
    created() {
        this.getAllUsers()
    },
    filters: {
        formatDate(date) {
            return moment(String(date)).format('DD.MM.YYYY')
        }
    },
    methods: {
        getAllUsers() {
            this.$store.dispatch('users/getAllUsers')
                .then((resp) => {
                    this.users = resp
                })
        }
    }
}
</script>

<style scoped>
td, th {
    padding: 2px 3px!important;
}
</style>
