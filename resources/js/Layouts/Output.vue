<script setup>
import Badge from "@/Components/ui/badge/Badge.vue";
import Button from "@/Components/ui/button/Button.vue";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { useDungeonStore } from '@/stores/dungeonStore';
import { useCharacterStore } from '@/stores/characterStore';
import { ref, computed } from 'vue';
import { PlusCircle, Castle } from "lucide-vue-next";
import { useForm } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';

const characterStore = useCharacterStore();

const dungeonStore = useDungeonStore();
const { currentDungeon, hasDungeons } = storeToRefs(dungeonStore);

const currentRoom = computed(() => {
    if (!currentDungeon.value || !currentDungeon.value.rooms || currentDungeon.value.rooms.length === 0) {
        return null;
    }
    return currentDungeon.value.rooms[currentDungeon.value.room_count];
});

const userMessage = ref('');

const dungeonSize = ref('medium');
const dungeonSizes = [
    { value: 'small', label: 'Petit' },
    { value: 'medium', label: 'Moyen' },
    { value: 'large', label: 'Grand' },
];

const placeholderOptions = [
    { value: 'go_east', label: 'Aller à l\'est' },
    { value: 'go_west', label: 'Aller à l\'ouest' },
    { value: 'go_north', label: 'Aller au nord' },
    { value: 'go_south', label: 'Aller au sud' },
]

const form = useForm({
    size: dungeonSize.value,
    character_id: computed(() => characterStore.currentCharacter?.id),
});

const createDungeon = () => {
    form.post(route('dungeon.create'), {
        preserveScroll: true,
        onSuccess: (response) => {
            dungeonStore.addDungeon(response.data);
            dungeonStore.setCurrentDungeon(response.data);
        },
    });
};

const submitMessage = (action) => {
    // Implement message submission logic here
    console.log(action);
};
</script>

<template>
    <div class="relative flex flex-col h-full rounded-xl bg-muted/50 py-8 px-12 lg:col-span-2 overflow-hidden">
        <div v-if="!hasDungeons || !currentDungeon" class="flex flex-col h-full justify-center items-center">
            <div class="text-center flex flex-col items-center">
                <h2 class="text-3xl font-bold tracking-tight mb-1">Pas encore de donjon ?</h2>
                <p class="text-muted-foreground text-md mb-6">
                    Créez votre premier donjon et commencez votre aventure !
                </p>
                <div class="mb-4">
                    <Select v-model="dungeonSize">
                        <SelectTrigger class="w-48 mb-2">
                            <SelectValue placeholder="Taille du donjon" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="size in dungeonSizes" :key="size.value" :value="size.value">
                                {{ size.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>

            <img class="mx-auto mb-10 w-full max-w-sm object-cover opacity-85"
                src="https://res.cloudinary.com/dnqqx8hbb/image/upload/empty_dungeon_placeholder_lmnfoy.png"
                alt="Créez votre donjon" draggable="false" />

            <Button size="lg" @click.prevent="createDungeon">
                <PlusCircle class="mr-2 h-5 w-5" />
                Créer un donjon
            </Button>
        </div>

        <div v-else-if="currentRoom" class="flex flex-col h-full">
            <div class="flex flex-wrap items-center text-sm pb-4 mb-4 gap-2">
                <span class="flex items-center text-zinc-800 font-semibold">
                    <Castle class="inline-block w-4 h-4 mr-2" />
                    Donjon {{ currentDungeon.size }}
                </span>
                <span class="inline text-zinc-400">|</span>
                <span class="text-zinc-800 font-semibold">Salle {{ currentRoom.room_number }}</span>
            </div>

            <!-- Simulate big room description here -->
            <div class="text-sm text-zinc-800">
                <p>
                    {{ currentRoom.description }}
                </p>
            </div>

            <!-- Spacer to push the buttons to the bottom -->
            <div class="flex-grow"></div>

            <!-- Action buttons -->
            <div class="mt-4 space-y-2 sm:space-y-0 sm:space-x-2 sm:flex sm:flex-wrap">
                <Button
                  v-for="option in currentRoom.options"
                  :key="option"
                  @click="submitMessage(option)"
                  class="w-full sm:w-auto"
                >
                  {{ option }}
                </Button>
            </div>
        </div>
    </div>
</template>
