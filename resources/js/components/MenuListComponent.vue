<template>
  <div class="row">
    <div class="col-sm-8">
      <h2 class="menu-header">Menu</h2>
      <div v-for="category in categories" :key="category.id" class="category" :class="{ 'category-expanded': isCategoryExpanded(category.id) }">
        <div @click="toggleCategory(category.id)" class="category-header">
          <h3>{{ category.name }}</h3>
          <span v-if="isCategoryExpanded(category.id)">▼</span>
          <span v-else>▶</span>
        </div>
        <div v-if="isCategoryExpanded(category.id)" class="menu-items">
          <ul>
            <li v-for="menuItem in getMenuItems(category.id)" :key="menuItem.id" class="menu-item">
                {{ menuItem.name }} - ₹{{ menuItem.price }}
                <input class="form-control" v-model.number="menuItem.quantity" type="number" min="1" placeholder="Quantity">
                <button class="btn btn-primary btn-sm" @click="addToCart(menuItem)">Add to Cart</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="col-sm-4">
      &nbsp;<br><br>
      <div class="card">
        <div class="card-header"><h2>Cart</h2></div>  
        <div class="card-body">
            
          <ul class="cart-items">
            <li v-for="cartItem in cart" :key="cartItem.id" class="cart-item">
              {{ cartItem.name }} - ₹{{ (cartItem.price * cartItem.quantity) }} - Quantity: {{ cartItem.quantity }}
              <button @click="removeFromCart(cartItem)">Remove</button>
            </li>
          </ul>
          <button @click="placeOrder" class="place-order-btn">Place Order</button>
        </div>
      </div>
    </div>    
  </div>
</template>
  
  <script>
  export default {
    data() {
      return {
        categories: [], 
        menuItems: [],  
        cart: [],      
        expandedCategories: [], 
      };
    },
    mounted() {
      this.fetchCategories();
      this.fetchMenuItems();
    },
    methods: {
      fetchCategories() {
        axios.get('/categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error('Error fetching categories:', error);
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
  
      toggleCategory(categoryId) {
        if (this.isCategoryExpanded(categoryId)) {
          this.expandedCategories = this.expandedCategories.filter(id => id !== categoryId);
        } else {
          this.expandedCategories.push(categoryId);
        }
      },
  
      isCategoryExpanded(categoryId) {
        return this.expandedCategories.includes(categoryId);
      },
  
      getMenuItems(categoryId) {
        return this.menuItems.filter(item => item.category_id === categoryId);
      },
  
      addToCart(menuItem) {
        const existingItem = this.cart.find(cartItem => cartItem.id === menuItem.id);
  
        if (existingItem) {
          if(menuItem.quantity<1 || menuItem.quantity==null)
          {
            alert("Please add a valid quantity")
          }
          else
          {
            existingItem.quantity+=menuItem.quantity;
          }
        } else {
          if(menuItem.quantity<1 || menuItem.quantity==null)
          {
            alert("Please add a valid quantity")
          }
          else
          {
            this.cart.push({
              id: menuItem.id,
              name: menuItem.name,
              price: menuItem.price,
              quantity: menuItem.quantity,
            });
          }
          
        }
      },
  
      removeFromCart(cartItem) {
        const index = this.cart.findIndex(item => item.id === cartItem.id);
  
        if (index !== -1) {
          this.cart.splice(index, 1);
        }
      },
  
      placeOrder() {
      if (this.cart.length === 0) {
        console.warn('Cannot place an empty order.');
        return;
      }

      const orderData = {
        items: this.cart.map(item => ({
          id: item.id,
          quantity: item.quantity,
          rate: item.price,
        })),
      };

      axios.post('/order', orderData)
        .then(response => {
          console.log('Order placed successfully:', response.data);
          const orderId = response.data.order.id;
          const orderSummaryUrl = `/order/${orderId}`;
          window.location.href = orderSummaryUrl;
          this.cart = [];
        })
        .catch(error => {
          console.error('Error placing order:', error);
        });
    },
    },
  };
  </script>
  
  <style scoped>
.menu-header {
  font-size: 30px;
  margin-bottom: 15px;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  font-weight: bold;
}

.category {
  margin-bottom: 20px;
  border: 1px solid #30302f;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.category-header {
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  background-color: #776733;
  color: #fff;
  transition: background-color 0.3s; /* Add transition for smooth color change */
}

.category-header:hover {
  background-color: #604618;
}

.card-header {
  background-color: #776733;
  color: #fff;
}

.card-body {
  background-color: rgba(73, 58, 7, 0.4);
}
.category-expanded {
  background-color: rgba(73, 58, 7, 0.4);
}

.menu-items {
  padding: 10px;
}

.menu-item {
  list-style: none;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.menu-item input {
  margin-right: 10px;
  padding: 5px;
  width: 60px;
}

.cart-items {
  list-style: none;
  padding: 0;
}

.cart-item {
  margin-bottom: 10px;
  padding: 10px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.cart-item button {
  background-color: #dc3545;
  color: #fff;
  padding: 5px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.cart-item button:hover {
  background-color: #c82333;
}

.place-order-btn {
  background-color: #28a745;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.place-order-btn:hover {
  background-color: #218838;
}
</style>
  