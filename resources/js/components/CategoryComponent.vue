<template>
    <div>
      <div class="card">
        <div class="card-header">
            <h2>Menu Category</h2>
          </div>
        <div class="card-body">
          
      
  
      <form @submit.prevent="editingCategory ? updateCategory() : createCategory()">
        <div class="form-group">
          <label for="categoryName">Category Name:</label>
          <input v-model="categoryName" type="text" id="categoryName" required>
        </div>
  
        <button type="submit">{{ editingCategory ? 'Update Category' : 'Create Category' }}</button>
        <button type="button" v-if="editingCategory" @click="cancelEdit">Cancel</button>
      </form>
      <hr>
  
      <h2>Categories</h2>
      <table>
        <tr v-for="category in categories" :key="category.id">
            <td>{{ category.name }}</td>
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
  export default {
    data() {
      return {
        categoryName: '',
        categories: [],
        editingCategory: null,
      };
    },
    mounted() {
      this.fetchCategories();
    },
    methods: {
      createCategory() {
        // Use Axios to send a POST request to create a new category in Laravel backend
        axios.post('/categories', {
          name: this.categoryName,
        })
        .then(response => {
          this.fetchCategories();
          this.categoryName = ''; // Clear the input field after successful creation
        })
        .catch(error => {
          console.error('Error creating category:', error);
        });
      },
  
      fetchCategories() {
        axios.get('/categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error('Error fetching categories:', error);
          });
      },
  
      editCategory(category) {
        // Set the editingCategory to the selected category for editing
        this.editingCategory = category;
        this.categoryName = category.name; // Populate the input field with the category name
      },
  
      updateCategory() {
        // Use Axios to send a PUT request to update the editing category in Laravel backend
        axios.put(`/categories/${this.editingCategory.id}`, {
          name: this.categoryName,
        })
        .then(response => {
          this.fetchCategories();
          this.cancelEdit(); // Clear the editing state after successful update
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
  
        // Use Axios to send a DELETE request to delete the category in Laravel backend
        axios.delete(`/categories/${categoryId}`)
          .then(response => {
            console.log('Category deleted successfully:', response.data);
            this.fetchCategories(); // Refresh the category list after deletion
          })
          .catch(error => {
            console.error('Error deleting category:', error);
          });
      },
  
      cancelEdit() {
        // Clear the editing state
        this.editingCategory = null;
        this.categoryName = '';
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
  
  input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 3px;
  }
  
  button {
    margin-left: 5px;
    background-color: #007BFF; /* Blue color for buttons */
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3; /* Darker blue color for hover effect */
  }
  </style>
  