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
        <ul class="order-list">
          <li v-for="order in pendingOrders" :key="order.id" class="order-item">
            <!-- Display pending order details -->
            <button @click="handleButtonClick(order.id)" type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#order_summary_id">
              {{ order.id }} - {{ capitalizeFirstLetter(order.status) }}
            </button>          
            <button @click="processOrder(order.id)" class="action-btn">Process</button>
          </li>
        </ul>
      </div>
    </div>

    <div v-else-if="currentStatus === 'Processing'" class="card">
      <div class="card-body">
        <h2>Processing Orders</h2>
        <ul class="order-list">
          <li v-for="order in processingOrders" :key="order.id" class="order-item">
            <!-- Display processing order details -->
            <button @click="handleButtonClick(order.id)" type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#order_summary_id">
              {{ order.id }} - {{ capitalizeFirstLetter(order.status) }}
            </button>
            <button @click="completeOrder(order.id)" class="action-btn">Complete</button>
          </li>
        </ul>
      </div>
    </div>

    <div v-else-if="currentStatus === 'Completed'" class="card">
      <div class="card-body">
        <h2>Completed Orders</h2>
        <ul class="order-list">
          <li v-for="order in completedOrders" :key="order.id" class="order-item">
            <button @click="handleButtonClick(order.id)" type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#order_summary_id">
              {{ order.id }} - {{ capitalizeFirstLetter(order.status) }}
            </button>
            <button @click="printReceipt(order.id)" class="action-btn">Print</button>
          </li>
        </ul>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="order_summary_id" tabindex="-1" aria-labelledby="order_summary" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="order_summary">Order Summary</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <order-summary :order="order"></order-summary>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
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
      order: 
      {
        "id": 5,
        "table_id": 1,
        "total_amount": "1000.00",
        "status": "completed",
        "items": 
        [
          {
            "id": 6,
            "order_id": 5,
            "menu_item_id": 1,
            "quantity": 1,
            "menu_item": {
            "id": 1,
            "name": "Tomato Soup",
            "description": "..",
            "price": "90.00",
            "category_id": 1,
            }
          },
        ] 
      }
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
