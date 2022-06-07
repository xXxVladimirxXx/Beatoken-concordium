<template>
    <div>
        <h3 class="admin-table__title">User's NFT collection</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Cover img</th>
                <th scope="col">Price</th>
                <th scope="col">On sale</th>
            </tr>
            </thead>
            <tbody>
                <tr v-if="nfts.length && item.metadata" v-for="(item, i) in nfts">
                    <td class="table-nft__img">
                        <img
                            :src="item.metadata.cover_image"
                             onerror="this.hidden=true"/>

                        <video
                            :src="item.metadata.cover_image"
                            muted
                            autoplay
                            width="100"
                            height="100"
                            onerror="this.hidden=true"/>
                    </td>
                    <td>
                        {{ item.price ? item.price + ' tokens' : 'Not for sale' }}
                    </td>
                    <td><p>{{ item.price ? 'Yes' : 'No' }}</p></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'UserNft',
    data() {
        return {
            nfts: [],
            user: {},
        }
    },
    created() {
        this.getUser(this.$route.params.user_id)
    },
    methods: {
        allNftsByUserId() {
            this.$store.dispatch('nfts/allNftsByUserId', this.$route.params.user_id)
                .then(nfts => {
                    console.log('nfts', nfts)
                    this.nfts = nfts
                })
        },
        getUser(user_id) {
            this.$store.dispatch('users/getUser', user_id)
                .then(user => {
                    this.user = user
                    this.allNftsByUserId()
                })
        }
    }
}
</script>
