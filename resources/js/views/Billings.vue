<template>
    <div class="projects">
        <div v-if="error" class="error">
            {{ error }}
        </div>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Project</th>
                <th>Klant</th>
                <th>Omschrijving</th>
                <th>Notities</th>
                <th>Uurprijs</th>
                <th>Geschatte uren</th>
                <th>Gewerkte uren</th>
                <th>Totaal</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="billing in billings" :key="billing.id">
                <billing :billing="billing"></billing>
                <!--<td><span>{{billing.id}}</span></td>-->
                <!--<td><input type="text" :value="billing.type"></td>-->
                <!--<td><input type="text" :value="billing.project_id"></td>-->
                <!--<td><input type="text" :value="billing.customer_id"></td>-->
                <!--<td><input type="text" :value="billing.description"></td>-->
                <!--<td><input type="text" :value="billing.note"></td>-->
                <!--<td><input type="number" :value="billing.hourly_rate"></td>-->
                <!--<td><input type="number" :value="billing.estimate_hours"></td>-->
                <!--<td><input type="number" :value="billing.worked_hours"></td>-->
                <!--<td><input type="number" :value="getTotalAmount(billing.id)"></td>-->
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>

    import echo from '../mixins/echo'
    import vSelect from 'vue-select'
    import Modal from '../atoms/Modal.vue'
    import Billing from '../components/Billing'

    export default {
        name: 'Billings',
        components: {
            Modal,
            vSelect,
            Billing
        },
        mixins: [echo],
        data() {
            return {
                error: '',

                projects: [],
                customers: [],
                billings:[],

            };
        },
        created() {
            this.getBillingInfo();
        },
        methods: {
            getTotalAmount(billing_id) {
                let billingIndex = this.billings.findIndex(billing => billing.id === billing_id)
                let billing = null
                if (billingIndex >= 0){
                    billing = this.billings[billingIndex];
                }
                if (billing){
                    console.log(billing.hourly_rate)
                    console.log(billing.worked_hours)
                    return billing.hourly_rate * billing.worked_hours
                }
                return 0.00;
            },
            getBillingInfo() {
                this.$http
                    .get('/api/billings')
                    .then(response => {

                        this.billings = response.data
//                        this.customers = response.data.customers
//                        this.projects = response.data.projects

                    });
            },

            getEventHandlers() {
                return {
                    'Billings\\BillingAdded': response => {
                        this.billings.push(response.billing);
                    },
                    'Billings\\BillingDeleted': response => {
                        this.billings = this.billings.filter(billing => billing.id !== response.billing_id);
                    },
                    'Billings\\BillingUpdated': response => {
                        let billingIndex = this.billings.findIndex(billing => billing.id === response.billing.id)
                        if (billingIndex >= 0){
                            this.billings[billingIndex] = response.billing;
                        }
                    },
                };
            },
            searchCustomers(query, loading) {
                loading(true)
                if (this.searchTimeout) clearTimeout(this.searchTimeout)
                let _this = this;
                this.searchTimeout = setTimeout(function() {
                    _this.$http
                        .post('api/customers/search', {
                            search_query: query,
                        })
                        .then(response => {
                            _this.customers = response.data;
                            loading(false);
                        })
                        .catch(response => loading(false))
                }, 300);
            }
        }
    }
</script>