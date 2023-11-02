<template>
    <div>
      <div class="card">
        <div class="card-header">
          <h2>Roles</h2>
        </div>
        <div class="card-body">
          <!-- Create Role Form -->
          <form @submit.prevent="editingRole ? updateRole() : createRole()">
            <div class="form-group">
              <label for="roleName">Role Name:</label>
              <input v-model="roleName" type="text" id="roleName" required>
            </div>
  
            <button type="submit" class="btn btn-primary">
              {{ editingRole ? 'Update Role' : 'Create Role' }}
            </button>
            <button type="button" v-if="editingRole" @click="cancelEdit" class="btn btn-secondary">
              Cancel
            </button>
          </form>
  
          <hr>
  
          <h2>Roles List</h2>
          <table class="table">
            <tr v-for="role in roles" :key="role.id">
              <td>{{ role.role }}</td>
              <td>
                <button @click="editRole(role)" class="btn btn-warning">
                  Edit
                </button>
                <button @click="deleteRole(role.id)" class="btn btn-danger">
                  Delete
                </button>
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
        roleName: '',
        roles: [],
        editingRole: null,
      };
    },
    mounted() {
      this.fetchRoles();
    },
    methods: {
      createRole() {
        axios
          .post('/roles', {
            role: this.roleName,
          })
          .then((response) => {
            this.fetchRoles();
            this.roleName = ''; // Clear the input field after successful creation
          })
          .catch((error) => {
            console.error('Error creating role:', error);
          });
      },
  
      fetchRoles() {
        axios
          .get('/roles')
          .then((response) => {
            this.roles = response.data;
          })
          .catch((error) => {
            console.error('Error fetching roles:', error);
          });
      },
  
      editRole(role) {
        this.editingRole = role;
        this.roleName = role.role; // Populate the input field with the role name
      },
  
      updateRole() {
        axios
          .post(`/roles/${this.editingRole.id}`, {
            role: this.roleName,
            _method:"put"
          })
          .then((response) => {
            this.fetchRoles();
            this.cancelEdit(); // Clear the editing state after successful update
          })
          .catch((error) => {
            console.error('Error updating role:', error);
          });
      },
  
      deleteRole(roleId) {
        const confirmDelete = window.confirm('Are you sure you want to delete this role?');
  
        if (!confirmDelete) {
          return;
        }
  
        axios
          .delete(`/roles/${roleId}`)
          .then((response) => {
            console.log('Role deleted successfully:', response.data);
            this.fetchRoles(); // Refresh the role list after deletion
          })
          .catch((error) => {
            console.error('Error deleting role:', error);
          });
      },
  
      cancelEdit() {
        // Clear the editing state
        this.editingRole = null;
        this.roleName = '';
      },
    },
  };
  </script>
  
  <style scoped>
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
  