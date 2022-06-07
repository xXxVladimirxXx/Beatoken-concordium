<template>
  <div>
    <div class="container">
      <div class="pack-view__container">
        <div class="pack-carousel__block">
          <div class="carousel-pack" v-if="nft.metadata">
            <VueSlickCarousel
                ref="sliderFor"
                :asNavFor="sliderNav"
                :slidesToShow="1"
                :slidesToScroll="1"
                :arrows="false"
                :fade="true"
                :focusOnSelect="true"
                class="slider-for">

                  <!-- first item -->
                  <div class="pack1">
                    <img :src="nft.metadata.cover_image"/>
                  </div>

                  <!-- second item -->
                  <div class="pack1" v-if="nft.metadata.cover_video">
                    <video
                        :src="nft.metadata.cover_video"
                        preload=""
                        controls
                        width="100%"
                    />
                  </div>

                  <!-- third item -->
                  <div class="pack1" v-if="nft.extension_file != 'mp3'">
                    <img
                        v-if="nft.extension_file == 'jpeg' || nft.extension_file == 'jpg'"
                        :src="nft.metadata.source_file"
                    />
                    <video
                        v-if="nft.extension_file == 'mp4'"
                        :src="nft.metadata.source_file"
                        preload=""
                        controls
                        width="100%"
                    />
                  </div>
                  <div class="pack1" v-if="nft.extension_file == 'mp3'">
                    <div class="flex flex-center">
                      <img :src="nft.metadata.cover_image">
                      <img src="/assets/img/audio.svg" class="audio-icon" style="position:absolute">
                    </div>
                  </div>

                  <!-- fourth element -->
                  <div class="pack1" v-if="nft.metadata.attachment_file">
                    <img :src="nft.metadata.attachment_file"/>
                  </div>
            </VueSlickCarousel>

            <VueSlickCarousel
                ref="sliderNav"
                :asNavFor="sliderFor"
                :slidesToShow="3"
                :slidesToScroll="1"
                :dots="false"
                :arrows="true"
                :centerMode="false"
                :focusOnSelect="true"
                class="slider-nav">

                  <!-- first item -->
                  <div class="pack2">
                    <img :src="nft.metadata.cover_image"/>
                  </div>

                  <!-- second item -->
                  <div class="pack2" v-if="nft.metadata.cover_video">
                    <video
                        :src="nft.metadata.cover_video"
                        muted
                        preload=""
                        width="106"
                        height="106"
                    />
                    <img src="/assets/img/play.svg" class="video-icon-2">
                  </div>

                  <!-- third item -->
                  <div class="pack2" v-if="nft.extension_file != 'mp3'">
                    <img
                        v-if="nft.extension_file == 'jpeg' || nft.extension_file == 'jpg'"
                        :src="nft.metadata.source_file"
                    />

                    <video
                        v-if="nft.extension_file == 'mp4'"
                        :src="nft.metadata.source_file"
                        muted
                        preload=""
                        width="106"
                        height="106"
                    />
                    <img v-if="nft.extension_file == 'mp4'"
                         src="/assets/img/play.svg" class="video-icon-2">
                  </div>
                  <div class="pack2" v-if="nft.extension_file == 'mp3'" @click="setTrack()">
                      <img src="/assets/img/audio.svg" class="audio-icon-2">
                  </div>

                  <!-- fourth element -->
                  <div class="pack2" v-if="nft.metadata.attachment_file">
                    <img :src="nft.metadata.attachment_file"/>
                  </div>
            </VueSlickCarousel>
          </div>
        </div>
        <div class="pack-top__block">
          <div class="artist-desk" style="position:relative">
            <span class="not-synchronised">Not synchronised</span><br><br>
            <small style="top:35px;position:absolute">Will be synchronised by next release.</small>
            <p class="artist-name" v-if="nft.metadata">{{ nft.metadata.name }}</p>
          </div>
          <div class="tariff-plan__block" v-if="nft.type">
            <p class="tariff-plan tariff-plan__card-view">
              {{ nft.type.attribute_value }} <span class="plan-icon">{{ nft.type.attribute_value.charAt(0) }}</span>
            </p>
          </div>
        </div>

        <div class="pack-bottom__block" v-if="!isCurrentUserOwner">
          <div class="price-rate__block" v-if="nft.price">
            <div class="lowest-ask__block">
              <p class="price-title">Price</p>
              <p class="price">{{ Number(parseFloat(nft.price)).toFixed(2) }}kr.</p>
            </div>
          </div>
          <div class="options-btn__block">
            <button
                class="button-clime-prize"
                data-bs-toggle="modal"
                data-bs-target="#select-buy"
            >
              Buy now
            </button>
            <button>Share</button>
          </div>
          <div class="creator__block">
            <div class="creator-artist" v-if="nft.user">
              <img v-if="nft.user.full_uri_avatar" :src="nft.user.full_uri_avatar" alt="logo" />
              <div class="txt">
                <span>Owner</span>
                <p>{{ nft.user.name }}</p>
              </div>
            </div>
            <div class="creator-certified">
              <img src="assets/img/logo.png" alt="logo" />
              <div class="txt">
                <span>Certified by</span>
                <p>BEATOKEN</p>
              </div>
            </div>
          </div>
        </div>

        <div class="pack-bottom__block" v-else>
          <div class="owned-block">
            <p>Owned by</p>
            <p class="owner-name" v-if="nft.user">{{ nft.user.name }} <span>(you)</span></p>
          </div>
          <div class="options-btn__block">
            <template v-if="nft.price">
              <!--<button @click="removeFromSale(nft.id)">Remove from sale</button>-->
            </template>
            <template v-else>
              <!--<button data-bs-toggle="modal" data-bs-target="#for-sale">Place for sale</button>-->
            </template>
          </div>
          <div class="creator__block">
            <div class="creator-artist" v-if="nft.user">
              <img v-if="nft.user.full_uri_avatar" :src="nft.user.full_uri_avatar" alt="logo" />
              <div class="txt">
                <span>Owner</span>
                <p>{{ nft.user.name }}</p>
              </div>
            </div>
            <div class="creator-certified">
              <img src="assets/img/logo.png" alt="logo" />
              <div class="txt">
                <span>Certified by</span>
                <p>BEATOKEN</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pack-details__container">
        <div class="pack-collectible__block">
          <h3 class="desk-title">Collectible details</h3>

          <div class="collectible-block">
            <p class="collectible-txt" v-if="nft.metadata">
              {{ nft.metadata.description }}
            </p>
          </div>

          <div class="explore-more">
            <img src="assets/img/three-block.svg" alt="block-img" />
            <p>Explore more market data on this NFT edition on
              <a href="#">Beatoken market</a>
            </p>
          </div>
        </div>
        <div class="pack-properties__block">
          <h3 class="desk-title">Properties</h3>
          <div class="properties-items">
            <div class="properties properties-artist" v-if="nft.author">
              <p>Author</p>
              <p>{{ nft.author.attribute_value }}</p>
            </div>
            <div class="properties properties-type" v-if="nft.type">
              <p>Type</p>
              <p>{{ nft.type.attribute_value }}</p>
            </div>
            <div class="properties properties-type" v-if="nft.numbering">
              <p>Numbering</p>
              <p>{{ nft.numbering.attribute_value }}</p>
            </div>
            <div class="properties properties-type" v-if="nft.attachment">
              <p>Attachment</p>
              <p>{{ nft.attachment.attribute_value }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-border"></div>

    <!-- ////////////// -->
    <!-- MODAL FOR SALE -->
    <!-- ////////////// -->
    <div
        class="modal fade"
        id="for-sale"
        tabindex="-1"
        aria-labelledby="saleModalLabel"
        aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="saleModalLabel">Sell your NFT</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            >
              <i class="icon-btn-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="for-sale__manual-block">
              <p>Place your card for sale on the marketplace.</p>
              <p>This is text for browser window after placing the NFT.</p>
              <p>Click "Cancel" if you change your mind.</p>
            </div>
            <div class="for-sale__desc-block" v-if="nft.metadata">
              <div class="img-block">
                <img
                    :src="nft.metadata.cover_image"
                    height="173"
                    alt="for-sale-img"
                />
              </div>
              <div class="desc">
                <p class="desc-name">{{nft.metadata.name}}</p>
                <div class="type-desc">
                  <p>Released <span>{{ true | currentDate }}</span></p>
                </div>

                <div class="tariff-plan" v-if="nft.type">
                  {{ nft.type.attribute_value }} <span class="plan-icon">{{ nft.type.attribute_value.charAt(0) }}</span>
                </div>
              </div>
            </div>
            <div class="for-sale__price-block" style="margin-bottom:unset">
              <money placeholder="Enter price" v-model="nftForSalePrice" />
            </div>
          </div>
          <div class="modal-footer">
            <div class="for-sale__btn-block" style="padding-bottom:20px">
              <button @click="putForSale(nft)" class="item-success">Place for sale</button>
              <!--<p>To learn more about fees, <a href="#">click here</a></p>-->
            </div>
          </div>
        </div>
      </div>
    </div>

    <buy-nft :price="nft.price" />

  </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
import moment from "moment";
import BuyNft from "./components/modals/BuyNft.vue";

export default {
  name: 'single-nft',
  components: {VueSlickCarousel, BuyNft},
  data() {
    return {
      nft: {},
      sliderFor: undefined,
      sliderNav: undefined,
      isCurrentUserOwner: false,

      nftForSalePrice: '1.00',
      commission_nft: '',
    }
  },
  created() {
    this.getCommission()
    this.showNft()
  },
  computed: {
    user() {
      return this.$store.getters['users/getCurrentUser']
    }
  },
  filters: {
    currentDate() {
      return moment().format('DD.MM.YYYY')
    }
  },
  methods: {
    getCommission() {
      this.$store.dispatch('settings/allSettings')
          .then(settings => { this.commission_nft = settings.fee_marketplace })
    },
    showNft() {
      this.$store.dispatch('nfts/showNft', this.$route.params.nft_id)
          .then((nft) => {
            if (this.user.id == nft.user_id) {
              this.isCurrentUserOwner = true
            } else if (this.user.id != nft.user_id && !nft.price) {
              this.$router.push('/marketplace')
            }

            if (nft.price) nft.price = Number(parseFloat(Number(nft.price) + (nft.price / 100 * this.commission_nft))).toFixed(2)

            this.nft = nft

            this.mountpaypalbutton(nft)

            setTimeout(() => {
              this.sliderFor = this.$refs.sliderFor
              this.sliderNav = this.$refs.sliderNav
            }, 500)
          }).catch(() => this.$router.push('/marketplace'))
    },
    setTrack() {
      var track = {};
      track.name = this.nft.metadata.name;
      if (this.nft.author && this.nft.author.attribute_value) track.artist = this.nft.author.attribute_value;
      track.cover = this.nft.metadata.cover_image;
      track.source = this.nft.metadata.source_file;

      this.$store.commit('general/setTracks', [track])
    },
    // putForSale(nft) {
    //   this.$store.dispatch('nfts/putForSale', {id: nft.id, price: Number(parseFloat(this.nftForSalePrice)).toFixed(2)})
    //       .then(() => { this.showNft(); $('#for-sale').modal('hide') })
    // },
    // removeFromSale(nft_id) {
    //   this.$store.dispatch('nfts/removeFromSale', nft_id)
    //       .then(() => { this.showNft() })
    // },
    mountpaypalbutton(nft) {
      var store = this.$store
      var notify = this.$notify
      var showNft = this.showNft
      var user = this.user

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
                store.dispatch('nfts/buy', {nft_id: nft.id, order: orderData})
                    .then(() => {
                      showNft()
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
                purchase_units: [{ amount: { value: nft.price } }]
              });
            }
          }).render("#paypal-button-container");
    }
  }
}
</script>

