<template>
  <!-- MODAL create drop -->
  <div
      class="modal fade"
      id="createDrop"
      tabindex="-1"
      aria-labelledby="prizeModalLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="prizeModalLabel">Create Drop</h5>
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
          <div class="create-pack__mod" style="width:100%">
            <div class="packs-title" style="width:100%">
              <div class="flex-center">
                <div class="cover-block__img-nft">
                  <div class="cover-img__nft flex-center" style="color:white" v-if="drop.cover_image != {}">
                    {{ drop.cover_image.name }}
                  </div>
                  <label for="drop_cover" class="upload-btn">Select drop cover</label>
                  <!-- <label>{{drop.cover_image.name}}</label> -->
                  <input style="display:none" type="file" @change="processCoverForDropCreate($event)" id="drop_cover" accept="image/*">
                </div>
              </div>

              <div class="" style="color:#fff">

                <div class="create-nft__block">
                  <div class="inputs-nft__block">
                    <label>* Name</label>
                    <input type="text" name="name" class="" v-model="drop.name" required>
                  </div>

                  <div class="inputs-nft__block">
                    <label>* Release</label>
                    <input type="text" name="release_name" class="" v-model="drop.release_name" required>
                  </div>
                </div>

                <div class="create-nft__block">
                  <div class="flex flex-between" style="margin-bottom:3rem;">
                    <p>Your current local time: {{ this.currentTime }} (GMT {{utcDiff}})</p>
                    <select class="timezones" v-model="timezone" style="width:30%;">
                      <option value="Europe/Kiev">Europe/Kiev</option>
                      <option value="Europe/Copenhagen">Europe/Copenhagen</option>
                    </select>
                  </div>

                  <div class="inputs-nft__block">
                    <label>* Release start <small>(GMT {{utcDiff}})</small></label>
                    <input type="datetime-local" name="release_start" class="" v-model="drop.release_start">
                  </div>

                  <div class="inputs-nft__block">
                    <label>* Release end <small>(GMT {{utcDiff}})</small></label>
                    <input type="datetime-local" name="release_end" class="" v-model="drop.release_end">
                  </div>
                </div>

                <div class="create-nft__block">
                  <div class="inputs-nft__block">
                    <label>* Price</label>

                    <div style="width:70%;display:flex;">
                      <select class="currency" v-model="currency">
                        <option value="dollar">$</option>
                        <option value="euro">Є</option>
                        <option value="DKK">DKK</option>
                      </select>
                      <money placeholder="Enter price" v-model="drop.price" style="width:82%" />
                    </div>
                  </div>
                  <p style="margin-bottom:2rem;text-align:end" v-if="currency == 'dollar'">
                    Your price {{ Number(parseFloat(drop.price)).toFixed(2) }}$ = {{ Number(parseFloat(drop.price * settings.currency_rate_dollar_dkk)).toFixed(2) }} DKK.
                    Users will see price in DKK
                  </p>
                  <p style="margin-bottom:2rem;text-align:end" v-if="currency == 'euro'">
                    Your price {{ Number(parseFloat(drop.price)).toFixed(2) }}Є = {{ Number(parseFloat(drop.price * settings.currency_rate_euro_dkk)).toFixed(2) }} DKK.
                    Users will see price in DKK
                  </p>
                  <p style="margin-bottom:2rem;text-align:end" v-if="currency == 'DKK'">
                    Your price {{Number(parseFloat(drop.price)).toFixed(2) }} DKK. Users will see price in DKK
                  </p>

                  <div class="inputs-nft__block">
                    <label>* Short description</label>
                    <input type="text" name="short_description" class="" v-model="drop.short_description" required>
                  </div>
                </div>

                <div class="create-nft__block">
                  <div class="inputs-nft__block textarea">
                    <label>* Full description</label>
                    <editor api-key="opijpx5o6t6quvytqu19j23b2utwobnpm23j0whxstbztpm3" :init="tinymce" v-model="drop.full_description"></editor>
                  </div>
                </div>

                <div class="create-nft__block">
                  <div class="inputs-nft__block">
                    <label>Video url</label>
                    <input type="text" name="video_url" class="" v-model="drop.video_url">
                  </div>

                  <div class="inputs-nft__block">
                    <label>* Number nfts</label>
                    <input type="number" name="number_nfts" step="1" min="1" max="100" class="f" v-model="drop.number_nfts">
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 flex-center">
                    <button @click="createDrop" v-bind:disabled="
                        !drop.cover_image.name || drop.name == '' || drop.release_name == '' ||
                        drop.release_start == '' || drop.release_end == '' || drop.price == '' ||
                        drop.short_description == '' || drop.full_description == '' || drop.number_nfts == ''"
                            class="upload-btn" style="margin-bottom:20px">Create drop</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import momentTz from "moment-timezone";
