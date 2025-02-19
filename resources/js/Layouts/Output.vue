<script setup>
import Button from "@/Components/ui/button/Button.vue";
import { CardHeader, CardTitle, CardContent, CardFooter } from "@/Components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { PlusCircle, Castle, Skull, Sparkles } from "lucide-vue-next";
import { useForm } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { ref, computed, watch, onMounted } from 'vue';

import { useDungeonStore } from '@/stores/dungeonStore';
import { useCharacterStore } from '@/stores/characterStore';

const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();
const { currentDungeon, hasDungeons } = storeToRefs(dungeonStore);

const currentRoom = computed(() => {
    if (!currentDungeon.value || !currentDungeon.value.rooms || currentDungeon.value.rooms.length === 0) {
        return null;
    }
    return currentDungeon.value.rooms[currentDungeon.value.room_count];
});

const currentRoomType = computed(() => {
    return roomTypes.find(type => type.value === currentRoom.value.type)?.label;
});

const isLoading = ref(false);
const dungeonSize = ref('medium');
const typedDescription = ref('');
const showButtons = ref(false);
const isTyping = ref(false);

const dungeonSizes = [
    { value: 'small', label: 'Petit' },
    { value: 'medium', label: 'Moyen' },
    { value: 'large', label: 'Grand' },
];

const roomTypes = [
    { value: 'start', label: 'Entrée' },
    { value: 'encounter', label: 'Combat' },
    { value: 'trapped', label: 'Piège' },
    { value: 'treasure', label: 'Trésor' },
    { value: 'enigma', label: 'Enigme' },
    { value: 'empty', label: 'Vide' },
    { value: 'exit', label: 'Sortie' },
];

const form = useForm({
    size: computed(() => dungeonSize.value),
    character_id: computed(() => characterStore.currentCharacter?.id),
    dungeon_id: computed(() => currentDungeon.value?.id),
    action: null,
});

const createDungeon = () => {
    isLoading.value = true;
    form.post(route('dungeon.create'), {
        preserveScroll: true,
        onSuccess: (response) => {
            if (response.props.dungeons) {
                dungeonStore.initializeStore(response.props.dungeons);
                const newDungeon = response.props.dungeons[response.props.dungeons.length - 1];
                if (newDungeon) {
                    dungeonStore.setCurrentDungeon(newDungeon);
                }
            }
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        },
    });
};

const exitDungeon = () => {
    form.delete(route('dungeon.destroy', dungeonStore.currentDungeon.id), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: () => {
            dungeonStore.setCurrentDungeon(null);
        },
    });
};

const deleteCharacter = () => {
    form.delete(route('character.delete', characterStore.currentCharacter.id), {
        preserveState: false,
        onSuccess: () => {
            characterStore.setCurrentCharacter(null)
        }
    })
}

const submitMessage = (action) => {
    if (action === "Sortir du donjon") {
        exitDungeon()
        return
    }
    if(action === "Recommencer") {
        deleteCharacter()
        return
    }

    isLoading.value = true;
    showButtons.value = false;
    form.action = action;
    form.post(route('dungeon.progress'), {
        preserveScroll: true,
        onSuccess: (response) => {
            const updatedDungeon = response.props.dungeons.find(d => d.id === currentDungeon.value.id);
            if (updatedDungeon) {
                dungeonStore.setCurrentDungeon(updatedDungeon);
            }
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        },
    });
};

const typeDescription = (text) => {
    if (!text) return;
    
    isTyping.value = true;
    typedDescription.value = '';
    showButtons.value = false;
    
    let index = 0;
    const interval = setInterval(() => {
        if (index < text.length) {
            typedDescription.value += text[index];
            index++;
        } else {
            clearInterval(interval);
            isTyping.value = false;
            showButtons.value = true;
        }
    }, 15);
};

