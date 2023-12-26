/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import 'bootstrap-icons/font/bootstrap-icons.css';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

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


app.mount('#app');
