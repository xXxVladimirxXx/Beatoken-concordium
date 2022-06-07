<template>
    <div>
        <div class="collection-wrapper">
            <div class="container">
                <div class="collection-container">
                    <aside>
                        <div class="aside-user">
                            <div class="user-avatar__block">
                                <img :src="user.full_uri_avatar" alt="user-avatar" />
                            </div>
                            <div class="user-data__block">
                                <div class="user-edit__container">
                                    <div class="user-info">
                                        <p class="user-name">{{ user.name }}</p>
                                    </div>
                                    <div class="user-edit__btn-block">
                                        <router-link to="/edit-profile" class="edit-btn">Edit profile</router-link>
                                        <template v-if="user.role.name != 'user'">
                                            <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#create-nft">Create NFT</a>
                                            <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#create-collection"
                                               style="text-align:center;height:50px">Create Collection</a>
                                            <a class="edit-btn"
                                               v-if="isShowNotForSale && !singleCollection.id && isActive('single-nfts')"
                                               v-bind:class="{active: modSale}"
                                               @click="modSale=!modSale">Create drop</a>
                                            <a class="edit-btn"
                                               data-bs-toggle="modal" data-bs-target="#createDrop"
                                               style="text-align:center;height:50px"
                                               v-if="isShowNotForSale && singleCollection.id">Create drop by collection</a>
                                        </template>
                                    </div>
                                    <div class="user-share__block">
                                        <a :href="user.twitter_url" target="_blank"> <i class="icon-twitter"></i></a>
                                        <a :href="user.instagram_url" target="_blank"> <i class="icon-instagram"></i></a>
                                        <a :href="user.facebook_url" target="_blank"><i class="icon-facebook-circled"></i></a>
                                        <a :href="user.facebook_url" target="_blank"><i class="icon-share"></i></a>
                                    </div>
                                </div>
                                <p class="member-date">
                                    Member since
                                    <span>{{ user.created_at | formatDate }}</span>
                                </p>
                            </div>
                        </div>
                    </aside>

                    <main class="main-profile">
                        <div style="margin-top:3rem">
                            <ul class="nav nav-tabs">
                                <a class="nav-link" @click="setActive('single-nfts'); singleCollection = {}" :class="{ active: isActive('single-nfts') }">Single nfts</a>
                                <a class="nav-link" @click="setActive('collections')" :class="{ active: isActive('collections') }">Collections</a>
                            </ul>
                            <div class="sort-container__profile">
                                <div class="main-sort__block">
                                    <div class="type-packs__block" v-if="!singleCollection.id">
                                        <button
                                            class="btn type-change"
                                            @click="showNotForSale()"
                                            v-bind:class="{active: isShowNotForSale}">Not for sale</button>
                                        <button
                                            class="btn type-change"
                                            @click="showForSale()"
                                            v-bind:class="{active: isShowForSale}">For sale</button>
                                        <button
                                            v-if="user.role.name != 'user'"
                                            class="btn type-change"
                                            @click="showInDrop()"
                                            v-bind:class="{active: isShowInDrop}">In Drop</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" :class="{ 'active show': isActive('single-nfts') }" id="single-nfts">
                                    <p style="color:white;margin-bottom:1rem">Here you can see your all NFTs, which are not belongs to any collections.</p>

                                    <div class="music-card__container">
                                        <ul class="music-card__list" v-bind:class="{'active-mod-sale': modSale && isShowNotForSale}" v-if="nfts.length">
                                            <li class="music-card__item for-sale"
                                                :key="i"
                                                v-for="(item, i) in nfts"
                                                v-if="item.metadata != null">
                                                <div class="music-desc__block">
                                                    <router-link :to="'/nft/' + item.id">
                                                        <span class="for-sale__mark" v-if="item.price">For sale</span>
                                                        <span class="for-sale__mark" v-if="item.drop" style="color:#1C70DE;border-color:#1C70DE">In drop</span>
                                                        <div class="music-img" style="text-align:center">
                                                            <img :src="item.metadata.cover_image" width="197" onerror="this.hidden=true"/>
                                                        </div>
                                                        <div class="music-title">
                                                            <p class="item-music__title">{{item.metadata.name}}</p>
                                                        </div>
                                                        <p class="item-music__tariff-plan" v-if="item.type">
                                                            {{ item.type.attribute_value }}
                                                            <span v-if="item.numbering">{{ item.numbering.attribute_value }}</span>
                                                            <span class="plan-icon">{{ item.type.attribute_value.charAt(0) }}</span>
                                                        </p>
                                                        <template v-if="item.price">
                                                          <p class="sale-status">Price</p>
                                                          <p class="item-music__price">{{ Number(parseFloat(Number(item.price) + (item.price / 100 * commission_nft))).toFixed(2) }}kr.</p>
                                                        </template>
                                                    </router-link>
                                                </div>
                                                <div class="flex flex-center" style="margin-top:0.5rem" v-if="modSale && isShowNotForSale && !item.drop_id">
                                                    <button class="btn btn-sm btn-success" v-if="!idNftsForDrop.includes(item.id)" @click="idNftsForDrop.push(item.id)">Select to drop</button>
                                                    <button class="btn btn-sm btn-danger" v-else @click="idNftsForDrop.splice(idNftsForDrop.indexOf(item.id),1)">X</button>
                                                </div>
                                                <div class="flex-center">
                                                    <small v-if="modSale && isShowNotForSale && item.drop_id">Already in the drop</small>
                                                </div>
                                            </li>
                                        </ul>
                                        <h3 v-else style="color:white">No items found</h3>
                                        <div class="flex flex-center" v-if="modSale && isShowNotForSale">
                                            <button v-bind:disabled="!idNftsForDrop.length" style="margin-bottom:4rem" data-bs-toggle="modal" data-bs-target="#createDrop" class="btn btn-success refill-btn">
                                                CREATE DROP
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" :class="{ 'active show': isActive('collections') }" id="collections">
                                    <p style="color:white;margin-bottom:1rem">Here you can see your NFT grouped by collections. You have to open collection so that you can see your NFT inside.</p>

                                    <div class="music-card__container" v-if="collections.length && !singleCollection.id">
                                        <ul class="music-card__list">
                                            <li class="music-card__item for-sale" v-for="(item, i) in collections" :key="i">
                                                <div class="music-desc__block" @click="showCollectionByTab(item.id)">
                                                      <div class="music-img" style="text-align:center">
                                                          <img :src="item.full_uri_cover" width="197" onerror="this.hidden=true"/>
                                                      </div>
                                                      <div class="music-title">
                                                          <p class="item-music__title">Collection: {{item.name}}</p>
                                                      </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <h3 v-if="!collections.length" style="color:white">No items found</h3>
                                    <div class="music-card__container" v-if="singleCollection.id">
                                        <div class="back-to-pack__section">
                                            <div class="container">
                                                <div class="back-to-pack__block line">
                                                      <a @click="singleCollection = {}" class="back-to-pack__link"><i class="icon-arrow-left"></i>Back</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pack-details__container">
                                            <div class="pack-collectible__block">
                                                <h3 class="desk-title">
                                                  {{singleCollection.name}}
                                                  <small v-if="singleCollection.nfts">- {{singleCollection.nfts.length}} items</small>
                                                </h3>
                                            </div>
                                        </div>

                                        <ul class="music-card__list">
                                          <li class="music-card__item for-sale"
                                              :key="i"
                                              v-for="(item, i) in singleCollection.nfts"
                                              v-if="item.metadata != null">
                                            <div class="music-desc__block">
                                              <router-link :to="'/nft/' + item.id">
                                                <span class="for-sale__mark" v-if="item.price">For sale</span>
                                                <span class="for-sale__mark" v-if="item.drop" style="color:#1C70DE;border-color:#1C70DE">In drop</span>
                                                <div class="music-img" style="text-align:center">
                                                  <img :src="item.metadata.cover_image" width="197" onerror="this.hidden=true"/>
                                                </div>
                                                <div class="music-title">
                                                  <p class="item-music__title">{{item.metadata.name}}</p>
                                                </div>
                                                <p class="item-music__tariff-plan" v-if="item.type">
                                                  {{ item.type.attribute_value }}
                                                  <span v-if="item.numbering">{{ item.numbering.attribute_value }}</span>
                                                  <span class="plan-icon">{{ item.type.attribute_value.charAt(0) }}</span>
                                                </p>
                                                <template v-if="item.price">
                                                  <p class="sale-status">Price</p>
                                                  <p class="item-music__price">{{ Number(parseFloat(item.price)).toFixed(2) }}kr.</p>
                                                </template>
                                              </router-link>
                                            </div>
                                          </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </main>
                </div>
            </div>
            <div class="section-border"></div>
        </div>

        <create-nft @showNotForSale="showNotForSale" />
        <create-drop v-if="idNftsForDrop.length" :id-nfts-for-drop="idNftsForDrop" @showNotForSale="showNotForSale" />
        <create-collection @showNotForSale="showNotForSale" />

    </div>
