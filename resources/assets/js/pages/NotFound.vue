<template>
    <section class="section-start-collection">
        <h3 class="visually-hidden">Error 404</h3>

        <div class="container">
            <div class="start-block">
                <div class="start-txt__block">
                    <div class="start-txt">
                        <h2 class="section-title">Error 404</h2>
                        <p>
                            Page not found
                        </p>

                    </div>
                    <div class="start-button__block">
                        <router-link class="sign-up" to="/">Homepage</router-link>
                        <router-link class="login" to="/login" v-if="!user.id">Login</router-link>
                    </div>
                </div>
                <div class="start-img__block">
                    <img src="https://beatoken.com/wp-content/themes/beatoken/core/img/start-img-block.png" alt="">
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    computed: {
        user() {
            return this.$store.getters['users/getCurrentUser']
        }
    },
}
</script>
