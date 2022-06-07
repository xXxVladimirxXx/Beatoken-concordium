<template>
    <div class="enter-container">
        <div class="enter-main" >
            <div class="enter-block">
                <div class="enter-block__body">
                    <h3 class="enter-title" style="margin-top:3rem">Login account</h3>
                    <form @submit="login">
                        <div>
                            <label for="email">Email</label>
                            <input v-model="user.email" type="email" name="email" id="email" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div>
                            <label for="password">Password</label>
                            <input v-model="user.password" type="password" name="password" id="password" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div class="flex flex-center">
                            <button class="btn btn-primary" style="border-radius:20px;font-size:20px">Login</button>
                        </div>
                    </form>

                    <router-link to="/signup" class="already-have" style="margin-top:40px">No account yet? Sign up</router-link>
                    <router-link to="/resend" class="already-have">Forgot password?</router-link>

                    <p class="terms-privacy">
                        By signing in, you acknowledge that you have read and
                        agree all applicable <a href="#">Terms of Service</a> and our
                        <a href="#">Privacy Policy</a>
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
                password: ''
            }
        }
    },
    methods: {
        login(event) {
            event.preventDefault();

            this.$store.dispatch('users/login', this.user).then((res) => {
                window.location.href = "/";
            }).catch(e => {
                if (400 == e.status) {
                    var title = 'You have not entered your login details'
                } else {
                    var title = 'Server error. Please try again later'
                }
                this.$notify({ title, type: 'error'});
            })
        }
    }
}
</script>
