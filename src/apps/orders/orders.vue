<template>
  <div>
    <h1>Orders</h1>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer Name</th>
          <th>Country</th>
          <th>City</th>
          <th>Street</th>
          <th>Location</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.customer.firstname }}</td>
          <td>{{ order.country }}</td>
          <td>{{ order.city }}</td>
          <td>{{ order.street }}</td>
          <td>{{ order.location }}</td>
          <td
            :style="{
              backgroundColor: order.statusColor,
            }"
            style="color: white"
          >
            {{ order.statusLabel }}
          </td>
          <td>
            <button
              style="color: white; background-color: blue; margin-left: 5px"
              class="btn"
              v-if="order.orderStatusId != 2 && order.orderStatusId != 4"
              @click="manageOrder(order.id, 'accept')"
            >
              Accept
            </button>
            <button
              class="btn"
              style="background-color: red; color: white; margin-left: 5px"
              v-if="order.orderStatusId != 2 && order.orderStatusId != 4"
              @click="manageOrder(order.id, 'reject')"
            >
              Reject
            </button>
            <a
              :href="'http://supplier-shopndot.test/orders/details/' + order.id"
              style="background-color: #1cc88a; margin-left: 5px; color: white"
              class="btn"
            >
              View
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup lang="ts">
import {
  ref,
  onMounted,
  watch,
  defineComponent,
  watchEffect,
  reactive,
} from "vue";
import axios from "axios";
// import { defineProps } from "vue";
import { toast, type ToastOptions } from "vue3-toastify";
import { isAuth, isGuest, loginUrl } from "../../lib/functions";
type Props = {
  orders: any;
};
const props = defineProps<Props>();
const orders = ref([]);
const btnStatus = ref();
const getOrders = () => {
  axios.get("http://supplier-shopndot.test/orders/18").then((response) => {
    orders.value = response.data;
    console.log(orders);
  });
};
getOrders();
const manageOrder = (orderId, action) => {
  axios
    .post(
      "http://supplier-shopndot.test/order/update",
      {
        id: orderId,
        action: action,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    )
    .then((response) => {
      // console.log(response.data);
      // if (response.data.status == "status") {
      //   btnStatus.value = false;
      // }
      btnStatus.value = response.data.orderStatusId;
      console.log(btnStatus.value);
      getOrders();
    });
};
</script>
