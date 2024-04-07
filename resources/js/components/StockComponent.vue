<template>
    <div>
      <div class="card">
        <div class="card-header">
          <h2>Stock Management</h2>
        </div>
        <div class="card-body">
          <form @submit.prevent="editingStock ? updateStock() : createStock()">
            <div class="form-group">
              <label for="stockCategory">Stock Category:</label>
              <select v-model="stockCategoryId" id="stockCategory" required>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="transaction">Transaction:</label>
              <select v-model="transaction" id="transaction" required>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
              </select>
            </div>
            <div class="form-group">
              <label for="quantity">Quantity:</label>
              <input v-model="quantity" type="number" id="quantity" step="0.01" required>
            </div>
            <div class="form-group">
              <label for="date">Date:</label>
              <input v-model="date" type="date" id="date" required>
            </div>
            <div class="form-group">
              <label for="remark">Remark:</label>
              <input v-model="remark" type="text" id="remark"  required>
            </div>
            <button type="submit">{{ editingStock ? 'Update Stock' : 'Create Stock' }}</button>
            <button type="button" v-if="editingStock" @click="cancelEdit">Cancel</button>
          </form>
          <hr>
          <h2>Stocks</h2>
          <div class="table-container">
            <table>
              <tr>
              <th>Item</th>
              <th>Transaction</th>
              <th>Quantity</th>
              <th>Balance</th>
              <th>Date</th>
              <th>Option</th>
            </tr>
            <tr v-for="stock in stocks" :key="stock.id">
              <td>{{ stock.category.name }}</td>
              <td>{{ stock.transaction }}</td>
              <td>{{ stock.quantity }}</td>
              <td>{{ stock.balance }}</td>
              <td>{{ stock.date }}</td>
              <td>
                <button @click="editStock(stock)">Edit</button>
                <button @click="deleteStock(stock.id)">Delete</button>
              </td>
            </tr>
          </table>
          </div>          
        </div>
        <nav aria-label="Stocks Pagination">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link" @click="fetchStocks(currentPage - 1)">Previous</button>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
                <button class="page-link" @click="fetchStocks(page)">{{ page }}</button>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <button class="page-link" @click="fetchStocks(currentPage + 1)">Next</button>
                </li>
            </ul>
        </nav>
      </div>
      
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        stockCategoryId: '',
        transaction: 'credit',
        quantity: 0,
        date: '',
        stocks: [],
        remark: '',
        categories: [],
        editingStock: null,
        currentPage: 1,
        totalPages: 1,
      };
    },
    mounted() {
      this.fetchStocks();
      this.fetchCategories();
    },
    methods: {
      createStock() {
        axios.post('/stocks', {
          stock_category_id: this.stockCategoryId,
          transaction: this.transaction,
          quantity: this.quantity,
          date: this.date,
          remark: this.remark,
        })
        .then(response => {
          this.fetchStocks();
          this.stockCategoryId = '';
          this.transaction = 'credit';
          this.quantity = 0;
          this.date = '';
          this.remark='';
        })
        .catch(error => {
          console.error('Error creating stock:', error);
        });
      },
      fetchStocks(page = 1) {
      axios.get('/stocks', { params: { page } })
        .then(response => {
          this.stocks = response.data.data; 
          this.currentPage = response.data.current_page;
          this.totalPages = response.data.last_page;
        })
        .catch(error => {
          console.error('Error fetching stocks:', error);
        });
    },
      fetchCategories() {
        axios.get('/stock_categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error('Error fetching stock categories:', error);
          });
      },
      editStock(stock) {
        this.editingStock = stock;
        this.stockCategoryId = stock.stock_category_id;
        this.transaction = stock.transaction;
        this.quantity = stock.quantity;
        this.date = stock.date;
        this.remark = stock.remark;
      },
      updateStock() {
        axios.put(`/stocks/${this.editingStock.id}`, {
          stock_category_id: this.stockCategoryId,
          transaction: this.transaction,
          quantity: this.quantity,
          date: this.date,
          remark: this.remark,
        })
        .then(response => {
          this.fetchStocks();
          this.cancelEdit();
        })
        .catch(error => {
          console.error('Error updating stock:', error);
        });
      },
      deleteStock(stockId) {
        const confirmDelete = window.confirm('Are you sure you want to delete this stock?');
        if (!confirmDelete) {
          return;
        }
        axios.delete(`/stocks/${stockId}`)
          .then(response => {
            console.log('Stock deleted successfully:', response.data);
            this.fetchStocks();
          })
          .catch(error => {
            console.error('Error deleting stock:', error);
          });
      },
      cancelEdit() {
        this.editingStock = null;
        this.stockCategoryId = '';
        this.transaction = 'credit';
        this.quantity = 0;
        this.date = '';
        this.remark = '';
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your component styles here */
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    color: #555;
  }
  
  input,
  textarea,
  select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
  }
  
  button {
    margin-left: 5px;
    background-color: #007BFF;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }

  table {
  width: 100%;
  border-collapse: collapse;
}

/* Style for table header */
th {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

/* Style for table cells */
td {
  border: 1px solid #ddd;
  padding: 8px;
}

.table-container {
  height: 300px; /* Adjust as needed */
  overflow-y: auto;
}
  </style>
  
  