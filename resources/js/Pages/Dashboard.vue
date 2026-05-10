<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

// Controller එකෙන් (TicketController@index) එවන දත්ත ලබා ගැනීම
const props = defineProps({
    tickets: Array,
    auth: Object
});

// අලුත් ටිකට්පතක් සෑදීමට අවශ්‍ය Form එක
const form = useForm({
    subject: '',
    description: '',
    category: 'Technical',
    priority: 'Medium',
});

const submit = () => {
    form.post(route('tickets.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Support Ticketing Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div v-if="props.auth.user.role !== 'admin'" class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Submit a New Ticket</h3>
                    <form @submit.prevent="submit" class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <input v-model="form.subject" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea v-model="form.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3" required></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select v-model="form.category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option>Technical</option>
                                    <option>Billing</option>
                                    <option>General</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Priority</label>
                                <select v-model="form.priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition" :disabled="form.processing">
                                    Create Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ props.auth.user.role === 'admin' ? 'All Support Tickets' : 'My Support Tickets' }}
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="ticket in tickets" :key="ticket.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ ticket.id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ticket.subject }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="{
                                                'bg-green-100 text-green-800': ticket.status === 'Open',
                                                'bg-yellow-100 text-yellow-800': ticket.status === 'In Progress',
                                                'bg-gray-100 text-gray-800': ticket.status === 'Resolved'
                                            }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ ticket.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ticket.priority }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link :href="route('tickets.show', ticket.id)" class="text-indigo-600 hover:text-indigo-900">View Details</Link>
                                        </td>
                                    </tr>
                                    <tr v-if="tickets.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No tickets found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>