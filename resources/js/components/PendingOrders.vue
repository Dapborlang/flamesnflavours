<!-- resources/js/components/PendingOrders.vue -->

<template>
    <div class="pending-orders-container">
      <h2>Pending Orders</h2>
  
      <ul class="order-list">
        <li v-for="order in pendingOrders" :key="order.id" class="order-item">
          <p class="order-id">Order ID: {{ order.id }}</p>
          <p class="order-status">Status: {{ order.status }}</p>
          <p class="order-time">Ordered at: {{ formatOrderTime(order.created_at) }}</p>
          <button @click="processOrder(order.id)" class="process-order-btn">Process Order</button>
          <!-- Add more details or customize the view as needed -->
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        pendingOrders: [],
      };
    },
    mounted() {
      this.fetchPendingOrders();
    },
    methods: {
      fetchPendingOrders() {
        // Assuming you have an API endpoint to fetch pending orders using a POST request
        axios.post('/orders/pending')
          .then(response => {
            this.pendingOrders = response.data;
          })
          .catch(error => {
            console.error('Error fetching pending orders:', error);
          });
      },
      formatOrderTime(time) {
        // Format the order time (you can use a library like moment.js for more advanced formatting)
        const formattedTime = new Date(time).toLocaleString();
        return formattedTime;
      },
      processOrder(orderId) {
        // Make an Axios POST request to process the order
        axios.post(`/orders/process/${orderId}`)
          .then(response => {
            console.log('Order processed successfully:', response.data);
            // You can update the UI or take additional actions as needed
            // For example, remove the processed order from the list
            this.pendingOrders = this.pendingOrders.filter(order => order.id !== orderId);
          })
          .catch(error => {
            console.error('Error processing order:', error);
          });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your component styles here */
  
  .pending-orders-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    transition: transform 0.3s ease-in-out;
  
    &:hover {
      transform: scale(1.02);
    }
  }
  
  .order-id,
  .order-status,
  .order-time {
    margin: 0;
    font-size: 18px;
  }
  
  .order-status {
    color: #007bff; /* Blue color for the order status */
  }
  
  .process-order-btn {
    background-color: #28a745;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
  
    &:hover {
      background-color: #218838;
    }
  }
  </style>
  