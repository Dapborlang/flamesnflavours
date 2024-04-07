<template>
    <div>
      <div class="card">
        <div class="card-header">
          <h2>Order List</h2>
          <input type="date" v-model="orderDate" @change="fetchOrders">
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <!-- Table headers -->
            <thead>
              <tr>
                <th>Sl. No</th>
                <th>Order #</th>
                <th>Items</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Time</th>
              </tr>
            </thead>
            <!-- Table body -->
            <tbody>
              <!-- Table rows -->
              <tr v-for="(order, index) in orders" :key="order.id">
                <!-- Table data -->
                <td>{{ index + 1 }}</td>
                <td>{{ order.id }}</td>
                <td>
                  <ul>
                    <!-- Iterate over order items -->
                    <li v-for="item in order.items" :key="item.id">
                      {{ item.quantity }} x {{ item.menu_item.name }} - {{ formatIndianCurrency(item.amount) }}
                    </li>
                  </ul>
                </td>
                <td>{{ formatIndianCurrency(calculateTotalAmount(order.items)) }}</td>
                <td>{{ capitalizeFirstLetter(order.status) }}</td>
                <td>{{ formatIndianDate(order.created_at) }}</td>
              </tr>
              <!-- Total row -->
              <tr>
                <td colspan="3">Total</td>
                <td>{{ formatIndianCurrency(calculateTotalOrderAmount) }}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        orders: [],
        orderDate: new Date().toISOString().substr(0, 10) // Default to today's date
      };
    },
    computed: {
      calculateTotalOrderAmount() {
        return this.orders.reduce((total, order) => total + this.calculateTotalAmount(order.items), 0);
      },
    },
    mounted() {
      this.fetchOrders();
    },
    methods: {
      fetchOrders() {
        // Fetch orders for the selected date
        axios.get('/order', { params: { date: this.orderDate } })
          .then(response => {
            this.orders = response.data;
          })
          .catch(error => {
            console.error('Error fetching orders:', error);
          });
      },
      formatIndianDate(date) {
        return new Date(date).toLocaleString('en-IN');
      },
      formatIndianCurrency(amount) {
        return parseFloat(amount).toLocaleString('en-IN', {
          style: 'currency',
          currency: 'INR',
        });
      },
      calculateTotalAmount(items) {
        return items.reduce((total, item) => total + parseFloat(item.amount), 0);
      },
      capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
      },
    },
  };
  </script>
  