<template>
    <div>
      <div class="card">
        <div class="card-header">
          <h2>Menu Item</h2>
          </div>
        <div class="card-body">
      
  
      <form @submit.prevent="editingMenuItem ? updateMenuItem() : createMenuItem()">
        <div class="form-group">
          <label for="menuItemName">Menu Item Name:</label>
          <input v-model="menuItemName" type="text" id="menuItemName" required>
        </div>
  
        <div class="form-group">
          <label for="menuItemDescription">Menu Item Description:</label>
          <textarea v-model="menuItemDescription" id="menuItemDescription"></textarea>
        </div>
  
        <div class="form-group">
          <label for="menuItemPrice">Menu Item Price:</label>
          <input v-model="menuItemPrice" type="number" id="menuItemPrice" step="0.01" required>
        </div>
  
        <div class="form-group">
          <label for="menuItemCategory">Menu Item Category:</label>
          <select v-model="menuItemCategory" id="menuItemCategory" required>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
  
        <button type="submit">{{ editingMenuItem ? 'Update Menu Item' : 'Create Menu Item' }}</button>
        <button type="button" v-if="editingMenuItem" @click="cancelEdit">Cancel</button>
      </form>
      <hr>
  
      <h2>Menu Items</h2>
      <table>
        <tr v-for="menuItem in menuItems" :key="menuItem.id">
          <td>{{ menuItem.name }} - {{ menuItem.price }}</td>
          <td><button @click="editMenuItem(menuItem)">Edit</button>
          <button @click="deleteMenuItem(menuItem.id)">Delete</button></td>
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
        menuItemName: '',
        menuItemDescription: '',
        menuItemPrice: '',
        menuItemCategory: '',
        menuItems: [],
        categories: [],
        editingMenuItem: null,
      };
    },
    mounted() {
      this.fetchMenuItems();
      this.fetchCategories();
    },
    methods: {
      createMenuItem() {
        axios.post('/menu-items', {
          name: this.menuItemName,
          description: this.menuItemDescription,
          price: this.menuItemPrice,
          category_id: this.menuItemCategory,
        })
        .then(response => {
          this.fetchMenuItems();
          this.resetForm();
        })
        .catch(error => {
          console.error('Error creating menu item:', error);
        });
      },
  
      fetchMenuItems() {
        axios.get('/menu-items')
          .then(response => {
            this.menuItems = response.data;
          })
          .catch(error => {
            console.error('Error fetching menu items:', error);
          });
      },
  
      editMenuItem(menuItem) {
        this.editingMenuItem = menuItem;
        this.menuItemName = menuItem.name;
        this.menuItemDescription = menuItem.description;
        this.menuItemPrice = menuItem.price;
        this.menuItemCategory = menuItem.category_id.toString();
      },
  
      updateMenuItem() {
        axios.put(`/menu-items/${this.editingMenuItem.id}`, {
          name: this.menuItemName,
          description: this.menuItemDescription,
          price: this.menuItemPrice,
          category_id: this.menuItemCategory,
        })
        .then(response => {
          this.fetchMenuItems();
          this.cancelEdit();
        })
        .catch(error => {
          console.error('Error updating menu item:', error);
        });
      },
  
      deleteMenuItem(menuItemId) {
        const confirmDelete = window.confirm('Are you sure you want to delete this menu item?');
        
        if (!confirmDelete) {
          return;
        }
  
        axios.delete(`/menu-items/${menuItemId}`)
          .then(response => {
            console.log('Menu item deleted successfully:', response.data);
            this.fetchMenuItems();
          })
          .catch(error => {
            console.error('Error deleting menu item:', error);
          });
      },
  
      cancelEdit() {
        this.editingMenuItem = null;
        this.resetForm();
      },
  
      resetForm() {
        this.menuItemName = '';
        this.menuItemDescription = '';
        this.menuItemPrice = '';
        this.menuItemCategory = '';
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
  