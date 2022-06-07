<template>
    <div class="collection-wrapper">
        <div class="container">
            <div class="collection-container">
                <aside>
                    <div class="aside-user">
                        <div class="user-avatar__block">
                            <img :src="user.full_uri_avatar" alt="user-avatar" />
                        </div>
                        <div class="user-data__block">
                            <div class="user-edit__container">
                                <div class="user-info">
                                    <p class="user-name">{{ user.name }}</p>
                                </div>
                                <div class="user-edit__btn-block">
                                    <label for="avatar" class="edit-btn change-avatar">Change avatar</label>
                                    <input style="display:none" type="file" @change="processAvatarCreate($event)" id="avatar" accept="image/*">
                                </div>
                                <div class="user-share__block">
                                    <a :href="user.twitter_url" target="_blank"> <i class="icon-twitter"></i></a>
                                    <a :href="user.instagram_url" target="_blank"> <i class="icon-instagram"></i></a>
                                    <a :href="user.facebook_url" target="_blank"><i class="icon-facebook-circled"></i></a>
                                </div>
                            </div>
                            <p class="member-date">
                                Member since
                                <span>{{ user.created_at | formatDate }}</span>
                            </p>
                        </div>
                    </div>
                </aside>
                <main class="main-profile">
                    <div class="edit-profile__container">
                        <ul class="nav nav-tabs">
                            <a class="nav-link" @click.prevent="setActive('personal-information')" :class="{ active: isActive('personal-information') }" href="#personal-information">Personal information</a>
                            <a class="nav-link" @click.prevent="setActive('socials')" :class="{ active: isActive('socials') }" href="#socs">Socials</a>
                            <a class="nav-link" @click.prevent="setActive('security')" :class="{ active: isActive('security') }" href="#security">Security</a>
                        </ul>

                        <div class="tab-content" id="myTabContent" style="margin-top:3rem">
                            <div class="tab-pane fade" :class="{ 'active show': isActive('personal-information') }" id="personal-information">
                                <div class="edit-profile__name-block">
                                    <div class="mb-3">
                                        <label for="nameFormControlInput" class="form-label">Enter name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nameFormControlInput"
                                            v-model="user.name"
                                            maxlength="21"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailFormControlInput" class="form-label">Your email</label>
                                        <input
                                            style="opacity:0.6"
                                            type="text"
                                            class="form-control"
                                            id="emailFormControlInput"
                                            v-model="user.email"
                                            disabled
                                        />
                                    </div>
                                    <button @click="editProfile">Save</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="{ 'active show': isActive('socials') }" id="socials">
                                <div class="edit-profile__socialmedia-block">
                                    <div class="mb-3">
                                        <label for="twFormControlInput" class="form-label">Twitter account</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="twFormControlInput"
                                            v-model="user.twitter_url"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="instFormControlInput" class="form-label">Instagram account</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="instFormControlInput"
                                            v-model="user.instagram_url"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="fbFormControlInput" class="form-label">Facebook account</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="fbFormControlInput"
                                            placeholder=""
                                            v-model="user.facebook_url"
                                        />
                                    </div>
                                    <button @click="editProfile">Save</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="{ 'active show': isActive('security') }" id="security">
                                <div class="edit-profile__password-block">
                                    <div class="mb-3">
                                        <label for="oldPasswordFormControlInput" class="form-label">Enter old password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="oldPasswordFormControlInput"
                                            v-model="oldPassword"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPasswordFormControlInput" class="form-label">Enter new password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="newPasswordFormControlInput"
                                            v-model="newPassword"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPasswordFormControlInput" class="form-label">Confirm new password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="confirmPasswordFormControlInput"
                                            v-model="confirmNewPassword"
                                        />
                                    </div>
                                    <button @click="changePassword">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="section-border"></div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: 'EditProfile',
    data() {
        return {
            activeItem: 'personal-information',

            oldPassword: '',
            newPassword: '',
            confirmNewPassword: ''
        }
    },
    created() {
        this.$store.dispatch('users/getCurrentUser')
    },
    filters: {
        formatDate(date) {
            return moment(date).format('MMM DD, YYYY')
        }
    },
    computed: {
        user() {
            return this.$store.getters['users/getCurrentUser']
        },
        flowUser() {
            return this.$store.getters['flow/getFlowUser']
        }
    },
    methods: {
        isActive (menuItem) { return this.activeItem === menuItem },
        setActive (menuItem) { this.activeItem = menuItem },
        processAvatarCreate(e) {
            const formData = new FormData()
            formData.append('avatar', e.target.files[0])

            this.$store.dispatch('users/changeAvatar', formData)
                .then(() => { this.$store.dispatch('users/getCurrentUser') })
        },
        changePassword() {
            if (!this.oldPassword || this.newPassword.length < 5 || this.confirmNewPassword < 5) { this.$notify({title: 'New password must be more than 5 characters', type: 'warn'}); return false; }
            if (this.newPassword != this.confirmNewPassword) { this.$notify({title: 'New password not confirmed', type: 'warn'} ); return false; }

            this.$store.dispatch('users/changePassword', {oldPassword: this.oldPassword, newPassword: this.newPassword})
                .then(() => {
                    this.$notify({title: 'Password changed successfully', type: 'success'})
                    this.oldPassword = ''; this.newPassword = ''; this.confirmNewPassword = '';
                }).catch((err) => {
                    if (err.status == 400) { this.$notify({title: 'Incorrect old password entered', type: 'error'}); return false; }
                })
        },
        editProfile() {
              this.$store.dispatch('users/editProfile', this.user)
                  .then(() => this.$store.dispatch('users/getCurrentUser'))
        }
    }
}
</script>

<style scoped>
.edit-profile__container {
    display: flex;
    align-items: center;
    flex-direction: column;
}
.edit-profile__name-block, .edit-profile__socialmedia-block, .edit-profile__password-block {
    text-align: center;
    width: 27vw
}
ul.nav-tabs {
    width: 100%;
    display: flex;
    justify-content: space-between;
}
a.nav-link {
    width: 33.3%;
    text-align: center;
    color: gainsboro;
}
</style>
