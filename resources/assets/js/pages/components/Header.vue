<template>
    <nav class="navbar">
        <div class="container">
            <div class="nav-container">
   
                <a class="navbar-brand"  href="https://beatoken.com/">
                    <img src="assets/img/logo.png" class="img-logo" alt="logo" />
                    <img src="assets/img/beatokenTextLogo.svg" class="text-logo" alt="logo2"/>
                </a>

                <div class="nav-collapse" v-bind:class="{ 'nav-active': isMobile }">
                    <div class="nav-collapse__main">
                        <ul class="navbar-list main">
                            <li class="nav-item" @click="mobileNavToggler">
                                <router-link class="nav-link" aria-current="page" to="/drops">Drops</router-link>
                            </li>
                            <li class="nav-item" @click="mobileNavToggler">
                                <a class="nav-link" href="https://beatoken.com/how-it-works/">How it works</a>
                            </li>
                            <li class="nav-item my-collection" @click="mobileNavToggler" style="display:none">
                                <router-link class="nav-link" to="/my-collection">My Collection</router-link>
                            </li>
                            <li class="nav-item profile" @click="mobileNavToggler" style="display:none">
                                <router-link class="nav-link" to="/" exact>Profile</router-link>
                            </li>
                        </ul>
                        <ul class="navbar-list registration" v-if="!user.id">
                            <li class="nav-item" @click="mobileNavToggler">
                                <router-link class="nav-link" to="/create">Create</router-link>
                            </li>
                            <li class="nav-item" @click="mobileNavToggler">
                                <router-link class="nav-link" to="/login">Log in</router-link>
                            </li>
                            <li class="nav-item" @click="mobileNavToggler">
                                <router-link class="nav-link sign-up" to="/signup">Sign up</router-link>
                            </li>
                        </ul>
                        <ul class="navbar-list registration" v-else>
                            <li class="nav-item user-avatar__item-menu flex">
                                <p class="user-name" style="color:white;margin-right:1rem">{{user.name}}</p>
                                <span class="nav-link user-avatar__link"><img @click="dropDownToggler" :src="user.full_uri_avatar" class="user-avatar" alt="user-avatar"></span>
                                <div class="user-dropdown__menu" v-bind:class="{ 'active': dropDown }">
                                    <ul>
                                        <li @click="dropDownAndMobileNavToggler" v-if="user.role.name == 'superadmin'"><router-link to="/admin/users" class="user-link__balance"><img src="assets/img/logo.png" alt="logo" /> Admin profile</router-link></li>
                                        <li @click="dropDownAndMobileNavToggler" v-else><router-link to="/" class="user-link__balance"><img src="assets/img/logo.png" alt="logo" /> My profile</router-link></li>
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
        name: 'Header',
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

<style scoped>
  .user-avatar__link {
    object-fit: cover;
  }
  @media screen and (max-width: 992px) {
    .my-collection, .profile {
      display: block !important;
    }
  }
</style>