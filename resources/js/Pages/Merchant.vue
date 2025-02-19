<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CharacterInfos from '@/Layouts/CharacterInfos.vue';
import { useCharacterStore } from '@/stores/characterStore';
import { storeToRefs } from 'pinia';
import { CardHeader, CardTitle, CardContent } from '@/Components/ui/card';
import { ref, onMounted } from 'vue';
import CitationBlock from '@/Components/Character/CitationBlock.vue';
import CardFooter from '@/Components/ui/card/CardFooter.vue';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';

const characterStore = useCharacterStore();
const { currentCharacter, inventory, isLoading } = storeToRefs(characterStore);

const portraitUrl = ref('https://cdn.midjourney.com/c18ed8a3-e757-48dd-a4ae-0a272e33af28/0_0.png');
const merchantQuote = {
    content: "L'or, mes amis, c'est comme la magie : il fait des miracles entre les bonnes mains. Et ces mains, *rire satisfait*, ce sont les miennes !",
    author: "Maximilien 'Dents d'Or', Marchand Extraordinaire des Royaumes"
};

const form = useForm({
    character_id: null,
    item_id: null,
});

const isDraggingOver = ref(false);

const onDragOver = (event) => {
    event.preventDefault();
    isDraggingOver.value = true;
};

const onDragLeave = () => {
    isDraggingOver.value = false;
};

const onDrop = (event) => {
    event.preventDefault();
    isDraggingOver.value = false;
    
    try {
        const item = JSON.parse(event.dataTransfer.getData('application/json'));
        form.character_id = currentCharacter.value.id;
        form.item_id = item.id;
        
        form.post(route('merchant.sell-item'), {
            preserveScroll: true,
            onSuccess: () => {
                // Le store sera mis à jour via StoreProvider
            },
        });
    } catch (error) {
        console.error('Erreur lors de la vente:', error);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="!isLoading && currentCharacter" class="h-full w-full grid grid-cols-1 lg:grid-cols-3 gap-4 p-2 sm:p-4">
            <CharacterInfos  
                :currentCharacter="currentCharacter" 
                :inventory="inventory" 
            />

            <div class="bg-zinc-100 rounded-md flex flex-col lg:col-span-2">
                <CardHeader>
                    <div class="h-full bg-gray-200 rounded-md overflow-hidden">
                        <img 
                            :src="portraitUrl" 
                            alt="Portrait du marchand"
                            class="w-full h-32 sm:h-48 object-cover object-top opacity-90"
                        >
                    </div>
                </CardHeader>

                <CardContent class="flex-grow p-2 sm:p-4">
                    <div 
                        @dragover="onDragOver"
                        @dragleave="onDragLeave"
                        @drop="onDrop"
                        class="w-full bg-gray-200 rounded-md h-full min-h-[200px] transition-colors"
                        :class="{
                            'bg-gray-300 border-2 border-dashed border-gray-400': isDraggingOver
                        }"
                    >
                        <div class="flex items-center justify-center h-full p-4">
                            <p class="text-gray-500 text-center text-sm sm:text-base">
                                Déposez un objet ici pour le vendre
                            </p>
                        </div>
                    </div>
                </CardContent>

                <CardFooter class="p-2 sm:p-4">
                    <CitationBlock :citation="merchantQuote" />
                </CardFooter>
            </div>
        </div>
    </AuthenticatedLayout>
</template>