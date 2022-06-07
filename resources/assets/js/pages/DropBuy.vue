<template>
  <div>
    <main class="drop-full__screen-wrapper count">
      <div class="container">
        <div class="drop-count__container">
          <div class="drop-count-wrapper">
            <div class="drop-count__logo-block">
              <img src="assets/img/logo.png" class="img-logo" alt="logo" />
              <img
                  src="assets/img/beatokenTextLogo.svg"
                  class="text-logo"
                  alt="text-logo"
              />
            </div>
            <div class="drop-count__title-block">
              <h3>{{ drop.name }}</h3>
              <p class="pack-sale" v-if="drop.nfts"><span>{{drop.nfts.length}}</span>total items for sale</p>
              <p class="pack-desc">
                {{ drop.short_description }}
              </p>
            </div>
            <div class="drop-count__count-block">
              <img
                  :src="drop.full_uri"
                  alt="drop-img"
              />
              <p style="color:white;margin-bottom:1rem;text-align:center">Great! Now you can buy. You have only 20 minutes to complete purchase. Hurry up! Click "Buy now" button.</p>
              <div class="event-timer__block">
                <div class="timer">
                  {{ displayTime }}
                </div>
              </div>
              <div class="col-12 flex flex-around" style="flex-direction:column">
                <button
                    class="buy-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#select-buy"
                    v-if="canBuy && isDropActive">
                  Buy now
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <div class="section-border"></div>

    <buy-nft :price="drop.price" />

  </div>
</template>

<script>
import BuyNft from "./components/modals/BuyNft.vue";
import moment from "moment";

export default {
  name: 'drop-buy',
  components: {BuyNft},
  data() {
    return {
      drop: {},
      canBuy: false,
      timeToBuy: 0,
      timer: null,
      displayTime: '',
    }
  },
  beforeCreate() {
    this.$loader(true)
    this.$store.dispatch('drop_lines/myTimeToBuyDrop', this.$route.params.drop_id)
        .then((resp) => {
          setTimeout(() => {this.$loader(false)},1000)

          if (resp.redirectToLine) this.$router.push('/drop-line/' + this.$route.params.drop_id)
          if (resp.redirectToDrop) this.$router.push('/drop/' + this.$route.params.drop_id)

          this.dropLine = resp.dropLine
          this.timeToBuy = resp.timeToBuy
          this.startTimer()
        })
  },
  created() {
    this.getDrop()
  },
  watch: {
    timeToBuy(time) {
      if (time <= 0) {
        this.stopTimer()
      }
    }
  },
  computed: {
    user() {
      return this.$store.getters['users/getCurrentUser']
    }
  },
  methods: {
    startTimer() {
      this.canBuy = true
      this.timer = setInterval(() => {
        if (this.$route.name != 'dropBuy') clearTimeout(this.timer)
        this.timeToBuy--

        let minutes = parseInt(this.timeToBuy / 60, 10)
        let seconds = parseInt(this.timeToBuy % 60, 10)

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        this.displayTime = `${minutes}min  ${seconds}sec`;
      }, 1000)
    },
    stopTimer() {
      this.canBuy = false
      this.$store.dispatch('drop_lines/deleteByDrop', this.$route.params.drop_id)
      this.$router.push('/drops')
      return false;
    },
    getDrop() {
      this.$store.dispatch('drops/showDrop', this.$route.params.drop_id)
          .then((drop) => {
            this.drop = drop

            if (!this.isDropActive()) this.$router.push('/drop/' + this.$route.params.drop_id)

            if (this.timeToBuy > 0) this.mountpaypalbutton()
          }).catch(() => this.$router.push('/drops'))
    },
    isDropActive() {
      if (this.drop && this.drop.nfts && this.drop.nfts.length &&
          this.drop.user_id != this.user.id && moment(this.drop.release_end + 'Z').utc().isAfter(moment().utc().format())) return true
      return false
    },
    mountpaypalbutton() {
      var drop = this.drop
      var user = this.user
      var router = this.$router
      var store = this.$store
      var notify = this.$notify
      var url = '/my-collection'

      paypal
          .Buttons({
            style: {
              shape: "pill",
              color: "blue",
              layout: "vertical",
              label: "paypal",
              size: "medium",
              tagline: 'false'
            },
            onApprove: async function(data, actions) {
              return actions.order.capture().then(function(orderData) {
                store.dispatch('drops/buy', {drop_id: drop.id, order: orderData})
                    .then(() => {
                      if (drop.nfts[0].collection_id) { url = url + '#collections' }
                      router.push(url)
                      $('#select-buy').modal('hide')
                      notify({title: 'Purchase was successful', type: 'success'});
                    })
                    .catch((e) => {
                      if (e.data.message) { notify({title: e.data.message, type: 'error'})
                      } else { notify({title: 'Payment verification error. Something went wrong', type: 'error'}) }
                    })
              });
            },
            onError: function (err) {
              console.log('err', err)
              notify({title: 'A payment error has occurred', type: 'error'});
            },
            createOrder: function(data, actions) {
              return actions.order.create({
                payer: {
                  name: {
                    given_name: user.first_name,
                    surname: user.last_name
                  },
                  address: {
                    address_line_1: user.address,
                    address_line_2: user.city,
                    admin_area_2: user.city,
                    admin_area_1: user.city,
                    postal_code: user.zip,
                    country_code: user.country_code
                  },
                  email_address: user.email,
                  phone: { phone_type: "MOBILE", phone_number: { national_number: user.cell_cc + user.cell_number }}
                },
                shipping_type: 'PICKUP',
                application_context: { shipping_preference: 'NO_SHIPPING' },
                purchase_units: [{ amount: { value: drop.price } }]
              });
            }
          }).render("#paypal-button-container");
    }
  }
}
</script>

<style scoped>
.buy-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 40px;
    margin-bottom: 11px;
    color: #fff;
    background-color: #1C70DE;
    transition: all 0.2s;
    border-radius: 20px;
    cursor: pointer;
    border: unset;
}
.buy-btn:hover {
    background-color: #E5E7EB;
    color: #141416;
}
</style>
