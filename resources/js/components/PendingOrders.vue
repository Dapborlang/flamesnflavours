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

    <div v-if="currentStatus === 'Pending'" class="card">
      <div class="card-body">
        <h2>Pending Orders</h2>
        <table class="order-table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Items</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in pendingOrders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>
            <ul>
              <li v-for="item in order.items" :key="item.id">
                {{ item.menu_item.name }} - {{ item.quantity }} x ₹{{ item.amount }}
              </li>
            </ul>
          </td>
          <td>{{ order.status }}</td>
        </tr>
      </tbody>
    </table>
      </div>
    </div>

    <div v-else-if="currentStatus === 'Processing'" class="card">
      <div class="card-body">
        <h2>Processing Orders</h2>
        
      </div>
    </div>

    <div v-else-if="currentStatus === 'Completed'" class="card">
      <div class="card-body">
        <h2>Completed Orders</h2>
        
      </div>
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
    capitalizeFirstLetter(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
    fetchOrders() {
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
      axios.post(`/orders/process/${orderId}`)
        .then(response => {
          console.log('Order processed successfully:', response.data);
          this.fetchOrders(); 
        })
        .catch(error => {
          console.error('Error processing order:', error);
        });
    },
    completeOrder(orderId) {
      axios.post(`/orders/complete/${orderId}`)
        .then(response => {
          console.log('Order completed successfully:', response.data);
          this.fetchOrders(); 
        })
        .catch(error => {
          console.error('Error completing order:', error);
        });
    },

    handleButtonClick(orderId) {
      axios.get(`/orders/${orderId}`)
        .then(response => {
          this.order=response.data; 
        })
        .catch(error => {
          console.error('Error completing order:', error);
        });
    },

    printReceipt(orderId)
    {
      const url = `/print/${orderId}`;
      window.open(url, '_blank');
    }

  },
};
</script>

<style scoped>
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


.order-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.order-table th, .order-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.order-table th {
  background-color: #f0f0f0;
}

.order-table tbody tr:hover {
  background-color: #f9f9f9;
}
</style>
