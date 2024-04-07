<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h2>Stock Categories</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="editingCategory ? updateCategory() : createCategory()">
          <div class="form-group">
            <label for="categoryName">Category Name:</label>
            <input v-model="categoryName" type="text" id="categoryName" required>
          </div>
          <div class="form-group">
            <label for="categoryUnit">Unit:</label>
            <input v-model="categoryUnit" type="text" id="categoryUnit" required>
          </div>
          <div class="form-group">
            <label for="closingBalance">Closing Balance:</label>
            <input v-model="closingBalance" type="number" id="closingBalance" required>
          </div>
          <button type="submit">{{ editingCategory ? 'Update Category' : 'Create Category' }}</button>
          <button type="button" v-if="editingCategory" @click="cancelEdit">Cancel</button>
        </form>
        <hr>
        <h2>Categories</h2>
        <table>
          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.name }}</td>
            <td>{{ category.unit }}</td>
            <td>{{ category.closing_balance }}</td>
            <td>
              <button @click="editCategory(category)">Edit</button>
              <button @click="deleteCategory(category.id)">Delete</button>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categoryName: '',
      categoryUnit: '',
      closingBalance: 0, // Initialize closing balance
      categories: [],
      editingCategory: null,
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    createCategory() {
      axios.post('/stock_categories', {
        name: this.categoryName,
        unit: this.categoryUnit,
        closing_balance: this.closingBalance // Include closing balance in the request
      })
      .then(response => {
        this.fetchCategories();
        this.resetForm();
      })
      .catch(error => {
        console.error('Error creating category:', error);
      });
    },

    fetchCategories() {
      axios.get('/stock_categories')
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },

    editCategory(category) {
      this.editingCategory = category;
      this.categoryName = category.name;
      this.categoryUnit = category.unit;
      this.closingBalance = category.closing_balance; // Populate closing balance for editing
    },

    updateCategory() {
      axios.put(`/stock_categories/${this.editingCategory.id}`, {
        name: this.categoryName,
        unit: this.categoryUnit,
        closing_balance: this.closingBalance // Include closing balance in the request
      })
      .then(response => {
        this.fetchCategories();
        this.resetForm();
      })
      .catch(error => {
        console.error('Error updating category:', error);
      });
    },

    deleteCategory(categoryId) {
      const confirmDelete = window.confirm('Are you sure you want to delete this category?');
      if (!confirmDelete) {
        return;
      }
      axios.delete(`/stock_categories/${categoryId}`)
        .then(response => {
          console.log('Category deleted successfully:', response.data);
          this.fetchCategories();
        })
        .catch(error => {
          console.error('Error deleting category:', error);
        });
    },

    cancelEdit() {
      this.editingCategory = null;
      this.resetForm();
    },

    resetForm() {
      this.categoryName = '';
      this.categoryUnit = '';
      this.closingBalance = 0;
    }
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
</style>