import Editor from "@tinymce/tinymce-vue";

export default {
    props: {
        idNftsForDrop: {
            type: Array,
            required: true
        }
    },
    name: 'my-collection',
    components: {Editor},
    data() {
        return {
            drop: {
                name: '',
                release_name: '',
                release_start: '',
                release_end: '',
                price: '1,00',
                cover_image: {},
                short_description: '',
                full_description: '',
                video_url: '',
                number_nfts: '',
                status: 'active',
                utc_user: '',
                idNftsForDrop: this.idNftsForDrop
            },

            tinymce:  {
                plugins: [
                    "code fullscreen",
                ],
                relative_urls: false,
                min_height: 350,
                convert_urls: false,
            },
            settings: {},
            utcDiff: '',
            timezone: 'Europe/Kiev',
            currentTime: '',
            interval: null,
            currency: 'dollar'
        }
    },
    destroyed(){
        clearInterval(this.interval)
    },
    created() {
        this.getAllSettings()

        this.interval = setInterval(() => {
            this.currentTime = moment().tz(this.timezone).format('HH:mm');
            this.parseUtcInfo()
        }, 1000)
    },
    methods: {
        processCoverForDropCreate(e) { this.drop.cover_image = e.target.files[0] },
        parseUtcInfo() {
            var utcDiff = momentTz.tz(this.timezone).utcOffset()
            this.drop.utc_user = utcDiff

            let hours = parseInt(Math.abs(utcDiff) / 60, 10)
            let minutes = parseInt(Math.abs(utcDiff) % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;

            if (utcDiff > 0) { this.utcDiff = `${hours}:${minutes}`; } else { this.utcDiff = `-${hours}:${minutes}`; }
        },
        getAllSettings() {
            this.$store.dispatch('settings/allSettings')
                .then(settings => {
                    this.settings = settings
                })
        },
        createDrop() {
            this.$loader(true)

            if (this.currency == 'dollar') this.drop.price = Number(parseFloat(this.drop.price * this.settings.currency_rate_dollar_dkk)).toFixed(2)
            if (this.currency == 'euro') this.drop.price = Number(parseFloat(this.drop.price * this.settings.currency_rate_euro_dkk)).toFixed(2)

            var release_start = momentTz.tz(this.drop.release_start, this.timezone);
            this.drop.release_start = moment.utc(release_start).format()
            var release_end = momentTz.tz(this.drop.release_end, this.timezone);
            this.drop.release_end = moment.utc(release_end).format()
            this.drop.utc_user = '0'

            const formData = new FormData()
            if (this.drop.name) formData.append('name', this.drop.name)
            if (this.drop.release_name) formData.append('release_name', this.drop.release_name)
            if (this.drop.release_start) formData.append('release_start', this.drop.release_start)
            if (this.drop.release_end) formData.append('release_end', this.drop.release_end)
            if (this.drop.price) formData.append('price', this.drop.price)
            if (this.drop.cover_image) formData.append('cover_image', this.drop.cover_image)
            if (this.drop.short_description) formData.append('short_description', this.drop.short_description)
            if (this.drop.full_description) formData.append('full_description', this.drop.full_description)
            if (this.drop.video_url) formData.append('video_url', this.drop.video_url)
            if (this.drop.number_nfts) formData.append('number_nfts', this.drop.number_nfts)
            if (this.drop.status) formData.append('status', this.drop.status)
            if (this.drop.utc_user) formData.append('utc_user', this.drop.utc_user)
            if (this.drop.idNftsForDrop) formData.append('idNftsForDrop', JSON.stringify(this.drop.idNftsForDrop))

            this.$store.dispatch('drops/storeDrop', formData)
                .then(() => {
                    this.$emit('showNotForSale')

                    this.$loader(false)
                    this.$notify({title: 'Your drop has been successfully created', type: 'success'});
                    $('#createDrop').modal('hide')
                    this.drop = {name: '', release_name: '', release_start: '', release_end: '', price: '', cover_image: {name:''}, short_description: '', full_description: '', video_url: '', number_nfts: '', idNftsForDrop: []};
                }).catch(() => {this.$loader(false); this.$notify({title: 'Server error. Please try again later', type: 'error'}) })
        }
    }
}
</script>

<style scoped>
select.currency, select.timezones {
    width: 16%;
    align-self: flex-end;
    padding: 9px 0 11px 6px;
    font-family: "Shapiro 55 Middle";
    font-size: 0.875rem;
    color: #fff;
    background-color: #272B33;
    border: 1px solid #353945;
    border-radius: 20px;
    margin-right: 2%;
}
</style>