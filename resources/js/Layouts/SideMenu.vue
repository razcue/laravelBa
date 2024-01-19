<template>
    <div class="sidemenu">
        <Link v-if="$page?.props.authorization?.can['user-list']"
            class="sidemenu__link" :href="route('users.index')">Users</Link>
        <Link v-if="$page?.props.authorization?.can['product-list']"
            class="sidemenu__link" :href="route('products.index')">Products</Link>
        <div class="border-t border-gray-200" />
        <p class="sidemenu__user-name">Hello {{ $page?.props.auth?.user?.name }}</p>
        <form @submit.prevent="logout">
            <Button class="sidemenu__link" type="submit" label="Log Out" />
        </form>
    </div>
</template>

<script setup>
import Button from "primevue/button";
import { router } from "@inertiajs/vue3";

const logout = () => {
    router.post(route('logout'));
};
</script>

<style lang="scss">
.sidemenu {
    padding: 20px;
    border-right: 1px solid #ddd;

    &__link {
        padding: 10px 0;
        display: block;
        color: #333;
        text-decoration: none;

        &:hover {
            color: #007bff;
            cursor: pointer;
        }
    }

    &__user-name {
        padding: 10px 0;
        display: block;
        color: #6E6E6E;
        text-decoration: none;
    }
}
</style>
