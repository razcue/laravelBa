<template>
    <div class="products">
        <h1 class="products__section-title">Products</h1>
        <Toast />
        <Button v-if="$page?.props.authorization?.can['product-create']"
            label="Create Product" class="products__button products__button--create" @click="triggerCreate" />
        <DataTable :value="products" class="products__table"
            v-if="$page?.props.authorization?.can['product-list']
              || $page?.props.authorization?.can['product-edit']
              || $page?.props.authorization?.can['product-delete']">
            <Column header="Title" class="products__column products__column--title">
                <template #body="slotProps">
                    <img :src="slotProps.data.image" alt="Watch" width="70px" class="products__image">
                    <p class="products__title">{{slotProps.data.title}}</p>
                </template>
            </Column>
            <Column field="description" header="Description" class="products__column products__column--description"></Column>
            <Column field="price" header="Price" class="products__column products__column--price"></Column>
            <Column header="Actions" class="products__column products__column--actions"
                v-if="$page?.props.authorization?.can['product-edit'] || $page?.props.authorization?.can['product-delete']">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" class="products__button products__button--edit"
                        v-if="$page?.props.authorization?.can['product-edit']" @click="triggerEdit(slotProps.data)" />
                    <Button icon="pi pi-trash" class="products__button products__button--delete"
                        v-if="$page?.props.authorization?.can['product-delete']" @click="triggerDelete(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { router } from '@inertiajs/vue3';

defineProps({
    products: Object,
})

const toast = useToast();

const triggerEdit = (item) => {
    router.visit(route('products.edit', item.id));
};

const triggerDelete = async (item) => {
    if (confirm('Are you sure you want to delete this product?')) {
        await router.delete(route('products.destroy', item.id));
        toast.add({ severity: 'info', summary: 'Success', detail: 'Product deleted', life: 3000 });
    }
};

const triggerCreate = () => {
    router.visit(route('products.create'));
};
</script>

<style lang="scss">
.products {
    &__section-title {
        font-size: 24px;
        font-weight: 600;
        color: #3F51B5;
        margin-bottom: 16px;
    }

    &__title {
        font-size: 18px;
        color:#212121;
        display:inline-block;
    }

    &__table {
        width: 100%;
        margin-top: 16px;

        .products__column {
            padding: 16px;
            border-bottom: 1px solid #E0E0E0;

            &--title {
                .products__title {
                    margin: 4px 0;
                }
            }

            &--title,
            &--description,
            &--price,
            &--actions {
                text-align: left;
                padding-top: 12px;
                padding-bottom: 12px;
            }
        }
    }

    &__image {
        margin: 0 0 0 25%;
        border-radius: 4px;
    }

    &__button {
        margin: 16px 0;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        background-color: #3F51B5;
        color: #FFFFFF;
        cursor: pointer;
        transition: background-color 0.3s;

        &:hover {
            background-color: #303F9F;
        }

        &--edit {
            background-color: #4CAF50;

            &:hover {
                background-color: #388E3C;
            }
        }

        &--delete {
            background-color: #F44336;
            margin: 16px 0 16px 8px;

            &:hover {
                background-color: #D32F2F;
            }
        }

        &--create {
            width: min(20vw, 300px);
        }
    }
}
</style>
