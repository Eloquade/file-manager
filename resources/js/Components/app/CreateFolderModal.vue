<script setup>
import { nextTick, ref } from "vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "../InputLabel.vue";
import TextInput from "../TextInput.vue";
import InputError from "../InputError.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "../SecondaryButton.vue";
import PrimaryButton from "../PrimaryButton.vue";
import { usePage } from "@inertiajs/vue3";

const emit = defineEmits(["update:modelValue"]);
const folderNameInput = ref(null);
const { modelValue } = defineProps({
    modelValue: Boolean,
});

const page = usePage();

const form = useForm({
    name: "",
    parent_id: null,
});

function createFolder() {
    if (page.props.folder) {
        form.parent_id = page.props.folder.id;
    } else {
        form.parent_id = null;
    }
    console.log("Creating folder with parent ID:", form.parent_id);
    console.log(route('folder.create'));
    form.post(route('folder.create'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
        onError: () => {
            nextTick(() => {
                folderNameInput.value.focus();
            });
        }
    });
}

function closeModal() {
    emit("update:modelValue", false);
    form.clearErrors();
    form.reset();
}

function onShow() {
    nextTick(() => 
        folderNameInput.value.focus()
    );
}


</script>

<template>
    <modal
        :show="modelValue"
        @show="onShow"
        @keydown.esc="closeModal"
        tabindex="0"
        max-width="sm"
    >
        <div class="p-6">
            <h2>Create New Folder</h2>
            <div class="mt-6">
                <InputLabel for="folderName" value="Folder Name" />
                <TextInput
                    type="text"
                    ref="folderNameInput"
                    placeholder="Folder Name"
                    id="folderName"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    :class="
                        form.errors.name
                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                            : ''
                    "
                    @keyup.enter="createFolder"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                <PrimaryButton
                    @click="createFolder"
                    class="ml-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </modal>
</template>

<style scoped></style>
