<template>
    <div class="admin-nav">
        <ul class="admin-nav__list">
            <li class="admin-nav__item" v-for="route in routes"><router-link :to="route.to" v-html="route.title"></router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'admin-nav',
    props: ['routes']
}
</script>
