<template>
    <div>
        <div class="user-data-change">
            <div class="user-change__form-block">
                <div>
                    <div class="mb-3">
                        <label for="inputLastName" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="inputLastName"
                            aria-describedby="lastNamelHelp"
                            v-model="user.name"
                            maxlength="21"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail"
                            aria-describedby="emailHelp"
                            v-model="user.email"
                            disabled
                        />
                    </div>

                    <div class="mb-3">
                        <label for="userRole" class="form-label">User role</label>

                        <select v-model="user.role_id" id="userRole" class="form-control" style="background-image:url(/images/icon-down-rounded.svg?d881643…);background-repeat:no-repeat;background-position:right 0.75rem center">
                            <option v-for="(role, i) in roles" :value="role.id">{{ role.name }}</option>
                        </select>
                    </div>

                    <button @click="updateUser" class="submit-btn">Save changes</button>
                </div>
            </div>
            <div class="user-reset__block">
                <button
                    class="reset-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#reset-password"
                >
                    Reset password
                </button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'EditUser',
    data() {
        return {}
    },
    computed: {
        roles() {
            return this.$store.getters['roles/getRoles']
        },
        user() {
            return this.$store.getters['users/getUser']
        }
    },
    methods: {
        updateUser() {
            this.$store.dispatch('users/update', this.user)
        }
    }
}
</script>
