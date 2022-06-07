<template>
  <div>
    <div class="drop-main__container">
      <div class="container">
        <div class="drop-main__wrapper">
          <div class="drop-main__header">
            <div class="drop-header__img-block">
              <img
                  :src="drop.full_uri"
                  width="409"
                  height="465"
                  alt="pack-img"
              />
            </div>
            <div class="drop-main__aside">
              <div class="aside-title__block">
                <span class="set-state border-gradient-purple" v-if="isDropActive()">Now on sale</span>
                <span class="set-state border-gradient-purple" v-else>Sold out</span>
                <h2 class="aside-pack__title">{{drop.name}} DROP 1</h2>
                <p class="total-for-sale">
                  <span v-if="isDropActive()">{{drop.nfts.length}} total items for sale</span>
                  <span v-else>0 total items for sale</span>
                </p>
                <p class="pack-desc">
                  {{drop.short_description}}
                </p>
              </div>
              <div class="aside-count__block">
                <div class="pack-sum">
                  <p>1 pack with {{drop.number_nfts}} items</p>
                </div>

                <p class="pack-price">
                  {{ Number(parseFloat(drop.price)).toFixed(2) }}
                  <span>kr</span>
                </p>
                <div class="join-button flex-center" v-if="isDropActive()" @click="joinDrop">Join drop</div>
              </div>
              <div class="aside-logo__block">
                <img src="assets/img/logo.png" width="42" height="42" alt="" />
                <div class="logo-txt">
                  <span>Sold by</span>
                  <p>Beatoken</p>
                </div>
              </div>
            </div>
          </div>
          <div class="drop-details__block">
            <p class="details-block__title">Pack details</p>
            <div class="details-desc__block">
              <p v-html="drop.full_description"></p>
            </div>
          </div>
          <!-- <div class="drop-main__details"></div> -->
        </div>
      </div>
    </div>
    <div class="section-border"></div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: 'drop',
  data() {
    return {
      drop: {}
    }
  },
  created() {
    this.getDrop()
  },
  filters: {
    currentDate() {
      return moment().format('DD.MM.YYYY')
    },
    formatPrice(price) {
      if(price && '00' == price.split(".")[1]) return price.split(".")[0]
      return price
    }
  },
  mounted() {
    this.sliderFor = this.$refs.sliderFor
    this.sliderNav = this.$refs.sliderNav
  },
  computed: {
    user() {
      return this.$store.getters['users/getCurrentUser']
    }
  },
  methods: {
    getDrop() {
      this.$store.dispatch('drops/showDrop', this.$route.params.drop_id)
          .then((drop) => {
            this.drop = drop
          }).catch(() => this.$router.push('/drops'))
    },
    isDropActive() {
      if (this.drop && this.drop.nfts && this.drop.nfts.length &&
          this.drop.user_id != this.user.id && moment(this.drop.release_end + 'Z').utc().isAfter(moment().utc().format())) return true
      return false
    },
    joinDrop() {
      this.$store.dispatch('drop_lines/storeDropLineByDrop', this.drop.id)
          .then((resp) => {
            if (resp.redirectToDrops) { this.$notify({title: 'Drop is no longer for sale', type: 'warning'}); this.$router.push('/drops'); return false }
            if (resp.redirectToBuy) { this.$router.push('/drop-buy/' + this.drop.id); return false }
            this.$router.push('/drop-line/' + this.drop.id)
          })
    }
  }
}
</script>

<style scoped>
  .join-button {
    cursor: pointer;
  }
</style>
