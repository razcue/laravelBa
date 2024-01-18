<template>
    <div class="layout">
        <SideMenu v-if="$page?.props.auth" class="layout__sidemenu"/>
        <div class="layout__slot">
            <slot/>
        </div>
    </div>
</template>

<script setup>
import SideMenu from "@/Layouts/SideMenu.vue";
</script>

<style lang="scss">
.layout {
    display: flex;
    height: 100vh;

    &__sidemenu {
        width: 250px;
        background-color: #f5f5f5;
        overflow: auto;
    }

    &__slot {
        padding: 20px;
        flex-grow: 1;
        overflow: auto;
        background-color: #fff;
    }
}

</style>
