<template>
    <div>
        <div class="admin-main__nav">
            <div class="user-data__block">
                <div class="user-data__avatar">
                    <img :src="user.full_uri_avatar" alt="user-avatar" />
                </div>
                <div class="user-data">
                    <div class="user-data__txt">
                        <p>{{user.name}}</p>
                        <p>{{user.email}}</p>
                    </div>

                </div>
            </div>
            <div class="user-nft__block">
                <p v-if="nftCountItems" class="nft-sum">NFT:<span>{{nftCountItems}}</span>items</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AdminUserHeader',
    props: {
        user: {
            type: Object,
            required: false
        },
        nftCountItems: {
            type: Number,
            required: false
        }
    }
}
</script>
