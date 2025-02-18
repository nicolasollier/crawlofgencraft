<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CharacterInfos from '@/Layouts/CharacterInfos.vue';
import { useCharacterStore } from '@/stores/characterStore';
import { storeToRefs } from 'pinia';

const characterStore = useCharacterStore();
const { hasCharacters, currentCharacter, inventory } = storeToRefs(characterStore);

</script>

<template>
    <AuthenticatedLayout>
        <div v-if="hasCharacters" class="grid flex-1 gap-4 h-full overflow-hidden p-4 md:grid-cols-2 lg:grid-cols-3">
            <CharacterInfos :currentCharacter="currentCharacter" :inventory="inventory" />
            <div class="relative flex flex-col h-full rounded-xl bg-muted/50 py-8 px-12 lg:col-span-2 overflow-hidden">
            </div>
        </div>
    </AuthenticatedLayout>
</template>