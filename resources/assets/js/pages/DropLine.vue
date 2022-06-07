<template>
  <div>
    <main class="drop-full__screen-wrapper count">
      <div class="container">
        <div class="drop-count__container">
          <div class="drop-count-wrapper" v-if="timeToStartBuy">
            <div class="drop-count__logo-block">
              <img src="assets/img/logo.png" class="img-logo" alt="logo" />
              <img
                  src="assets/img/beatokenTextLogo.svg"
                  class="text-logo"
                  alt="text-logo"
              />
            </div>
            <div class="drop-count__title-block">
              <h3>YOU ARE NOW IN LINE</h3>
              <p class="pack-desc">
                You are in line for {{drop.name}} ({{drop.release_name}})<br> When
                it is your turn, you will have 20 mintunes to complete the
                order. When its your turn, it takes up to 1 min to re-direct you
                to complete the order.
              </p>
            </div>
            <div class="drop-count__count-block">
              <p class="user-in-line">Your queue number: {{myDropLineIndex}}</p>
              <h2 style="color:white" v-if="displayTime">{{displayTime}}</h2>
              <p class="status-update">
                The queue number is updated once a minute
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
<script>
import moment from "moment";

export default {
  name: 'drop-line',
  data() {
    return {
      drop: {},
      dropLine: {},
      myDropLineIndex: 0,
      timeToStartBuy: 0,
      displayTime: '',
      timer: null,
      queryEveryMinute: null
    }
  },
  beforeCreate() {
    this.$loader(true)
    this.$store.dispatch('drop_lines/myTimeToStartBuyDrop', this.$route.params.drop_id)
        .then((resp) => {
          setTimeout(() => this.$loader(false),1000)

          this.handlingResp(resp);

          this.startTimer()
          this.startQueryEveryMinute()
        })
  },
  created() {
    this.getDrop()
  },
  watch: {
    timeToStartBuy(time) {
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
      this.timer = setInterval(() => {
        if (this.$route.name != 'dropLine') clearTimeout(this.timer)
        this.timeToStartBuy--

        let minutes = parseInt(this.timeToStartBuy / 60, 10)
        let seconds = parseInt(this.timeToStartBuy % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        this.displayTime = `${minutes}min  ${seconds}sec`;
      }, 1000)
    },
    startQueryEveryMinute() {
      this.queryEveryMinute = setInterval(() => {
        if (this.$route.name != 'dropLine') clearTimeout(this.queryEveryMinute)
        this.$store.dispatch('drop_lines/myTimeToStartBuyDrop', this.$route.params.drop_id)
            .then((resp) => this.handlingResp(resp))
      }, 60000)
    },
    stopTimer() {
      this.$router.push('/drop-buy/' + this.drop.id)
    },
    handlingResp(resp) {
      if (resp.redirectToBuy) this.$router.push('/drop-buy/' + this.$route.params.drop_id)
      if (resp.redirectToDrop) this.$router.push('/drop/' + this.$route.params.drop_id)

      if (resp.dropLine && resp.dropLine.drop) {
        this.drop = resp.dropLine.drop;
        if (!this.isDropActive()) this.$router.push('/drop/' + this.$route.params.drop_id)
      }

      this.dropLine = resp.dropLine
      this.timeToStartBuy = resp.timeToStartBuy
      this.myDropLineIndex = resp.myDropLineIndex
    },
    getDrop() {
      this.$store.dispatch('drops/showDrop', this.$route.params.drop_id)
          .then((drop) => {
            this.drop = drop
            if (!this.isDropActive()) this.$router.push('/drop/' + this.$route.params.drop_id)
          }).catch(() => this.$router.push('/drops'))
    },
    isDropActive() {
      if (this.drop && this.drop.nfts && this.drop.nfts.length &&
          this.drop.user_id != this.user.id && moment(this.drop.release_end + 'Z').utc().isAfter(moment().utc().format())) return true
      return false
    },
  }
}
</script>
