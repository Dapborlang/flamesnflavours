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
                    <a href="#" class="nav-link px-0 align-middle" @click="toggleSection('orders')">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                </li>    
            </ul>
            <hr>
            <div class="dropdown pb-4">
              <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-sm-inline mx-1">Reception</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#" @click.prevent="Logout()">Sign out</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col py-3 scrollable-container">
          <order-component v-if="activeSection === 'orders'"></order-component>
        </div>
      </div>
    </div>
  </template>
  
<script>
  import OrderComponent from './PendingOrders.vue';

  export default {
    data() {
      return {
        activeSection: 'orders', 
      };
    },
    methods: {
      toggleSection(section) {
        this.activeSection = section;
      },
      Logout()
      {
        axios
        .post('/logout')
        .then((response) => {
          window.location.reload();
        })
        .catch((error) => {
          console.error('Form submission error:', error);
        });
      }
    },
    components: {
      OrderComponent,
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
  