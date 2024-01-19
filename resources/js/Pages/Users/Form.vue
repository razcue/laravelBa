<template>
    <div class="create-user">
        <h1 class="create-user__title">
            <Link class="create-user__link" :href="route('users.index')">Users</Link>
            <span class="create-user__separator"> / </span>{{ action }}
        </h1>
        <Toast />
        <div class="create-user__form-container">
            <form @submit.prevent="handleSubmit">
                <div class="create-user__form">
                    <InputText v-model="user.name" placeholder="Name" />
                    <InputText v-model="user.email" placeholder="Email" />
                    <Password v-model="user.password" placeholder="Password" />
                    <Dropdown v-model="user.role_id" :options="roleOptions"
                        option-value="id" optionLabel="label" placeholder="Select a Role"/>
                    <div class="create-user__form-image-input-wrapper">
                        <FileUpload v-model="user.image" mode="basic" :auto="true"
                            :chooseLabel="user.image ? 'Change Photo' : 'Choose Photo'"
                            url="/upload" accept="image/*" label="Photo" @upload="handleUpload" />
                        <img class="create-user__form-image-input-wrapper-preview"
                            v-if="user.image" :src="user.image"></img>
                    </div>
                </div>
                <div class="create-user__submit">
                    <Button type="submit" :label="`${action} User`" />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, reactive, watch } from 'vue'
import Button from 'primevue/button';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { router } from "@inertiajs/vue3";

const emptyUser = {
    name: '',
    email: '',
    password: '',
    role_id: null,
    image: '',
};

export default {
    components: {
        Button,
        Dropdown,
        FileUpload,
        InputText,
        Password,
        Toast,
    },
    props: {
        user: Object,
        action: String,
        rolesDataSet: Object,
    },
    setup(props) {
        const roleOptions = ref(props.rolesDataSet);

        const toast = useToast();

        const user = reactive((props.action === 'Edit' && props.user) || emptyUser);

        watch(() => props.action, (newAction) => {
            if (newAction === 'Create') {
                Object.assign(user, emptyUser);
            }
        });

        const handleSubmit = () => {
            const imageParts = user.image?.split('/');
            const data = {
                ...user,
                image: imageParts && imageParts[imageParts.length - 1],
            };
            if (props.action === 'Create') {
                router.post(route('users.store'), data);
            } else if (props.action === 'Edit') {
                router.put(route('users.update', user.id), data);
            }
        };

        const handleUpload = (event) => {
            if (event.files && event.files[0]) {
                user.image = JSON.parse(event.xhr.response).url;
                toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
            }
        };

        return {
            roleOptions,
            user,
            handleSubmit,
            handleUpload,
            toast,
        }
    },
}
</script>

<style lang="scss">
.create-user {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

    &__title {
        font-size: 24px;
        color: #333;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    &__link {
        color: #007bff;
        text-decoration: none;

        &:hover {
            text-decoration: underline;
        }
    }

    &__separator {
        color: #ccc;
    }

    &__form-container {
        padding: 20px;

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    }

    &__form {
        display: flex;
        flex-direction: column;
        gap: 10px;

        input, select, button, div > input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
            flex: auto;
        }

        &-image-input-wrapper {
            display: flex;
            align-items: flex-end;
            gap: 14px;

            &-preview {
                width: 200px;
                height: 200px;
                object-fit: cover;
            }
        }
    }

    &__submit {
        display: flex;
        justify-content: flex-end;

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;

            &:hover {
                background-color: #0056b3;
            }
        }
    }
}
</style>
