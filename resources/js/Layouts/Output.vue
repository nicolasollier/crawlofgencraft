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
const currentRoom = ref(currentDungeon.value.rooms[currentDungeon.value.room_count - 1]);

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
            <div class="room-description text-sm text-zinc-800">
                <p>
                    Vous pénétrez dans une vaste salle circulaire, dont les murs de pierre ancienne s'élèvent à
                    plusieurs mètres de hauteur. Des torches vacillantes, fixées à intervalles réguliers, projettent une
                    lueur orangée qui danse sur les parois humides, créant un jeu d'ombres inquiétant. Le plafond voûté
                    est orné de fresques complexes, à moitié effacées par le temps, représentant des scènes de batailles
                    épiques entre des créatures mythiques.
                </p>
                <p>
                    Au centre de la pièce trône une imposante fontaine de marbre noir, dont l'eau sombre et miroitante
                    semble absorber la lumière environnante. Des murmures indistincts semblent émaner de ses
                    profondeurs, comme si elle abritait quelque présence ancienne et mystérieuse.
                </p>
                <p>
                    Autour de la fontaine, disposés en cercle, se dressent six piliers massifs gravés de runes
                    scintillantes. Chaque pilier est surmonté d'une statue représentant un guerrier en armure, leur
                    regard de pierre fixé sur le centre de la salle dans une garde éternelle.
                </p>
                <p>
                    Le sol est recouvert d'une fine couche de poussière, brisée ça et là par des empreintes de pas
                    étranges qui ne semblent mener nulle part. Dans les coins de la pièce, des amas d'ossements et de
                    débris métalliques témoignent des combats passés et des aventuriers moins fortunés.
                </p>
                <p>
                    Trois portes s'ouvrent sur les murs de la salle : l'une à l'est, ornée de joyaux scintillants ; une
                    autre au nord, bardée de fer et portant des marques de griffures profondes ; et la dernière à
                    l'ouest, simple en apparence mais dégageant une aura de magie palpable.
                </p>
                <p>
                    L'air est lourd, chargé d'une odeur de pierre humide et d'encens ancien. Un silence oppressant règne
                    dans la salle, seulement troublé par le clapotis régulier de l'eau de la fontaine et le crépitement
                    occasionnel des torches.
                </p>
                <p>
                    Alors que vous contemplez la scène, un frisson parcourt votre échine. Vous sentez que chaque choix
                    dans cette salle pourrait avoir des conséquences importantes sur la suite de votre aventure. Quelle
                    direction allez-vous prendre ?
                </p>
            </div>

            <!-- Spacer to push the buttons to the bottom -->
            <div class="flex-grow"></div>

            <!-- Action buttons -->
            <div class="mt-4 space-y-2 sm:space-y-0 sm:space-x-2 sm:flex sm:flex-wrap">
                <Button
                  v-for="option in placeholderOptions"
                  :key="option.value"
                  @click="submitMessage(option.value)"
                  class="w-full sm:w-auto"
                >
                  {{ option.label }}
                </Button>
            </div>
        </div>
    </div>
</template>
