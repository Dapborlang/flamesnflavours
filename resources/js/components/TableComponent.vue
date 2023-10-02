<template>
  <div class="table-create-container">
    <h2>Create Table</h2>

    <form @submit.prevent="createTable" class="table-form">
      <div class="form-group">
        <label for="tableNumber">Table Number:</label>
        <input v-model="tableNumber" type="text" id="tableNumber" required>
      </div>

      <button type="submit">Create Table</button>
    </form>

    <h2>Tables</h2>
    <table>
      <tr v-for="table in tables" :key="table.id">
        <td>{{ table.table_number }}</td>
        <td><button class="delete-button" @click="deleteTable(table.id)">Delete</button></td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableNumber: '',
      tables: ''
    };
  },
  mounted() {
    this.fetchTables();
  },
  methods: {
    createTable() {
      // Use Axios to send a POST request to create a new table in Laravel backend
      axios.post('/table', {
        table_number: this.tableNumber,
      })
      .then(response => {
        this.fetchTables();
      })
      .catch(error => {
        // Handle errors, e.g., show an error message to the user
        console.error('Error creating table:', error);
      });
    },

    fetchTables() {
      axios.get('/table')
        .then(response => {
          this.tables=response.data;
        })
        .catch(error => {
          console.error('Error fetching tables:', error);
        });
    },

    deleteTable(tableId) {
      const confirmDelete = window.confirm('Are you sure you want to delete this table?');
      
      if (!confirmDelete) {
        return;
      }

      axios.delete(`/table/${tableId}`)
        .then(response => {
          console.log('Table deleted successfully:', response.data);
          // Update your Vue data to remove the deleted table
          this.fetchTables(); // Refresh the table list after deletion
        })
        .catch(error => {
          console.error('Error deleting table:', error);
        });
    },
  },
};
</script>

<style scoped>
/* Add your component styles here */

.table-create-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #333;
}

.table-form {
  margin-top: 20px;
}

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
  background-color: #4caf50;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

.delete-button {
  background-color: #d9534f; /* Change to the color you desire */
  color: #fff;
  padding: 5px 10px; /* Adjust padding as needed */
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.delete-button:hover {
  background-color: #c9302c; /* Change to the hover color you desire */
}
</style>