<template>
    <div class="customers">
        <div v-if="error" class="error">
            {{ error }}
        </div>

        <button id="show-modal" @click="showAddCustomerModal = true">Add customer</button>
        <!-- use the modal component, pass in the prop -->
        <modal v-if="showAddCustomerModal" @close="showAddCustomerModal = false">
            <h3 slot="header">Create customer</h3>
            <div slot="body">
                <label for="add_customer_name"> Customer name </label>
                <input type="text" id="add_customer_name" name="add_customer_name" v-model="customerName">
            </div>
            <div slot="footer">
                <button @click="showAddCustomerModal = false">Back</button>
                <button @click="addCustomer">Save</button>
            </div>
        </modal>

        <modal v-if="showEditCustomerModal" @close="showEditCustomerModal = false">
            <h3 slot="header">Create customer</h3>
            <div slot="body">
                <label for="customer_name"> Customer name </label>
                <input type="text" id="customer_name" name="customer_name" v-model="editCustomerName">
            </div>
            <div slot="footer">
                <button @click="showEditCustomerModal = false">Back</button>
                <button @click="saveCustomer(editCustomerId, editCustomerName)">Save</button>
            </div>
        </modal>


        <ul v-if="customers">
            <li v-for="customer in customers">
                <button @click="deleteCustomer(customer.id)"> X </button>
                <button @click="showCustomerEditModal(customer.id)"> E </button>
                <button @click="triggerWhisper"> TEST </button>
                <strong>Name:</strong> {{ customer.name }}
                <div v-for="project in customer.projects">
                    <strong>Project: </strong> {{ project.name }}
                </div>
            </li>
        </ul>
    </div>
</template>
<script>

    import echo from '../mixins/echo'
    import Modal from '../atoms/Modal.vue'

    export default {
        name: 'CustomerList',
        components: {
            Modal,
        },
        mixins: [echo],
        data() {
            return {
                customers: null,
                editCustomerName: null,
                editCustomerId: null,
                error: null,
                showAddCustomerModal: false,
                showEditCustomerModal: false,
                customerName: '',
            };
        },
        created() {

            this.fetchData();
        },
        mixins: [echo],
        methods: {
            fetchData() {
                this.$http
                    .get('/api/customers')
                    .then(response => {
                        this.customers = response.data
                    });
            },
            triggerWhisper() {
                let channel = Echo.private('billing');
                setTimeout(function() {
                    channel.whisper('test', {
                        user: 'a'
                    });
                }, 300);
            },

            addCustomer() {
                this.$http
                    .post('/api/customers/create', {name: this.customerName})
                    .then(response => {
                        this.showAddCustomerModal = false;
                    })
                    .catch(errors => console.log(errors.errors))
            },

            deleteCustomer(customer_id) {
                this.$http
                    .post('/api/customers/delete', {customer_id: customer_id})
                    .then(response => {})
                    .catch(error => console.log(error));
            },

            showCustomerEditModal(customer_id) {

                let editCustomers = this.customers.filter(customer => customer.id === customer_id);
                if(editCustomers.length > 0){
                    this.editCustomerName = editCustomers[0].name;
                    this.editCustomerId = editCustomers[0].id;
                }

                this.showEditCustomerModal = true;
            },

            saveCustomer(customer_id, customerName){

                this.$http.patch('/api/customers/' + customer_id, {
                    name: customerName,
                }).then(() => this.showEditCustomerModal = false).catch(error => console.log(error));
            },

            getEventHandlers() {
                return {
                    'Customer\\CustomerAdded': response => {
                        console.log(response);
                        this.customers.push(response.customer);
                    },
                    'Customer\\CustomerDeleted': response => {
                        this.customers = this.customers.filter(customer => customer.id !== response.customer_id);
                    },
                    'Customer\\CustomerUpdated': response => {
                        let customerIndex = this.customers.findIndex(obj => obj.id === response.customer.id)
                        if (customerIndex >= 0){
                           this.customers[customerIndex] = response.customer;
                        }
                    },
                };
            },
        }
    }
</script>