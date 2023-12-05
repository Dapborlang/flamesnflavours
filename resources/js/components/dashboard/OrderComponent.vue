<!-- resources/js/components/OrderList.vue -->
<template>
  <div>
      <h2>Order List</h2>
      <table class="table table-bordered">
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
          <tbody>
              <tr v-for="(order, index) in orders" :key="order.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ order.id }}</td>
                  <td>
                      <ul>
                          <li v-for="item in order.items" :key="item.id">
                              {{ item.quantity }} x {{ item.menu_item_name }} - {{ formatIndianCurrency(item.amount) }}
                          </li>
                      </ul>
                  </td>
                  <td>{{ formatIndianCurrency(calculateTotalAmount(order.items)) }}</td>
                  <td>{{ capitalizeFirstLetter(order.status) }}</td>
                  <td>{{ formatIndianDate(order.created_at) }}</td>
              </tr>
          </tbody>
      </table>
  </div>
</template>

<script>
export default {
  data() {
      return {
          orders: [],
      };
  },
  mounted() {
      this.fetchOrders();
  },
  methods: {
      fetchOrders() {
          axios.get('/order') // Assuming your API endpoint is /api/orders
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
