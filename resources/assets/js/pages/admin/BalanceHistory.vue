<template>
  <div>
    <h3 class="admin-table__title">User’s transactions history</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th scope="col">Description</th>
        <th scope="col">Amount</th>
        <th scope="col">Type</th>
        <th scope="col">Date</th>
        <th scope="col">PayPal OrderId</th>
        <th scope="col">Details</th>
      </tr>
      </thead>
      <tbody>
      <template v-for="transactionHistory in transactionsHistory">
        <tr v-bind:class="{'out': transactionHistory.type == 'Out', 'in': transactionHistory.type == 'In'}">
          <td>{{ transactionHistory.description }}</td>
          <td>{{ transactionHistory.amount }}</td>
          <td>{{ transactionHistory.type }}</td>
          <td>{{ transactionHistory.date | formatDate }}</td>
          <td>{{ transactionHistory.orderId }}</td>
          <td>{{ transactionHistory.details }}</td>
        </tr>
      </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: 'BalanceHistory',
  data() {
    return {
      transactionsHistory: []
    }
  },
  created() {
    this.getTransactionsHistoryByUserId()
  },
  filters: {
    formatDate(date) {
      return moment(date).format("DD.MM.yy hh:mm:ss")
    }
  },
  methods: {
    getTransactionsHistoryByUserId() {
      this.$store.dispatch('transactions_history/getTransactionsHistoryByUserId', this.$route.params.user_id)
          .then(transactionsHistory => {
            this.transactionsHistory = transactionsHistory
          })
    }
  }
}
</script>