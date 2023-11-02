<template>
    <div class="container-fluid">
      <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
          <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
            <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <span class="fs-5 d-none d-sm-inline">Menu</span>
            </a>
            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                <li class="nav-item">
                <a href="#" class="nav-link align-middle px-0"  @click="toggleSection('home')">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                </a>
                </li>    
                <li>
                    <a href="#" class="nav-link px-0 align-middle" @click="toggleSection('orders')">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                </li>    
                <li>
                    <a href="#" class="nav-link px-0 align-middle" @click="toggleSection('menuManagement')">
                    <i class="bi bi-menu-app"></i><span class="ms-1 d-none d-sm-inline">Menu Management</span></a>
                </li>       
                <li>
                    <a href="#" class="nav-link px-0 align-middle" @click="toggleSection('role')">
                    <i class="bi bi-menu-app"></i><span class="ms-1 d-none d-sm-inline">Role</span></a>
                </li> 
                <li>
                    <a href="#" class="nav-link px-0 align-middle" @click="toggleSection('userRole')">
                    <i class="bi bi-menu-app"></i><span class="ms-1 d-none d-sm-inline">User Management</span></a>
                </li>
            </ul>
            <hr>
            <div class="dropdown pb-4">
              <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">Hello</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class a="dropdown-item" href="#">Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col py-3 scrollable-container">
          <home-component v-if="activeSection === 'home'"></home-component>
          <order-component v-if="activeSection === 'orders'"></order-component>
          <menu-management-component v-if="activeSection === 'menuManagement'"></menu-management-component>
          <role-component v-if="activeSection === 'role'"></role-component>
          <user-role-component v-if="activeSection === 'userRole'"></user-role-component>
        </div>
      </div>
    </div>
  </template>
  
<script>
  import HomeComponent from './DailySaleComponent.vue';
  import OrderComponent from './DailySaleComponent.vue';
  import MenuManagementComponent  from './MenuManagement.vue'; 
  import RoleComponent  from './RoleComponent.vue'; 
  import UserRoleComponent  from './UserRoleComponent.vue'; 

  export default {
    data() {
      return {
        activeSection: 'home', 
      };
    },
    methods: {
      toggleSection(section) {
        this.activeSection = section;
      },
    },
    components: {
      HomeComponent,
      OrderComponent,
      MenuManagementComponent,
      RoleComponent,
      UserRoleComponent,
    },
  };
</script>
<style scoped>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  .scrollable-container 
  {
    height: 90vh;
    overflow-y: scroll;
  }
</style>
  