<script setup lang="ts">
    import { ref } from 'vue';
    const mssg = ref<string>('');
</script>

<template>
    <div>
        <h1>Hello niggas</h1>
    </div>
    <h1>{{mssg}}</h1>
    <input v-model="mssg" placeholder="example..."/>
</template>
