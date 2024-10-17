<script setup>
import {
    SquareTerminal,
    Triangle,
    ChevronDown,
} from "lucide-vue-next";
import { usePage } from '@inertiajs/vue3';
import Button from "@/Components/ui/button/Button.vue";
import Tooltip from "@/Components/ui/tooltip/Tooltip.vue";
import { TooltipProvider } from "@/Components/ui/tooltip";
import { useCharacterStore } from '@/stores/characterStore';
import { storeToRefs } from 'pinia';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

const page = usePage();
const userPseudo = page.props.auth.user.pseudo;

const characterStore = useCharacterStore();
const { characters, currentCharacter } = storeToRefs(characterStore);

const selectCharacter = (character) => {
    characterStore.setCurrentCharacter(character);
};
</script>

<template>
    <TooltipProvider>
        <div class="grid h-screen w-full pl-[53px]">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-20 flex h-full flex-col border-r">
                <div class="border-b p-2">
                    <Button variant="outline" size="icon" aria-label="Home">
                        <Triangle class="size-5 fill-foreground" />
                    </Button>
                </div>
                <nav class="grid gap-1 p-2">
                    <Tooltip content="Playground" side="right">
                        <Button variant="ghost" size="icon" class="rounded-lg bg-muted" aria-label="Playground">
                            <SquareTerminal class="size-5" />
                        </Button>
                    </Tooltip>
                </nav>
            </aside>

            <div class="flex flex-col">
                <!-- Header -->
                <header class="sticky top-0 z-10 flex h-[53px] items-center gap-4 border-b bg-background px-4">
                    <h1 class="text-xl font-semibold">{{ userPseudo }}</h1>
                    
                    <!-- Character Picker -->
                    <DropdownMenu v-if="characters.length > 1">
                        <DropdownMenuTrigger asChild>
                            <Button variant="outline" class="ml-auto">
                                {{ currentCharacter?.name || 'Sélectionner un personnage' }}
                                <ChevronDown class="ml-2 h-4 w-4" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent>
                            <DropdownMenuItem v-for="char in characters" :key="char.id" @click="selectCharacter(char)">
                                {{ char.name }}
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-auto md:p-4">
                    <slot></slot>
                </main>
            </div>
        </div>
    </TooltipProvider>
</template>
