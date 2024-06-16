<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <slot name="toolbar"></slot>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th v-for="header in headers" :key="header.key" scope="col" class="px-6 py-3">
                    {{ header.label }}
                </th>
                <th v-if="$slots.actions" class="px-6 py-3 bg-gray-50 text-left">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!loading && data.length === 0">
                <td :colspan="headers.length + ($slots.actions ? 1 : 0)" class="px-6 py-4 text-center">
                    <slot name="empty">No data available</slot>
                </td>
            </tr>
            <tr v-else v-for="row in data" :key="row.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td v-for="header in headers" :key="header.key" class="px-6 py-4">
                    <slot :name="header.key" :row="row">
                        {{ getNestedValue(row, header.key) }}
                    </slot>
                </td>
                <td v-if="$slots.actions" class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    <slot name="actions" :row="row"></slot>
                </td>
            </tr>
            <tr v-if="loading">
                <td :colspan="headers.length + ($slots.actions ? 1 : 0)" class="px-6 py-4 text-center">
                    Loading...
                </td>
            </tr>
            </tbody>
        </table>

        <slot name="pagination"></slot>
    </div>
</template>

<script>
export default {
    props: {
        headers: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true,
            default: () => [] // Add a default value for data prop
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        getNestedValue(obj, path) {
            return path.split('.').reduce((acc, part) => acc && acc[part], obj);
        }
    }
}
</script>

<style>
th {
    display: table-cell;
    vertical-align: inherit;
    font-weight: bold;
    text-align: -internal-center;
    unicode-bidi: isolate;
}
</style>
