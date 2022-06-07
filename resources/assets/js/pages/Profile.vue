<template>
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
          <div class="music-card__container">
            <div class="empty-collection">
              <div>
                <p class="balance-container__title">Wallet</p>
                <div class="balance-container">
                  <div class="balance-block__input" style="justify-content:unset">
                    <p class="balance-title" style="width:unset;margin-right:1rem">Balance:</p>
                    <div class="my-balance__block" style="width:unset">
                      <p class="my-balance">{{ user.balance | formatBalance }}</p>
                    </div>
<!--                    <div class="btn-balance__block">-->
<!--                      <button class="btn-balance" data-bs-toggle="modal" data-bs-target="#modal-withdrawal-balance">Withdrawal</button>-->
<!--                    </div>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>


      <div>
        <h2 class="section-drop-title">Highlighted Drop</h2>
        <div class="sets-block">
          <div class="set set-one" v-if="active && active.id">
            <div class="bg-txt"></div>
            <div class="set-block">
              <div class="set-one__txt">
                <span class="set-state">Now available</span>

                <h3>
                  {{ active.name }}
                  <span>(Drop 1)</span>
                </h3>

                <p class="common">Common | Contains <span>{{active.number_nfts}}</span> cards</p>
              </div>
              <div class="set-one__img">
                <router-link :to="'/drop/' + active.id" >
                  <img
                      :src="active.full_uri"
                      class="set-img"
                      width="180"
                      height="180"
                      alt="set-img"
                  />
                </router-link>
              </div>
            </div>
            <p class="price">Price:
              {{ Number(parseFloat(active.price)).toFixed(2) }}
              <span>kr</span>
            </p>
          </div>
          <div class="set set-one not-current-drop" v-else>
            <div class="bg-txt"></div>
            <div class="set-block">
              <h3>OUR NEXT<br>
                EVENT TO BE<br>
                ANNOUNCED!</h3>
            </div>
          </div>

          <div class="set set-two">
            <div class="bg-txt"></div>

            <div class="set-block" v-if="expired && expired.id">
              <div class="set-two__txt">
                <span class="set-state">Sold out</span>
                <h3>
                  {{ expired.name }}
                  <span>(Drop 2)</span>
                </h3>
                <p>Common gold</p>
                <p class="common">Contains <span>{{expired.number_nfts}}</span> cards</p>
              </div>
              <div class="set-two__img" style="width:50%">
                <router-link :to="'/drop/' + expired.id" >
                  <img
                      :src="expired.full_uri"
                      class="set-img"
                      width="180"
                      height="180"
                      alt="set-img"
                  />
                </router-link>
              </div>
            </div>
            <p class="price" v-if="expired && expired.id">Price:
              {{ Number(parseFloat(expired.price)).toFixed(2) }}
              <span>kr</span>
            </p>
          </div>
        </div>
      </div>

    </div>
    <div class="section-border"></div>

    <create-nft />
    <create-collection />
  </div>
</template>

<script>
import moment from "moment";
import CreateNft from "./components/modals/CreateNft";
import CreateCollection from "./components/modals/CreateCollection";
// import Withdrawal from "./components/modals/Withdrawal";

export default {
  name: 'Profile',
  components: {CreateNft, CreateCollection},
  data() {
    return {
      active: {},
      expired: {},
    }
  },
  created() {
    this.getProfileData()
    this.getHighlitedDrops()
  },
  filters: {
    formatDate(date) {
      return moment(date).format('MMM DD, YYYY')
    },
    formatBalance(balance) {
      if (!balance) balance = 0
      balance = parseFloat(balance).toFixed(2)
      return balance + ' kr.'
    }
  },
  computed: {
    user() {
      return this.$store.getters['users/getCurrentUser']
    }
  },
  methods: {
    getProfileData() {
      return this.$store.dispatch('users/getCurrentUser')
    },
    getHighlitedDrops() {
      this.$store.dispatch('drops/getHighlitedDrops')
          .then((drops) => {
            this.active = drops.active
            this.expired = drops.expired
          })
    },
  }
}
</script>

<style scoped>
.not-current-drop h3 {
  z-index: 9;
}
.music-card__container .empty-collection {
  margin-bottom: unset;
}
.section-drop-title, .sets-block {
  margin-bottom: 50px;
}
@media screen and (max-width: 590px) {
  .set h3 {
    font-size: 30px;
  }
  .set-two .set-two__img .set-img {
    max-width: unset;
  }
}
</style>
