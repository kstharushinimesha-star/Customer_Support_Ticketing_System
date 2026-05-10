<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// Controller එකෙන් එවන දත්ත ලබා ගැනීම
defineProps({ tickets: Array });

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
    <AppLayout title="Support Tickets">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900">Create New Ticket</h3>
                <form @submit.prevent="submit" class="mt-4 space-y-4">
                    <input v-model="form.subject" type="text" placeholder="Subject" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <textarea v-model="form.description" placeholder="Description" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    
                    <div class="flex space-x-4">
                        <select v-model="form.priority" class="rounded-md border-gray-300">
                            <option>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                        <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                            Submit Ticket
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    <li v-for="ticket in tickets" :key="ticket.id" class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-bold text-indigo-600">{{ ticket.subject }}</h4>
                            <span :class="ticket.status === 'Open' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'" class="px-2 py-1 rounded text-sm">
                                {{ ticket.status }}
                            </span>
                        </div>
                        <p class="text-gray-600 mt-2">{{ ticket.description }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            Priority: {{ ticket.priority }} | Category: {{ ticket.category }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>