<!-- resources/js/components/OrderSummary.vue -->

<template>
    <div class="order-summary-container">
        <h2>Order Summary</h2>

        <div class="order-info">
            <p><strong>Order ID:</strong> {{ order.id }}</p>
            <p><strong>Status:</strong> {{ order.status }}</p>
        </div>

        <h3>Order Items</h3>
        <ul class="order-items">
            <li v-for="item in order.items" :key="item.id" class="order-item">
                {{ item.quantity }} x {{ item.menu_item.name }} - ₹{{ item.menu_item.price }} each
            </li>
        </ul>

        <div class="total-cost">
            <p><strong>Total Cost:</strong> ₹{{ calculateTotalCost() }}</p>
        </div>

        <!-- Add more details or customize the view as needed -->
    </div>
</template>

<script>
export default {
    props: {
        order: Object, 
    },
    methods: {
        calculateTotalCost() {
            // Calculate the total cost based on the quantity and price of each item
            return this.order.items.reduce((total, item) => {
                return total + item.quantity * item.menu_item.price;
            }, 0).toFixed(2);
        },
    },
};
</script>

<style scoped>
/* Add your component styles here */

.order-summary-container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 24px;
    margin-bottom: 15px;
}

.order-info {
    margin-bottom: 20px;
}

.order-info p {
    margin: 0;
}

h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.order-items {
    list-style: none;
    padding: 0;
}

.order-item {
    margin-bottom: 10px;
}

.total-cost p {
    font-size: 18px;
    margin: 0;
    color: #28a745; /* Green color for the total cost */
}
</style>
