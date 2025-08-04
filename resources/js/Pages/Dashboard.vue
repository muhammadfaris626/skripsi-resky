<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    defineProps(["employees", "targets", 'sales']);
    const amountRupiah = (number) => {
        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(number);
        return formatted;
    }
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="p-4 items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-xl text-gray-400 dark:text-gray-500">
                    EMPLOYEES
                </p>
                <p class="text-2xl font-bold text-black dark:text-gray-500">
                    {{ employees }}
                </p>
            </div>
            <div class="p-4 items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-xl text-gray-400 dark:text-gray-500">
                    TARGETS
                </p>
                <p class="text-2xl font-bold text-black dark:text-gray-500">
                    {{ amountRupiah(targets) }}
                </p>
            </div>
            <div class="p-4 items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-xl text-gray-400 dark:text-gray-500">
                    SALES
                </p>
                <p class="text-2xl font-bold text-black dark:text-gray-500">
                    {{ amountRupiah(sales) }}
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
