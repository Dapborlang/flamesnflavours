<template>
  <div class="order-status-container">
    <div class="tabs">
      <div
        v-for="(status, index) in orderStatuses"
        :key="index"
        @click="changeStatus(status)"
        :class="{ active: currentStatus === status }"
      >
        {{ status }}
      </div>
    </div>

    <div v-if="currentStatus === 'Pending'">
      <h2>Pending Orders</h2>
      <ul class="order-list">
        <li v-for="order in pendingOrders" :key="order.id" class="order-item">
          <!-- Display pending order details -->
          {{ order.id }} - {{ order.status }}
          <button @click="processOrder(order.id)" class="action-btn">Process</button>
        </li>
      </ul>
    </div>

    <div v-else-if="currentStatus === 'Processing'">
      <h2>Processing Orders</h2>
      <ul class="order-list">
        <li v-for="order in processingOrders" :key="order.id" class="order-item">
          <!-- Display processing order details -->
          {{ order.id }} - {{ order.status }}
          <button @click="completeOrder(order.id)" class="action-btn">Complete</button>
        </li>
      </ul>
    </div>

    <div v-else-if="currentStatus === 'Completed'">
      <h2>Completed Orders</h2>
      <ul class="order-list">
        <li v-for="order in completedOrders" :key="order.id" class="order-item">
          <!-- Display completed order details -->
          {{ order.id }} - {{ order.status }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      orderStatuses: ['Pending', 'Processing', 'Completed'],
      currentStatus: 'Pending',
      pendingOrders: [],
      processingOrders: [],
      completedOrders: [],
    };
  },
  mounted() {
    this.fetchOrders();
  },
  methods: {
    fetchOrders() {
      // Assuming you have API endpoints to fetch orders for each status
      axios.post('/orders', { status: 'Pending' })
        .then(response => {
          this.pendingOrders = response.data;
        })
        .catch(error => {
          console.error('Error fetching pending orders:', error);
        });

      axios.post('/orders', { status: 'Processing' })
        .then(response => {
          this.processingOrders = response.data;
        })
        .catch(error => {
          console.error('Error fetching processing orders:', error);
        });

      axios.post('/orders', { status: 'Completed' })
        .then(response => {
          this.completedOrders = response.data;
        })
        .catch(error => {
          console.error('Error fetching completed orders:', error);
        });
    },
    changeStatus(status) {
      this.currentStatus = status;
    },
    processOrder(orderId) {
      // Make an Axios POST request to process the order
      axios.post(`/orders/process/${orderId}`)
        .then(response => {
          console.log('Order processed successfully:', response.data);
          // Update the UI or take additional actions as needed
          this.fetchOrders(); // Refresh the order lists
        })
        .catch(error => {
          console.error('Error processing order:', error);
        });
    },
    completeOrder(orderId) {
      // Make an Axios POST request to complete the order
      axios.post(`/orders/complete/${orderId}`)
        .then(response => {
          console.log('Order completed successfully:', response.data);
          // Update the UI or take additional actions as needed
          this.fetchOrders(); // Refresh the order lists
        })
        .catch(error => {
          console.error('Error completing order:', error);
        });
    },
  },
};
</script>

<style scoped>
/* Add your component styles here */

.order-status-container {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}

.tabs {
  display: flex;
  margin-bottom: 20px;
}

.tabs div {
  cursor: pointer;
  padding: 10px;
  margin-right: 10px;
  background-color: #f0f0f0;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.tabs div.active {
  background-color: #007bff;
  color: #fff;
}

h2 {
  font-size: 24px;
  margin-bottom: 15px;
  color: #333;
}

.order-list {
  list-style: none;
  padding: 0;
}

.order-item {
  margin-bottom: 20px;
  padding: 15px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: transform 0.3s ease-in-out;

  &:hover {
    transform: scale(1.02);
  }
}

.action-btn {
  background-color: #28a745;
  color: #fff;
  padding: 5px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;

  &:hover {
    background-color: #218838;
  }
}
</style>
