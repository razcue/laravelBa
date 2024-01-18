<template>
    <div class="create-product">
        <h1 class="create-product__title">
            <Link class="create-product__link" :href="route('products.index')">Products</Link>
            <span class="create-product__separator"> / </span>{{ action }}
        </h1>
        <Toast />
        <div class="create-product__form-container">
            <form @submit.prevent="handleSubmit">
                <div class="create-product__form">
                    <InputText v-model="product.title" placeholder="Name" />
                    <span class="p-float-label create-product__form-textarea-wrapper">
                        <Textarea v-model="product.description" rows="5" cols="30" />
                        <label>Description</label>
                    </span>
                    <InputNumber v-model="product.price" placeholder="Price"
                        v-bind:step="0.01" v-bind:minFractionDigits="2" v-bind:maxFractionDigits="2" />
                    <div class="create-product__form-image-input-wrapper">
                        <FileUpload v-model="product.image" mode="basic" :auto="true"
                            :chooseLabel="product.image ? 'Change Photo' : 'Choose Photo'"
                            url="/upload" accept="image/*" label="Photo" @upload="handleUpload" />
                        <img class="create-product__form-image-input-wrapper-preview" v-if="product.image" :src="product.image"></img>
                    </div>
                </div>
                <div class="create-product__submit">
                    <Button type="submit" :label="`${action} Product`" />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, watch } from 'vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';
import FileUpload from 'primevue/fileupload';
import Textarea from 'primevue/textarea';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { router } from "@inertiajs/vue3";

const emptyProduct = {
    title: '',
    description: '',
    price: null,
    image: '',
};

export default {
    components: {
        InputText,
        InputNumber,
        Button,
        FileUpload,
        Textarea,
        Toast,
    },
    props: {
        product: Object,
        action: String,
    },
    setup(props) {
        const toast = useToast();

        const product = reactive((props.action === 'Edit' && props.product) || emptyProduct);

        watch(() => props.action, (newAction) => {
            if (newAction === 'Create') {
                Object.assign(product, emptyProduct);
            }
        });

        const handleSubmit = () => {
            const imageParts = product.image?.split('/');
            const data = {
                ...product,
                image: imageParts && imageParts[imageParts.length - 1],
                price: parseFloat(product.price),
            };
            if (props.action === 'Create') {
                router.post(route('products.store'), data);
            } else if (props.action === 'Edit') {
                router.put(route('products.update', product.id), data);
            }
        };

        const handleUpload = (event) => {
            if (event.files && event.files[0]) {
                product.image = JSON.parse(event.xhr.response).url;
                toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
            }
        };

        return {
            product,
            handleSubmit,
            handleUpload,
            toast,
        };
    },
};
</script>

<style lang="scss">
.create-product {
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

        input, select, button, textarea, div > input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
            flex: auto;
            width: 100%;
        }

        &-textarea-wrapper {
            textarea:focus,
            textarea.p-filled {
                margin: 10px 0 0 0;
            }

            textarea:focus ~ label,
            textarea.p-filled ~ label {
                top: -.05rem;
            }
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
