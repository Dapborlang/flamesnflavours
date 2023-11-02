<template>
    <div>
      <div class="card">
        <div class="card-header">
          <h2>User Roles</h2>
        </div>
        <div class="card-body">
          <!-- Create User Role Form -->
          <form @submit.prevent="editingUserRole ? updateUserRole() : createUserRole()">
            <div class="form-group">
              <label for="userSelect">User:</label>
              <select v-model="selectedUserId" id="userSelect" required>
                <option value="" disabled>Select a User</option>
                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
              </select>
            </div>
  
            <div class="form-group">
              <label for="roleSelect">Role:</label>
              <select v-model="selectedRoleId" id="roleSelect" required>
                <option value="" disabled>Select a Role</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.role }}</option>
              </select>
            </div>
  
            <button type="submit" class="btn btn-primary">
              {{ editingUserRole ? 'Update User Role' : 'Create User Role' }}
            </button>
            <button type="button" v-if="editingUserRole" @click="cancelEdit" class="btn btn-secondary">
              Cancel
            </button>
          </form>
  
          <hr>
  
          <h2>User Roles List</h2>
          <table class="table">
            <tr v-for="userRole in userRoles" :key="userRole.id">
              <td>
                User: {{ userRole.user.name }} - Role: {{ userRole.role.role }}
              </td>
              <td>
                <button @click="editUserRole(userRole)" class="btn btn-warning">
                  Edit
                </button>
                <button @click="deleteUserRole(userRole.id)" class="btn btn-danger">
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
        selectedUserId: '',
        selectedRoleId: '',
        users: [],
        roles: [],
        userRoles: [],
        editingUserRole: null,
      };
    },
    mounted() {
      this.fetchUsers();
      this.fetchRoles();
      this.fetchUserRoles();
    },
    methods: {
      createUserRole() {
        axios
          .post('/user-roles', {
            user_id: this.selectedUserId,
            role_id: this.selectedRoleId,
          })
          .then((response) => {
            this.fetchUserRoles();
            this.selectedUserId = ''; // Clear the user selection
            this.selectedRoleId = ''; // Clear the role selection
          })
          .catch((error) => {
            console.error('Error creating user role:', error);
          });
      },
  
      fetchUsers() {
        axios
          .get('/users')
          .then((response) => {
            this.users = response.data;
          })
          .catch((error) => {
            console.error('Error fetching users:', error);
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
  
      fetchUserRoles() {
        axios
          .get('/user-roles')
          .then((response) => {
            this.userRoles = response.data;
          })
          .catch((error) => {
            console.error('Error fetching user roles:', error);
          });
      },
  
      editUserRole(userRole) {
        this.editingUserRole = userRole;
        this.selectedUserId = userRole.user.id;
        this.selectedRoleId = userRole.role.id;
      },
  
      updateUserRole() {
        axios
          .put(`/user-roles/${this.editingUserRole.id}`, {
            user_id: this.selectedUserId,
            role_id: this.selectedRoleId,
          })
          .then((response) => {
            this.fetchUserRoles();
            this.cancelEdit();
          })
          .catch((error) => {
            console.error('Error updating user role:', error);
          });
      },
  
      deleteUserRole(userRoleId) {
        const confirmDelete = window.confirm('Are you sure you want to delete this user role?');
  
        if (!confirmDelete) {
          return;
        }
  
        axios
          .delete(`/user-roles/${userRoleId}`)
          .then((response) => {
            console.log('User role deleted successfully:', response.data);
            this.fetchUserRoles();
          })
          .catch((error) => {
            console.error('Error deleting user role:', error);
          });
      },
  
      cancelEdit() {
        this.editingUserRole = null;
        this.selectedUserId = '';
        this.selectedRoleId = '';
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
  
  select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 3px;
  }
  
  button {
    margin-left: 5px;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3; /* Darker blue color for hover effect */
  }
  </style>
  