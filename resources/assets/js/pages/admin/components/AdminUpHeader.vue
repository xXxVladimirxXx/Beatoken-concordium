<template>

    <nav class="navbar">
        <div class="container">
            <div class="nav-container">
                <router-link class="navbar-brand" to="/">
                    <img src="assets/img/logo.png" class="img-logo" alt="logo" />
                    <img src="assets/img/beatokenTextLogo.svg" class="text-logo" alt="..."/>
                </router-link>

                <div class="nav-collapse" v-bind:class="{ 'nav-active': isMobile }">
                    <div class="nav-collapse__main">
                        <ul class="navbar-list main">
                        </ul>
                        <ul class="navbar-list registration">
                            <li class="nav-item user-avatar__item-menu flex">
                                <p class="user-name" style="color:white;margin-right:1rem">{{user.name}}</p>
                                <span class="nav-link user-avatar__link"><img @click="dropDownToggler" :src="user.full_uri_avatar" class="user-avatar" alt="user-avatar"></span>
                                <div class="user-dropdown__menu" v-bind:class="{ 'active': dropDown }">
                                    <ul>
                                        <li @click="dropDownAndMobileNavToggler"><router-link to="/admin/users" class="user-link__balance"><img src="assets/img/logo.png" alt="logo" /> My profile</router-link></li>
                                        <li @click="dropDownAndMobileNavToggler"><router-link to="/my-collection">My Collection</router-link></li>
                                        <li @click="logout"><router-link to="/">Sign out</router-link></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-collapse__button-close">
                        <img
                            src="assets/img/button-close.svg"
                            class="button-close"
                            alt="-button-close"
                            @click="mobileNavToggler"
                        />
                    </div>
                </div>
                <img src="assets/img/nav-icon.svg" class="nav-icon" alt="..." @click="mobileNavToggler" />
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'AdminUpHeader',
    data() {
        return {
            isMobile: false,
            dropDown: false
        }
    },
    computed: {
        user() {
            return this.$store.getters['users/getCurrentUser']
        }
    },
    methods: {
        mobileNavToggler() {
            this.isMobile = !this.isMobile
        },
        dropDownToggler() {
            this.dropDown = !this.dropDown
        },
        dropDownAndMobileNavToggler() {
            this.isMobile = !this.isMobile
            this.dropDown = !this.dropDown
        },
        logout() {
            this.$store.dispatch('users/logout')
            this.user = {}
        }
    }
}
</script>
