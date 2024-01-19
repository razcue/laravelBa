<template>
    <div class="layout">
        <SideMenu v-if="$page?.props.auth.user" class="layout__sidemenu"/>
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
        background-color: #f5f5f5;
        overflow: auto;
        min-width: max(200px, 16vw);
    }

    &__slot {
        padding: 20px;
        flex: auto;
        overflow: auto;
        background-color: #fff;
    }
}

</style>
