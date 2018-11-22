<template>
    <div>
        <td><span>{{id}}</span></td>
        <td><input type="text" v-model="type"></td>
        <td><input type="text" v-model="project_id"></td>
        <td><input type="text" v-model="customer_id"></td>
        <td><input type="text" v-model="description"></td>
        <td><input type="text" v-model="note"></td>
        <td><input type="number" v-model="hourly_rate"></td>
        <td><input type="number" v-model="estimate_hours"></td>
        <td><input type="number" v-model="worked_hours"></td>
        <td><input type="number" v-model="total_amount"></td>
    </div>
</template>
<script>

    import Modal from '../atoms/Modal.vue'

    export default {
        name: 'Billing',
        props: ['billing'],
        components: {

        },
//        mixins: [echo],
        data() {
            return {
                id: 0,
                type: '',
                project_id: 0,
                customer_id: 0,
                description: '',
                note: '',
                hourly_rate: 0,
                estimate_hours: 0,
                worked_hours: 0,
                total_amount: 0,
            };
        },
        mounted() {
            this.id = this.billing.id
            this.type = this.billing.type
            this.project_id = this.billing.project_id
            this.customer_id = this.billing.customer_id
            this.description = this.billing.description
            this.note = this.billing.note
            this.hourly_rate = this.billing.hourly_rate
            this.estimate_hours = this.billing.estimate_hours
            this.worked_hours = this.billing.worked_hours
            this.total_amount = this.billing.total_amount
        },
        watch: {
            worked_hours() {
               this.total_amount = this.worked_hours * this.hourly_rate
            },
            hourly_rate() {
                this.total_amount = this.worked_hours * this.hourly_rate
            }
        },
        methods: {
        }
    }
</script>