watch(() => currentRoom.value?.description, (newDescription) => {
    if (newDescription) {
        setTimeout(() => {
            typeDescription(newDescription);
        }, 100);
    }
});

onMounted(() => {
    if (currentRoom.value?.description) {
        setTimeout(() => {
            typeDescription(currentRoom.value.description);
        }, 100);
    }
});
</script>

<template>
    <div class="bg-zinc-100 rounded-md flex flex-col lg:col-span-2 items-center p-4">
        <div v-if="!hasDungeons || !currentDungeon" class="w-full h-full flex flex-col items-center justify-between">
            <CardHeader class="w-full max-w-md pb-2">
                <CardTitle class="text-center text-2xl font-bold mb-4 leading-2">
                    Créez votre premier donjon et commencez votre aventure !
                </CardTitle>
                <div class="w-full flex justify-center">
                    <Select v-model="dungeonSize" :disabled="isLoading">
                        <SelectTrigger class="w-48 mb-2 bg-zinc-50">
                            <SelectValue placeholder="Taille du donjon" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="size in dungeonSizes" :key="size.value" :value="size.value">
                                {{ size.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </CardHeader>

            <CardContent class="w-full max-w-md flex flex-col items-center">
                <img class="h-[40vh] w-auto max-w-full mx-auto object-contain object-top opacity-85"
                    src="https://res.cloudinary.com/dnqqx8hbb/image/upload/empty_dungeon_placeholder_lmnfoy.png"
                    alt="Créez votre donjon" draggable="false" />
            </CardContent>

            <CardFooter class="w-full max-w-md flex justify-center">
                <Button size="lg" @click.prevent="createDungeon" :disabled="isLoading" class="w-48">
                    <PlusCircle class="mr-2 h-5 w-5" />
                    {{ isLoading ? 'Création...' : 'Créer un donjon' }}
                </Button>
            </CardFooter>
        </div>

        <div v-else-if="currentRoom" class="w-full h-full flex flex-col">
            <CardHeader>
                <div class="flex flex-wrap items-center text-sm pb-4 mb-4 gap-2">
                    <span class="flex items-center text-zinc-800 font-semibold">
                        <Castle class="inline-block w-4 h-4 mr-2" />
                        Donjon {{ currentDungeon.size }}
                    </span>
                    <span class="inline text-zinc-400">|</span>
                    <span class="text-zinc-800 font-semibold">Salle {{ currentRoom.room_number }}</span>
                    <span class="inline text-zinc-400">|</span>
                    <span class="flex items-center text-zinc-800 font-semibold">
                        <Skull v-if="!currentRoom.is_success" class="inline-block w-4 h-4 mr-1.5" />
                        <Sparkles v-else class="inline-block w-4 h-4 mr-1.5" />
                        {{ currentRoomType }}
                    </span>
                </div>
            </CardHeader>

            <CardContent class="flex-grow">
                <div class="text-sm text-zinc-800">
                    <p :class="{ 'typing-cursor': isTyping }">
                        {{ typedDescription }}
                    </p>
                </div>
            </CardContent>

            <CardFooter class="pb-2">
                <div class="grid w-full gap-2">
                    <Button v-for="(option, index) in currentRoom.options" 
                        :key="option" 
                        @click="submitMessage(option)"
                        variant="secondary"
                        class="w-full shadow-none bg-zinc-200 hover:bg-zinc-300 transition-opacity duration-500 ease-in-out"
                        :class="{
                            'opacity-0 pointer-events-none': !showButtons || isLoading,
                            'opacity-100 pointer-events-auto': showButtons && !isLoading
                        }" 
                        :style="{ transitionDelay: `${index * 200}ms` }" 
                        :disabled="isLoading">
                        {{ option }}
                    </Button>
                </div>
            </CardFooter>
        </div>
    </div>
</template>

<style scoped>
.typing-cursor::after {
    content: '|';
    animation: blink 0.7s infinite;
}

@keyframes blink {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}
</style>
