<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

// Controller එකෙන් එවන දත්ත ලබා ගැනීම
const props = defineProps({
    tickets: Array,
    auth: Object
});

// Ticket එකක් සෑදීමට අවශ්‍ය Form එක
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
                        <input v-model="form.subject" type="text" placeholder="Subject" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500" required>
                        <textarea v-model="form.description" placeholder="Describe your issue..." class="rounded-md border-gray-300 shadow-sm" rows="3" required></textarea>
                        
                        <div class="flex gap-4">
                            <select v-model="form.category" class="rounded-md border-gray-300 shadow-sm">
                                <option>Technical</option>
                                <option>Billing</option>
                                <option>General</option>
                            </select>
                            <select v-model="form.priority" class="rounded-md border-gray-300 shadow-sm">
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition" :disabled="form.processing">
                                Create Ticket
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ props.auth.user.role === 'admin' ? 'All Support Tickets' : 'My Support Tickets' }} [cite: 13, 15]
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="ticket in tickets" :key="ticket.id">
                                        <td class="px-6 py-4 whitespace-nowrap">#{{ ticket.id }}</td>
                                        <td class="px-6 py-4 font-medium">{{ ticket.subject }}</td>
                                        <td class="px-6 py-4">
                                            <span :class="{
                                                'bg-green-100 text-green-800': ticket.status === 'Open',
                                                'bg-yellow-100 text-yellow-800': ticket.status === 'In Progress',
                                                'bg-gray-100 text-gray-800': ticket.status === 'Resolved'
                                            }" class="px-2 py-1 rounded-full text-xs font-semibold">
                                                {{ ticket.status }} [cite: 16]
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ ticket.priority }}</td>
                                        <td class="px-6 py-4">
                                            <Link :href="route('tickets.show', ticket.id)" class="text-indigo-600 hover:text-indigo-900">View Details</Link>
                                        </td>
                                    </tr>
                                    <tr v-if="tickets.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No tickets found.</td>
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