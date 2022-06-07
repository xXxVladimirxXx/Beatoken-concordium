<template>
    <div class="enter-container">
        <div class="enter-main" style="width:52%">
            <div class="enter-block">
                <div class="enter-block__body">
                    <h3 class="enter-title" style="margin-top:3rem">Reset password</h3>
                    <form @submit="changePasswordWhenForgot">
                        <div>
                            <label for="password">Code</label>
                            <input class="form-control input-black code" type="text" name="code" v-model="code" maxlength="4">
                        </div>
                        <div>
                            <label for="password">New password</label>
                            <input v-model="form.new_password" type="password" name="password" id="password" class="form-control input-black" required />
                        </div>
                        <div style="margin-top:1rem">
                            <label for="password">Confirm password</label>
                            <input v-model="form.confirmPass" type="password" name="confirmPass" id="confirmPass" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div class="flex flex-center">
                            <button
                                    type="submit"
                                    class="btn btn-primary"
                                    v-bind:disabled="code.length != 4 || ((form.new_password == '' || form.confirmPass == '') || form.new_password != form.confirmPass)"
                                    style="border-radius:20px;font-size:20px">
                                Save password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="section-border"></div>
        <img class="how-toBg" src="assets/img/how-to-action_BG.png" alt="bg-img" />
    </div>
</template>

<script>
export default {
    data() {
        return  {
            code: '',
            email: '',
            form: {
                new_password: '',
                confirmPass: ''
            },
            isPasswordConfirm: false // Label that checks password confirm
        }
    },
    created() {
        this.email = this.$route.query.email
    },
    methods: {
        changePasswordWhenForgot(e) {
            e.preventDefault();

            if(this.confirmPassword()) {
                this.$store.dispatch('users/changePasswordWhenForgot', {email: this.email, code: this.code, password: this.form.new_password})
                    .then(() => {
                        this.$router.push('/')
                        this.$notify({ title: 'Password reset', type: 'success'});
                    }).catch(() => {
                        this.$notify({ title: 'Invalid code specified. Send again', type: 'error'});
                        this.$router.push('/resend')
                    })
            }
        },
        confirmPassword() {
            if (this.form.new_password === this.form.confirmPass) {
                return this.isPasswordConfirm = true
            } else {
                return this.isPasswordConfirm = false
            }
        }
    }
}
</script>

<style scoped>
.code {
    text-align: center;
    font-size: 35px;
    padding: unset;
    font-family: unset
}
</style>
