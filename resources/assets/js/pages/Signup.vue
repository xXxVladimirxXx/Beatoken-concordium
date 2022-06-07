<template>
    <div class="enter-container">
        <div class="enter-main">
            <div class="enter-block">
                <div class="enter-block__body">
                    <h3 class="enter-title" style="margin-top:3rem">Create account</h3>

                    <form @submit="register">
                        <div>
                            <label for="email">Email</label>
                            <input v-model="user.email" type="email" name="email" id="email" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div>
                            <label for="email">Display name</label>
                            <input v-model="user.name" type="text" name="name" id="name" class="form-control input-black" maxlength="21" required />
                        </div>
                        <hr>
                        <div>
                            <label for="password">Password</label>
                            <input v-model="user.password" type="password" name="password" id="password" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div class="flex-center">
                          <input type="checkbox" name="accept_terms" id="accept_terms" class="input-black" required />
                          <label for="accept_terms" style="margin-left:5px;font-size:85%">I have read and agree to the <a href="https://beatoken.com/terms-condition" target="_blank">terms & conditions</a></label>
                        </div>
                        <hr>
                        <div class="flex flex-center">
                            <button class="btn btn-primary" style="border-radius:20px;font-size:20px">Register</button>
                        </div>
                    </form>
                    <router-link to="/login" class="already-have" style="margin-top:40px">Already have an account? Sign in</router-link>

                    <p class="terms-privacy">
                        By signing up, you acknowledge that you have read and
                        agree all applicable <a href="https://beatoken.com/terms-condition/">Terms of Service</a> and our
                        <a href="https://beatoken.com/terms-condition/">Privacy Policy</a>
                    </p>
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
            user: {
                email: '',
                name: '',
                password: ''
            }
        }
    },
    methods: {
        register(e) {
            this.$loader(true)
            e.preventDefault();

            this.$store.dispatch('users/register', this.user)
                .then(() => {
                    this.$loader(false)
                    this.$router.push('verification')
                }).catch(e => {
                    if (400 == e.status) {
                        var title = 'The email you are trying to register has already been created'
                    } else {
                        var title = 'Server error. Please try again later'
                    }
                    this.$loader(false)
                    this.$notify({ title, type: 'error'});
                })
        }
    }
}
</script>
