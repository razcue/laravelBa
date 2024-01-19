<template>
    <div class="users">
        <h1 class="users__section-title">Users</h1>
        <Toast />
        <Button v-if="$page?.props.authorization?.can['user-create']"
            label="Create User" class="users__button users__button--create" @click="triggerCreate" />
        <DataTable :value="users" class="users__table"
            v-if="$page?.props.authorization?.can['user-list']
              || $page?.props.authorization?.can['user-edit']
              || $page?.props.authorization?.can['user-delete']">
            <Column header="Name" class="users__column users__column--name">
                <template #body="slotProps">
                    <img :src="slotProps.data.image" alt="Watch" width="70px" class="users__image">
                    <p class="users__name">{{slotProps.data.name}}</p>
                </template>
            </Column>
            <Column field="role" header="Role" class="users__column users__column--role"></Column>
            <Column field="email" header="Email" class="users__column users__column--email"></Column>
            <Column header="Actions" class="users__column users__column--actions"
                v-if="$page?.props.authorization?.can['user-edit'] || $page?.props.authorization?.can['user-delete']">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" class="users__button users__button--edit"
                        v-if="$page?.props.authorization?.can['user-edit']" @click="triggerEdit(slotProps.data)" />
                    <Button icon="pi pi-trash" class="users__button users__button--delete"
                        v-if="$page?.props.authorization?.can['user-delete']" @click="triggerDelete(slotProps.data)" />
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
    users: Object,
})

const toast = useToast();

const triggerEdit = (item) => {
    router.visit(route('users.edit', item.id));
};

const triggerDelete = async (item) => {
    if (confirm('Are you sure you want to delete this user?')) {
        await router.delete(route('users.destroy', item.id));
        toast.add({ severity: 'info', summary: 'Success', detail: 'User deleted', life: 3000 });
    }
};

const triggerCreate = () => {
    router.visit(route('users.create'));
};
</script>

<style lang="scss">
.users {
    &__section-title {
        font-size: 24px;
        font-weight: 600;
        color: #3F51B5;
        margin-bottom: 16px;
    }

    &__name {
        font-size: 18px;
        color:#212121;
        display:inline-block;
    }

    &__table {
        width: 100%;
        margin-top: 16px;

        .users__column {
            padding: 16px;
            border-bottom: 1px solid #E0E0E0;

            &--name {
                .users__name {
                    margin: 4px 0;
                }
            }

            &--name,
            &--role,
            &--email,
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

