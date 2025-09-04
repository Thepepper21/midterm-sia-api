<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
//{router}{watch}
type PexelsPhoto = {
    id: number;
    width: number;
    height: number;
    url: string;
    photographer: string;
    src: {
        original: string;
        large2x: string;
        large: string;
        medium: string;
        small: string;
        portrait: string;
        landscape: string;
        tiny: string;
    };
};

const query = ref<string>('nature');
const page = ref<number>(1);
const perPage = ref<number>(24);
const photos = ref<PexelsPhoto[]>([]);
const totalResults = ref<number>(0);
const loading = ref<boolean>(false);
const errorMessage = ref<string>('');

async function search() {
    loading.value = true;
    errorMessage.value = '';
    try {
        const params = new URLSearchParams({ q: query.value, page: String(page.value), per_page: String(perPage.value) });
        const res = await fetch(`/api/pexels/search?${params.toString()}`);
        if (!res.ok) throw new Error('Search failed');
        const data = await res.json();
        photos.value = data.photos ?? [];
        totalResults.value = data.total_results ?? 0;
    } catch (err: any) {
        errorMessage.value = err?.message || 'Something went wrong';
    } finally {
        loading.value = false;
    }
}

function onSubmit(e: Event) {
    e.preventDefault();
    page.value = 1;
    search();
}

function nextPage() {
    if (photos.value.length === 0) return;
    page.value += 1;
    search();
}

function prevPage() {
    if (page.value <= 1) return;
    page.value -= 1;
    search();
}

onMounted(() => {
    search();
});
</script>

<template>
    <Head title="Gallery" />
    <div class="p-6 space-y-6">
        <h1 class="text-2xl font-semibold">Image Gallery</h1>

        <form class="flex gap-2" @submit="onSubmit">
            <input
                v-model="query"
                type="text"
                placeholder="Search images (e.g., cats, mountains)"
                class="flex-1 border rounded px-3 py-2"
            />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="loading">Search</button>
        </form>

        <div v-if="errorMessage" class="text-red-600 text-sm">{{ errorMessage }}</div>
        <div v-if="loading">Loading...</div>

        <div v-if="!loading && photos.length === 0" class="text-sm text-gray-500">No results</div>

        <div v-if="photos.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <a v-for="p in photos" :key="p.id" :href="p.url" target="_blank" rel="noopener noreferrer" class="group block">
                <img :src="p.src.medium" :alt="p.photographer" class="w-full h-48 object-cover rounded" />
                <div class="mt-1 text-xs text-gray-600 truncate">{{ p.photographer }}</div>
            </a>
        </div>

        <div class="flex items-center justify-between" v-if="photos.length">
            <button class="px-3 py-2 border rounded" @click="prevPage" :disabled="loading || page === 1">Previous</button>
            <div class="text-sm">Page {{ page }}</div>
            <button class="px-3 py-2 border rounded" @click="nextPage" :disabled="loading">Next</button>
        </div>
    </div>
</template>

<style scoped>
</style>


