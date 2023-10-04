<template>
    <div>
        <h1>Flames & Flavours</h1>
      <h3>Receipt</h3>
      <p>Order #: {{ orderNumber }}</p>
  
        <table class="table">
            <tr v-for="(item, index) in items" :key="index" class="item">
                <td>{{ item.name }}</td>
                <td>{{ item.price }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Subtotal: {{ calculateSubtotal() }}</td>
            </tr>
            <tr >
                <td></td>
                <td>GST ({{ gstRate }}%): {{ calculateGST() }}</td>
            </tr>
            <tr class="grand-total">
                <td></td>
                <td>Grand Total: {{ calculateGrandTotal() }}</td>
            </tr>
        </table>
  
      
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        orderNumber: "12345",
        items: [
          { name: "Item 1", price: 10.00 },
          { name: "Item 2", price: 15.00 },
          { name: "Item 3", price: 20.00 },
        ],
        gstRate: 18, // GST rate in percentage
      };
    },
    methods: {
      calculateSubtotal() {
        return this.items.reduce((total, item) => total + item.price, 0).toFixed(2);
      },
      calculateGST() {
        const subtotal = this.items.reduce((total, item) => total + item.price, 0);
        const gstAmount = (subtotal * (this.gstRate / 100)).toFixed(2);
        return gstAmount;
      },
      calculateGrandTotal() {
        const subtotal = this.items.reduce((total, item) => total + item.price, 0);
        const gstAmount = subtotal * (this.gstRate / 100);
        const grandTotal = (subtotal + gstAmount).toFixed(2);
        return grandTotal;
      },
    },
  };
  </script>
