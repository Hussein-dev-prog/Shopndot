<template>
  <div class="row" :key="product.id">
    <div class="col" style="position: relative">
      <img class="img-fluid" alt="Product Image" :src="product.image" />
      <p
        v-if="props.product.quantity > 0"
        class="bg-success"
        style="
          color: white;
          position: absolute;
          top: 0px;
          padding: 5px;
          width: 50%;
          opacity: 0.9;
        "
      >
        In Stock
      </p>
      <p
        v-else
        class="bg-danger"
        style="
          color: white;
          position: absolute;
          top: 0px;
          padding: 5px;
          width: 50%;
          opacity: 0.9;
        "
      >
        Out Of Stock
      </p>
    </div>
    <div class="col">
      <div>
        <h3 class="d-inline-block">{{ product.name }}</h3>
      </div>
      <p>${{ product.price }}</p>
      <p>{{ product.description }}</p>
      <input
        type="number"
        class="form-control mt-2 product-quantity"
        :max="product.quantity"
        v-model="qty"
        :id="`${product.id}quantity`"
        name="user_quantity"
        ref="quantityInputRef"
        :disabled="product.quantity === 0"
      />
      <button
        class="btn btn-outline-primary mt-2"
        :class="{}"
        @click="addToCart(product.id, qty)"
        :disabled="product.quantity === 0"
      >
        <i class="bi bi-cart-fill"></i> Add to Cart
      </button>
      <button
        class="d-inline-block btn btn-outline-warning mt-2 mx-2"
        :class="{}"
        :disabled="product.quantity === 0"
        @click="addToWishList(product.id)"
      >
        <i class="bi bi-heart-fill"></i> Add To Wishlist
      </button>
      <div class="row">
        <div class="col">
          <img
            alt="Shop Image"
            :src="shop.logo"
            style="height: 50px; width: 50px; object-fit: contain"
            class="mt-2"
          />
          <p>{{ shop.name }}</p>
        </div>
        <a :href="`?r=site%2Fdisplayshop&id=${product.id}`">
          <p>Visit Our Shop</p></a
        >
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, onMounted, watch, defineComponent, watchEffect } from "vue";
import axios from "axios";
import { defineProps } from "vue";
import { toast, type ToastOptions } from "vue3-toastify";
import { isAuth, isGuest, loginUrl } from "../../lib/functions";
type Props = {
  product: any;
  shop: any;
};
const props = defineProps<Props>();
const qty = ref<number>(1);

const addToWishList = (productId: number) => {
  if (isGuest()) {
    document.location.href = loginUrl();
    return;
  }
  axios
    .post(
      "http://customer-shopndot.test/index.php?r=wishlist/additem",
      {
        product_id: productId,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    )
    .then((response) => {
      // Handle success
      if (response.data.status === "success") {
        toast.success(response.data.message, {
          autoClose: 3000,
          position: toast.POSITION.TOP_RIGHT,
        } as ToastOptions);
        // alert(response.data.message);
      } else if (response.data.status === "error") {
        toast.error(response.data.message, {
          autoClose: 3000,
          position: toast.POSITION.TOP_RIGHT,
        } as ToastOptions);
      }
    })
    .catch((error) => {
      // Handle error
      toast.error(error.message, {
        autoClose: 3000,
        position: toast.POSITION.TOP_RIGHT,
      } as ToastOptions);
    });
};
const addToCart = (productId: number, quantity: number) => {
  if (isGuest()) {
    document.location.href = loginUrl();
    return;
  }
  axios
    .post(
      "http://customer-shopndot.test/index.php?r=cart/addtocart",
      {
        product_id: productId,
        quantity: quantity,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    )
    .then((response) => {
      // Handle success
      if (response.data.status === "success") {
        toast.success(response.data.message, {
          autoClose: 3000,
          position: toast.POSITION.TOP_RIGHT,
        } as ToastOptions);
        // alert(response.data.message);
      } else if (response.data.status === "error") {
        toast.error(response.data.message, {
          autoClose: 3000,
          position: toast.POSITION.TOP_RIGHT,
        } as ToastOptions);
      }
    })
    .catch((error) => {
      // Handle error
      toast.error(error.message, {
        autoClose: 3000,
        position: toast.POSITION.TOP_RIGHT,
      } as ToastOptions);
    });
};

// Watch for changes in the qty property
watch(
  () => qty.value,
  (newValue) => {
    console.log(newValue);
  }
);

onMounted(() => {
  // Code to run when the component is mounted
});
</script>
