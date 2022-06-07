<template>
  <div class="enter-container">
    <div class="enter-main">
      <div class="enter-block" style="width:77%">
        <div class="enter-block__body">
          <h3 class="enter-title" style="margin-top:3rem;text-align:center">Fill User Info</h3>

          <p style="text-align:center;color:#4f3f71">You need to update your account information</p><br>
          <p style="text-align:center;color:#4f3f71">Please provide real information. Otherwise, there may be problems with payment.</p>
          <hr>

          <form @submit="save">
            <div class="flex flex-between">
              <div class="flex flex-column">
                <label for="first_name">First name</label>
                <the-mask mask="LLLLLLLLLLLLLLLLLLLLLLLLL" :tokens="letters" v-model="user.first_name"
                          type="text" name="first_name" id="first_name" class="form-control input-black" required></the-mask>
              </div>
              <div class="flex flex-column">
                <label for="last_name">Last name</label>
                <the-mask mask="LLLLLLLLLLLLLLLLLLLLLLLLL" :tokens="letters" v-model="user.last_name"
                          type="text" name="last_name" id="last_name" class="form-control input-black" required></the-mask>
              </div>
            </div>
            <hr>

            <div class="flex flex-between">
              <div class="flex flex-column" style="width:50%">
                <label for="country_code">Country</label>
                <country-select name="country_code" v-model="user.country_code" topCountry="DK" class="form-control input-black" required style="background-image:url(/images/icon-down-rounded.svg?d881643…);background-repeat:no-repeat;background-position:right 0.3rem center;background-size:1.3rem" />

                <!-- <input v-model="user.country_code" type="text" name="country" id="country" class="form-control input-black" required />-->
              </div>
              <div class="flex flex-column">
                <label for="city">City</label>
                <input v-model="user.city" type="text" name="city" id="city" class="form-control input-black" required />
              </div>
            </div>
            <hr>

            <div class="flex flex-between">
              <div class="flex flex-column">
                <label for="address">Address</label>
                <input v-model="user.address" type="text" name="address" id="address" maxlength="30" class="form-control input-black" required />
              </div>
              <div class="flex flex-column">
                <label for="address">Zip</label>
                <the-mask mask="NNNNNNN" :tokens="numbers" v-model="user.zip"
                          type="text" name="zip" id="zip" class="form-control input-black" required></the-mask>
              </div>
            </div>
            <hr>

            <div class="flex flex-column">
              <label for="phone">Phone</label>
              <VuePhoneNumberInput id="phone" style="width:100%" default-country-code="DK" required v-model="user.phone" @update="updatePhone"></VuePhoneNumberInput>
            </div>
            <hr>
            <div class="flex flex-center">
              <button class="btn btn-primary" style="border-radius:20px;font-size:20px">Save</button>
            </div>
          </form>
          <hr>
          <p class="terms-privacy" style="text-align:center">Not your mail? <a @click="logout()" style="cursor:pointer">Logout</a></p>
        </div>
      </div>
    </div>
    <div class="section-border"></div>
    <img class="how-toBg" src="assets/img/how-to-action_BG.png" alt="bg-img" />
  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask'
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

export default {
  name: 'fill-user-info',
  components: {TheMask, VuePhoneNumberInput},
  data() {
    return {
      letters: {L: { pattern: /[a-zA-Z' ÆæØøÅå]/ }},
      numbers: {N: { pattern: /[0-9]/ }}
    }
  },
  created() {
    this.$loader(false)
    return this.$store.dispatch('users/getCurrentUser')
        .then((user) => {
          if (!user.email_verified_at) this.$router.push('/verification')

          if (user.first_name && user.last_name && user.country_code &&
              user.city && user.address && user.zip && user.cell_cc && user.cell_number) {
            this.$router.push('/')
          }
        })
  },
  computed: {
    user() {
      return this.$store.getters['users/getCurrentUser']
    }
  },
  methods: {
    updatePhone(payload) {
      this.user.cell_cc = payload.countryCallingCode
      this.user.cell_number = payload.nationalNumber
    },
    save(e) {
      e.preventDefault();

      if (this.user.cell_number.length < 5) { this.$notify({title: 'Phone number must be more than 5 characters', type: 'error'}); return false; }
      if (this.user.cell_number.length > 21) { this.$notify({title: 'Phone number must be no more than 21 characters', type: 'error'}); return false; }

      delete this.user.twitter_url
      delete this.user.facebook_url
      delete this.user.instagram_url
      this.$store.dispatch('users/editProfile', this.user)
          .then(() => { this.$router.push('/') })
    },
    logout() {
      this.$store.dispatch('users/logout')
    }
  }
}
</script>

<style scoped>
.input-black {
  padding: 4px 16px 4px 16px;
}
.input-black:invalid {
  border: 2px dashed gray;
}
.flex .input-black {
  width: 95%;
}
@media screen and (max-width: 590px) {
  .enter-block {
    width: 100% !important;
  }
  .flex-between {
    flex-direction: column;
  }
  .flex-between .flex-column {
    width: 100% !important;
    margin-bottom: 1rem;
  }
  .flex .input-black {
    width: 100%
  }
  .enter-container {
    overflow: unset;
    justify-content: unset;
  }
}
</style>
