<template>
  <div>
    <div class="header-drop">
      <div class="how-to-action drop">
        <div class="how-toBg"></div>
        <h3 class="visually-hidden">Highlighted Drops</h3>
        <div class="container">
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
    </div>

    <section class="section-open-packs">
      <h3 class="visually-hidden">Open packs to find exciting new moments</h3>
      <div class="container">
        <h2 class="section-drop-title">
          Open packs to find exciting new moments
        </h2>
        <div class="open-packs__container">
          <div class="row">
            <div class="open-packs__block item col-lg-4">
              <h3>When do new drops happen?</h3>
              <p>
                During our Beta, drop times will vary, so make
                sure you watch for announcements.
              </p>
            </div>
            <div class="open-packs__block col-lg-4">
              <h3>Where are drop announcements?</h3>
              <p>
                Sign up via email and recieve our newsletter to never miss a
                drop
              </p>
            </div>
            <div class="open-packs__block col-lg-4">
              <h3>What about sold out packs?</h3>
              <p>
                You can still find collectibles from the packs in the
                <a href="https://my.beatoken.com/marketplace">Marketplace</a> from other collectors
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-packs">
      <h3 class="visually-hidden">Packs</h3>
      <div class="container">
        <div class="previous-packs">
          <div class="packs-title">
            <h3 class="section-drop-title">Previous packs</h3>
            <p>
              These packs have been flying off the shelves. But, don’t worry,
              you can start hunting for specific Moments on the marketplace
              now!
            </p>
          </div>
          <ul class="packs-list previous-list">
            <li class="pack-item">
              <div class="img-pack">
                <img
                    src="https://beatoken.com/wp-content/themes/beatoken/core/img/drop_platinum_pack.png"
                    width="197"
                    height="192"
                    alt="pack-img"
                />
              </div>

              <h3 class="pack-title">B.O.C X COZY RUGZ</h3>
              <span class="pack-set">DROP 1 PLATINUM PACK</span>
              <p class="pack-price">350 <span>kr.</span></p>
              <p class="pack-quantity sold">58 <span>sold out</span></p>
            </li>
            <li class="pack-item">
              <div class="img-pack">
                <img
                    src="https://beatoken.com/wp-content/themes/beatoken/core/img/drop_holo_pack.png"
                    width="197"
                    height="192"
                    alt="pack-img"
                />
              </div>

              <h3 class="pack-title">BETA TEST DROP</h3>
              <span class="pack-set">Drop 0</span>
              <p class="pack-price">250 <span>kr.</span></p>
              <p class="pack-quantity sold">10 <span>sold out</span></p>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <div class="section-border"></div>
  </div>
</template>

<script>
export default {
  name: 'drops',
  data() {
    return {
      active: {},
      expired: {}
    }
  },
  created() {
    this.getHighlitedDrops()
  },
  methods: {
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
@media screen and (max-width: 590px) {
  .set h3 {
    font-size: 30px;
  }
  .set-two .set-two__img .set-img {
    max-width: unset;
  }
}
</style>
