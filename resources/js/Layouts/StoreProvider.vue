<script setup>
import { onMounted, watch } from 'vue';
import { useCharacterStore } from '@/stores/characterStore';
import { useDungeonStore } from '@/stores/dungeonStore';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();

watch(() => page.props?.characters, (newCharacters) => {
    if (newCharacters) {
        characterStore.setCharacters(newCharacters);
    }
}, { immediate: true });

watch(() => page.props?.dungeons, (newDungeons) => {
    if (newDungeons) {
        dungeonStore.initializeStore(newDungeons);
    }
}, { immediate: true });

onMounted(() => {
    if (page.props?.characters) {
        characterStore.setCharacters(page.props.characters);
    }
    
    if (page.props?.dungeons) {
        dungeonStore.initializeStore(page.props.dungeons);
    }
});
</script>

<template>
    <slot></slot>
</template> 