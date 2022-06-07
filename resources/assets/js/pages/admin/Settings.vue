<template>
    <div>
        <h3 class="admin-table__title">Nft settings</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Description</th>
                <th scope="col">Value</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Commission percentage when buying</td>
                    <td class="flex-center">
                        <div>Drop: <input v-model="form.fee_drop" min="0" class="form-control" type="number"/></div>
                        <div>Marketplace: <input v-model="form.fee_marketplace" min="0" class="form-control" type="number"/></div>
                    </td>
                </tr>
                <tr>
                    <td>Dollar to DKK currency rate</td>
                    <td><input v-model="form.currency_rate_dollar_dkk" min="0" class="form-control" type="number"/></td>
                </tr>
                <tr>
                    <td>Euro to DKK currency rate</td>
                    <td><input v-model="form.currency_rate_euro_dkk" min="0" class="form-control" type="number"/></td>
                </tr>
                <tr>
                    <td>The waiting time for the line and the time that is given for the purchase of a token</td>
                    <td class="flex-center">
                        <div>Time line (sec) <input v-model="form.default_time_drop_line" min="0" class="form-control" type="number"/></div>
                        <div>Buy drop (sec) <input v-model="form.default_time_drop_payment" min="0" class="form-control" type="number"/></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex flex-center">
            <button @click="saveSettings" class="btn btn-success"><h3>Save</h3></button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Settings',
    data() {
        return {
            form: {
                fee_drop: '',
                fee_marketplace: '',
                currency_rate_dollar_dkk: '',
                currency_rate_euro_dkk: '',
                default_time_drop_line: '',
                default_time_drop_payment: ''
            }
        }
    },
    created() {
        this.allSettings()
    },
    methods: {
        allSettings() {
            this.$store.dispatch('settings/allSettings')
                .then(settings => {
                    this.form = settings
                })
        },
        saveSettings() {
            this.$store.dispatch('settings/addSettings', this.form)
                .then(settings => {
                    this.form = settings
                })
        }
    }
}
</script>
