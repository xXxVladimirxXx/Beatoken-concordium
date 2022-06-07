<template>
    <div>
        <admin-up-header/>

        <div class="container">
            <div class="admin-wrapper">

                <!-- nav -->
                <admin-nav :routes="routes"/>

                <div class="admin-main">

                    <!-- header -->
                    <admin-nft-header :user="currentUser" :nft-count-items="nftCountItems"/>

                    <main>
                        <router-view></router-view>
                    </main>
                </div>
            </div>
        </div>

        <modal-create-nft :user="currentUser" />
    </div>
</template>

<script>

import AdminNav from '../AdminNav'
import AdminUpHeader from '../AdminUpHeader'
import AdminNftHeader from './AdminNftHeader'
import ModalCreateNft from '../../admin-modals/ModalCreateNft'

export default {
    name: 'AdminUserMain',
    components: {
        AdminNav,
        AdminUpHeader,
        AdminNftHeader,
        ModalCreateNft,
    },
    data() {
        return {
            routes: [],
            nftCountItems: 0
        }
    },
    created() {
        this.getCurrentUser()
            .then((user) => {
              console.log(user)
                this.nftCountItems = user.nfts.length

                this.routes = [
                    {to: '/admin/users/', title: '<i class="icon-arrow-left"></i>'},
                    {to: '/admin/nfts/all-nfts', title: 'All NFT'},
                    {to: '/admin/nfts/settings', title: 'Settings'},
                ]
            })
    },
    computed: {
        currentUser() {
            return this.$store.getters['users/getCurrentUser']
        }
    },
    methods: {
        getCurrentUser() {
            return this.$store.dispatch('users/getCurrentUser')
        }
    }
}
</script>
