<script setup>
import { onMounted } from 'vue';
import { useCharacterStore } from '@/stores/characterStore';
import { useDungeonStore } from '@/stores/dungeonStore';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();

onMounted(() => {
    if (!characterStore.isInitialized && page.props.characters) {
        characterStore.initializeStore(page.props.characters);
    }
    
    if (!dungeonStore.isInitialized && page.props.dungeons) {
        dungeonStore.initializeStore(page.props.dungeons);
    }
});
</script>

<template>
    <slot></slot>
</template> 