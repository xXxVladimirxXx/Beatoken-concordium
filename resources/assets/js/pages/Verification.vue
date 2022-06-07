<template>
    <div class="enter-container">
        <div class="enter-main">
            <div class="enter-block" style="width:auto">
                <div class="enter-block__body">
                    <h3 class="enter-title" style="margin-top:3rem;text-align:center">Verification</h3>
                    <p style="text-align:center;color:#4f3f71">
                        Email verification is needed for<br>
                        additional security measures<br><br>

                        Check your email <span v-if="user.email">({{ user.email }})</span>,<br>
                        we sent you a verification code<br><br>

                        <input class="input-black code" type="text" name="code" v-model="code" maxlength="4"> <br><br>

                        <button @click="verify" :disabled="code.length != 4" class="btn btn-primary" style="border-radius:20px;font-size:25px">Verify</button>
                    </p>
                    <hr>
                    <template v-if="user.email && user != {}">
                        <p class="terms-privacy" style="text-align:center">Didn't receive a letter? <a @click="resend()" style="cursor:pointer">Send again</a></p>
                        <hr>
                        <p class="terms-privacy" style="text-align:center">Not your mail? <a @click="logout()" style="cursor:pointer">Logout</a></p>
                    </template>
                </div>
            </div>
        </div>
        <div class="section-border"></div>
        <img class="how-toBg" src="assets/img/how-to-action_BG.png" alt="bg-img" />
    </div>
</template>

<script>
export default {
    name: 'verification',
    data() {
        return {
            code: ''
        }
    },
    created() {
        return this.$store.dispatch('users/getCurrentUser')
            .then((user) => {
                if (user.email_verified_at) this.$router.push('/')
            })
    },
    computed: {
        user() {
            return this.$store.getters['users/getCurrentUser']
        }
    },
    methods: {
        verify() {
            this.$store.dispatch('users/verify', this.code)
                .then(() => {
                    this.$router.push('/')
                    this.$notify({ title: 'Email verified successfully', type: 'success'});
                }).catch(() => {
                    this.code = ''
                    this.$notify({ title: 'Invalid code specified. Send again', type: 'error'});
                })
        },
        resend() {
            this.$loader(true)
            this.$store.dispatch('users/resend')
                .then(() => {
                    this.$loader(false)
                    this.$notify({ title: 'Email verification link sent on your email', type: 'success'});
                }).catch(() => this.$loader(false))
        },
        logout() {
            this.$store.dispatch('users/logout')
        }
    }
}
</script>

<style scoped>
.code {
    text-align: center;
    font-size: 40px;
    padding: unset;
    width: 50%;
    font-family: unset
}
</style>