</template>

<script>
import moment from "moment";
import Editor from '@tinymce/tinymce-vue';
import CreateNft from './components/modals/CreateNft';
import CreateDrop from './components/modals/CreateDrop';
import CreateCollection from './components/modals/CreateCollection';
import { parseMetaAttributes } from '../mixins/nfts'

export default {
    name: 'my-collection',
    components: {Editor, CreateNft, CreateDrop, CreateCollection},
    data() {
        return {
            idNftsForDrop: [],

            isShowNotForSale: true,
            isShowForSale: false,
            isShowInDrop: false,

            nfts: [1],
            collections: [],

            singleCollection: {},

            activeItem: 'single-nfts',
            modSale: false,
            commission_nft: '',
        }
    },
    created() {
        this.getCommission()
        this.$store.dispatch('users/getCurrentUser')
            .then(() => {
                if (this.$route.hash == '#collections') { this.setActive('collections'); return false; }

                this.showNotForSale()
            })
    },
    filters: {
        formatDate(date) {
            return moment(date).format('MMM DD, YYYY')
        },
        formatPrice(price) {
            if(price && '00' == price.split(".")[1]) return price.split(".")[0]
            return price
        }
    },
    computed: {
        user() {
            return this.$store.getters['users/getCurrentUser']
        }
    },
    methods: {
        isActive (menuItem) { return this.activeItem === menuItem },
        setActive (menuItem) { this.activeItem = menuItem; this.showNotForSale() },
        resetVariables() { this.$loader(true); this.isShowNotForSale = false; this.isShowForSale = false; this.isShowInDrop = false; this.modSale = false; this.singleCollection = {} },
        showNotForSale() {
            this.resetVariables(); this.isShowNotForSale = true
            if (this.isActive('single-nfts')) { this.getNftsNotForSale() } else { this.getCollectionsNotForSale() }
        },
        showForSale() {
            this.resetVariables(); this.isShowForSale = true
            if (this.isActive('single-nfts')) { this.getNftsForSale() } else { this.getCollectionsForSale() }
        },
        showInDrop() {
            this.resetVariables(); this.isShowInDrop = true
            if (this.isActive('single-nfts')) { this.getNftsInDrop() } else { this.getCollectionsInDrop() }
        },
        getNftsNotForSale() {
            this.$store.dispatch('nfts/getNftsNotForSale')
                .then(res => { this.nfts = res; this.$loader(false) })
        },
        getNftsForSale() {
            this.$store.dispatch('nfts/getNftsForSale')
                .then(res => { this.nfts = res; this.$loader(false) })
        },
        getNftsInDrop() {
            this.$store.dispatch('nfts/getNftsInDrop')
                .then(res => { this.nfts = res; this.$loader(false) })
        },
        getCollectionsNotForSale() {
            this.$store.dispatch('collections/getCollectionsNotForSale')
                .then(res => { this.collections = res; this.$loader(false) })
        },
        getCollectionsForSale() {
            this.$store.dispatch('collections/getCollectionsForSale')
                .then(res => { this.collections = res; this.$loader(false) })
        },
        getCollectionsInDrop() {
            this.$store.dispatch('collections/getCollectionsInDrop')
                .then(res => { this.collections = res; this.$loader(false) })
        },
        getCommission() {
          this.$store.dispatch('settings/allSettings')
              .then(settings => { this.commission_nft = settings.fee_marketplace })
        },
        showCollectionByTab(collection_id) {
            this.$loader(true)
            this.$store.dispatch('collections/showCollectionByTab', {
              collection_id: collection_id,
              notForSale: this.isShowNotForSale,
              forSale: this.isShowForSale,
              inDrop: this.isShowInDrop
            }).then(res => {
                this.singleCollection = res;

                this.idNftsForDrop = [];
                this.singleCollection.nfts.map(nft => {
                  if (nft.price) nft.price = Number(parseFloat(Number(nft.price) + (nft.price / 100 * this.commission_nft))).toFixed(2)
                  parseMetaAttributes(nft);
                  this.idNftsForDrop.push(nft.id)
                })
                this.$loader(false)
              })
        }
    }
}
</script>
<style scoped>
hr {
    margin-top: 2rem
}
.music-card__list {
    transition: all 1s;
}
.user-edit__btn-block a.active {
    background-color: #198754
}
.active-mod-sale {
    border: 1px solid #3fbc6c;
    padding: .5rem;
    border-radius: 1rem;
}
ul.nav-tabs {
    width: 100%;
    display: flex;
    justify-content: space-between;
}
a.nav-link {
    width: 50%;
    text-align: center;
    cursor: pointer;
    color: gainsboro;
}
.sort-container__profile {
    padding-top: 25px;
}
.back-to-pack__block {
    margin-bottom: 1rem;
    cursor: pointer;
}
.back-to-pack__link {
  color: gainsboro;
}
.icon-arrow-left {
    margin-right: 1rem;
}
.music-card__item {
  cursor: pointer;
}
@media screen and (max-width: 992px) {
  .tab-content {
    width: 100%;
  }
}

</style>