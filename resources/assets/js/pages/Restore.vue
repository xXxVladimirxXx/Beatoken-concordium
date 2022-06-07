<template>
    <div class="enter-container">
        <div class="enter-main" style="width:52%">
            <div class="enter-block">
                <div class="enter-block__body">
                    <h3 class="enter-title" style="margin-top:3rem">Resend password</h3>
                    <form @submit="restore">
                        <div>
                            <label for="email">Email</label>
                            <input v-model="email" type="email" name="email" id="email" class="form-control input-black" required />
                        </div>
                        <hr>
                        <div class="flex flex-center">
                            <button class="btn btn-primary" :disabled="email.length < 5" style="border-radius:20px;font-size:20px">Resend</button>
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
            email: ''
        }
    },
    methods: {
        restore(e) {
            this.$loader(true)
            e.preventDefault();

            this.$store.dispatch('users/forgotPassword', this.email)
                .then((res) => {
                    this.$loader(false)
                    this.$notify({ title: res.message, type: 'success'});
                    this.$router.push('/reset-pass?email=' + this.email)
                }).catch((err) => {
                    this.$loader(false)
                    this.$notify({ title: err.message, type: 'error'});
                })
        }
    }
}
</script>