<style scoped>
.audio-icon, .video-icon-2 {
  position: absolute;
  opacity: 0.7;
  padding: 7rem;
}
.video-icon-2 {
  top: 0;
  opacity: 0.9;
  padding: 5%;
}
.audio-icon-2, video-icon-2 {
  width: 50% !important;
  margin-left: 20%;
}
.not-synchronised {
  font-family: "Shapiro 45 Welter Wide";
  font-size: 0.562rem;
  text-transform: uppercase;
  color: #fff;
  border-radius: 100rem;
  padding: 1px 10px 3px;
  box-shadow: 0 0 6px 0 rgb(157 96 212 / 50%);
  border: solid 3px transparent;
  background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), linear-gradient(101deg, #1c70de, #dc3b54);
  background-origin: border-box;
  background-clip: content-box, border-box;
  box-shadow: 2px 1000px 1px #23262f inset;
}
.slick-slide .pack1 {
  display: none !important;
}
.slick-current .pack1 {
  display: block !important;
  z-index: 999999 !important;
}
@media screen and (max-width: 992px) {
  .pack-details__container .pack-properties__block .properties-items {
    display: block;
  }
  .pack-details__container .pack-properties__block .properties {
    margin-right: unset;
    margin-bottom: 30px;
  }
}
</style>