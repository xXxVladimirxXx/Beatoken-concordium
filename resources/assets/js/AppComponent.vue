<template>
    <div>
        <Loader v-if="loader"/>

        <router-view></router-view>

        <notifications position="top center" :speed="2400"/>
    </div>
</template>

<script>
import Loader from './pages/components/Loader';

export default {
    components: {Loader},
    computed: {
        loader() {
            return this.$store.getters['general/loader']
        }
    },
}
</script>
