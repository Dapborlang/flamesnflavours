import './bootstrap';
import { createApp } from 'vue';
import 'bootstrap-icons/font/bootstrap-icons.css';


const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import TableComponent from './components/TableComponent.vue';
app.component('table-component', TableComponent);

import CategoryComponent from './components/CategoryComponent.vue';
app.component('category-component', CategoryComponent);

import MenuComponent from './components/MenuComponent.vue';
app.component('menu-component', MenuComponent);

import MenuListComponent from './components/MenuListComponent.vue';
app.component('menulist-component', MenuListComponent);

import OrderSummary from './components/OrderSummary.vue';
app.component('order-summary', OrderSummary);

import PendingOrders from './components/PendingOrders.vue';
app.component('pending-orders', PendingOrders);

import GstComponent from './components/GstComponent.vue';
app.component('gst-component', GstComponent);

import DashboardComponent from './components/DashboardComponent.vue';
app.component('dash-component', DashboardComponent);

import ReceptionComponent from './components/ReceptionComponent.vue';
app.component('reception-component', ReceptionComponent);

import KitchenComponent from './components/KitchenComponent.vue';
app.component('kitchen-component', KitchenComponent);

app.mount('#app');
