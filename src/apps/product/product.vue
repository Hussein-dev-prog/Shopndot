<template>
  <div :key="product.id" class="card mt-4" style="width: 18rem">
    <img
      :src="product.image"
      :alt="product.name"
      style="height: 200px; object-fit: contain"
    />
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
    <div class="card-body p-4">
      <div class="text-center">
        <!-- Product name -->
        <h5 class="fw-bolder">{{ product.name.slice(0, 15) }}</h5>
        <!-- Supplier name -->
        <a
          :href="`?r=site%2Fdisplayshop&id=${product.id}`"
          class=""
          style="text-decoration: none; color: darkred"
        >
          <p class="supplier-name">
            <i class="bi bi-shop"></i>
            {{ product.supplierId }}
          </p>
        </a>
        <!-- Product price -->
        ${{ product.price }}
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
      </div>
    </div>
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
      <div class="text-center">
        <a
          :href="`?r=site%2Fdisplayproduct&id=${product.id}`"
          class="btn btn-outline-dark mt-auto view-button"
        >
          <i class="bi bi-eye-fill"></i>
        </a>
        <button
          class="btn btn-outline-dark mt-auto wishlist-button"
          :class="{}"
          :disabled="product.quantity === 0"
          @click="addToWishList(product.id)"
        >
          <i class="bi bi-heart-fill"></i>
        </button>
        <button
          class="btn btn-outline-dark mt-auto cart-button"
          :class="{}"
          @click="addToCart(product.id, qty)"
          :disabled="product.quantity === 0"
        >
          <i class="bi bi-cart-fill"></i>
        </button>
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
