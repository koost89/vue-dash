<template>
    <div class="customers">
        <customer-list></customer-list>
    </div>
</template>
<script>
    import CustomerList from '../components/CustomerList'
    export default {
        name: 'Customers',
        components: {
            CustomerList,
        }
    }
</script>