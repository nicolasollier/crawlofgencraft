<script setup>
import { storeToRefs } from 'pinia';
import { SquareTerminal, ChevronDown, Store } from "lucide-vue-next";
import Button from "@/Components/ui/button/Button.vue";
import Tooltip from "@/Components/ui/tooltip/Tooltip.vue";
import { TooltipProvider } from "@/Components/ui/tooltip";
import StoreProvider from '@/Layouts/StoreProvider.vue';
import AppLogo from '@/Components/logos/AppLogo.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/Components/ui/dropdown-menu";
import { useCharacterStore } from '@/stores/characterStore';
import { useDungeonStore } from '@/stores/dungeonStore';
import { router, usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const userPseudo = page.props.auth.user.pseudo;

const characterStore = useCharacterStore();
const dungeonStore = useDungeonStore();

const { characters, currentCharacter } = storeToRefs(characterStore);

const isActiveRoute = (route) => {
    return page.url.endsWith(route);
};

const createCharacter = () => {
    router.visit(route('characters.create'));
};

const selectCharacter = (character) => {
    characterStore.setCurrentCharacter(character);
    dungeonStore.setCurrentDungeon(character.dungeon);
};
</script>

<template>
    <TooltipProvider>
        <StoreProvider>
            <div class="grid h-screen w-full pl-[53px]">
                <aside class="fixed inset-y-0 left-0 z-20 flex h-full flex-col border-r">
                    <div class="border-b p-2">
                        <Link :href="route('dashboard')">
                        <AppLogo class="w-9 h-9 rounded-sm" />
                        </Link>
                    </div>
                    <nav class="grid gap-1 p-2">
                        <Tooltip content="Playground" side="right">
                            <Link :href="route('dashboard')">
                            <Button variant="ghost" size="icon" class="rounded-lg"
                                :class="{ 'bg-muted': isActiveRoute('dashboard') }" aria-label="Playground">
                                <SquareTerminal class="size-5" />
                            </Button>
                            </Link>
                        </Tooltip>

                        <Tooltip content="Merchant" side="right">
                            <Link :href="route('merchant')">
                            <Button variant="ghost" size="icon" class="rounded-lg"
                                :class="{ 'bg-muted': isActiveRoute('merchant') }" aria-label="Merchant">
                                <Store class="size-5" />
                            </Button>
                            </Link>
                        </Tooltip>
                    </nav>
                </aside>

                <div class="flex flex-col">
                    <!-- Header -->
                    <header class="sticky top-0 z-10 flex h-[53px] items-center gap-4 border-b bg-background px-4">
                        <h1 class="text-xl font-semibold">{{ userPseudo }}</h1>

                        <!-- Character Picker -->
                        <template v-if="!$page.url.endsWith('/characters/create')">
                            <DropdownMenu v-if="characters.length > 0">
                                <DropdownMenuTrigger asChild>
                                    <Button variant="outline" class="ml-auto">
                                        {{ currentCharacter?.name || 'Sélectionner un personnage' }}
                                        <ChevronDown class="ml-2 h-4 w-4" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuItem v-for="char in characters" :key="char.id"
                                        @click="selectCharacter(char)">
                                        {{ char.name }}
                                    </DropdownMenuItem>
                                    <DropdownMenuItem @click="createCharacter">
                                        Créer un personnage
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                            <Button v-else variant="outline" class="ml-auto" @click="createCharacter">
                                Créer un personnage
                            </Button>
                        </template>
                    </header>

                    <!-- Main Content -->
                    <main class="flex-1 overflow-auto md:p-4">
                        <slot></slot>
                    </main>
                </div>
            </div>
        </StoreProvider>
    </TooltipProvider>
</template>
