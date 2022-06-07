<template>

  <!-- //////////////////// -->
  <!-- MODAL BUY NFT -->
  <!-- //////////////////// -->
  <div
      class="modal fade"
      id="select-buy"
      tabindex="-1"
      aria-labelledby="select-buyModalLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content modal-content__select-buy">
        <div class="modal-header modal-header__select-buy">
          <h5 class="modal-title" id="select-buyModalLabel">Payment methods</h5>
          <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
          >
            <i class="icon-btn-close"></i>
          </button>
        </div>
        <div class="modal-body" style="align-items:unset">
          <ul class="buy-list">
            <li class="buy-item" style="justify-content:space-between">
              <p class="buy-id">Credit card</p>
              <p><span>{{ price }}<span>kr.</span></span></p>
            </li>
          </ul>

          <div id="paypal-button-container"></div>
        </div>
        <div class="modal-footer modal-footer__modal-footer-buy">
          <p class="sub-title">
            <small @click="reload()">Don’t see pay button? Click Refresh page</small><br>
            <small>If you have problems with payment, please contact our support service.</small>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'create-nft',
  props: ['price'],
  methods: {
    reload () {
      window.location.reload()
    }
  }
}
</script>

<style scoped>
#paypal-button-container {
  display: flex;
  background: white;
  align-items: center;
  justify-content: center;
  padding: 20px;
  border-radius: 20px;
}
#select-buy .modal-content {
  color: black;
  background-color: white;
}
#select-buy .buy-list .buy-item {
  background-color: #e6e6e6;
}
#select-buy .btn-close {
  color: black;
}
.modal-footer {
  display: unset;
}
@media screen and (max-width: 590px) {
  .modal-header .modal-title {
    display: none;
  }
}
</style>