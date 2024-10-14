<script setup>
import { CircleArrowRightIcon, Files, SettingsIcon } from "lucide-vue-next";
import { Button } from '@/Components/ui/button'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const mobileMenuOpen = ref(false);

const toggleMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};
</script>

<template>
    <nav class="sticky z-40 top-0 py-3 bg-background/80 backdrop-blur-lg border-b border-border">
        <div class="container flex flex-wrap max-w-screen-2xl items-center justify-between">
            <h1 class="text-lg md:text-xl font-semibold">Crawl of Gencraft</h1>

            <div class="block md:hidden ml-auto">
                <button id="menu-toggle" class="p-2 text-gray-900" @click="toggleMenu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" />
                    </svg>
                </button>
            </div>

            <div class="hidden md:flex ml-auto gap-2">
                <Link :href="route('register')">
                <Button class="cursor-pointer" variant="secondary">S'inscrire</Button>
                </Link>

                <div>
                    <Link v-if="$page.props.auth.user && canLogin" :href="route('dashboard')">
                    <Button class="cursor-pointer">Connexion</Button>
                    </Link>

                    <Link v-else :href="route('login')">
                    <Button class="cursor-pointer">Connexion</Button>
                    </Link>
                </div>
            </div>

            <div id="mobile-menu" :class="mobileMenuOpen ? 'max-h-40 opacity-100' : 'max-h-0 opacity-0'"
                class="w-full md:hidden overflow-hidden transition-all duration-300 ease-in-out">
                <div class="flex items-center gap-2 mt-4 mb-2">
                    <Button class=" w-1/2 cursor-pointer" variant="secondary">S'inscrire</Button>
                    <Button class="w-1/2 cursor-pointer">Connexion</Button>
                </div>
            </div>
        </div>
    </nav>

    <main class="mt-12 md:mt-32">
        <div class="container flex flex-col gap-28">
            <div class="flex flex-col gap-7">
                <h1 class="text-4xl font-semibold lg:text-7xl">
                    Plongez dans des donjons uniques générés par l'IA
                </h1>
                <p class="max-w-2xl text-lg">
                    Bienvenue dans Crawl Of Gencraft, une aventure textuelle où chaque salle, chaque monstre et chaque
                    trésor sont générés en temps réel par une intelligence artificielle. Chaque partie est différente,
                    chaque choix compte.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <img alt="Entrée d'un donjon à l'aspect inquiétant"
                    class="size-full h-[20rem] rounded-2xl object-cover object-center md:max-h-96"
                    src="https://res.cloudinary.com/dnqqx8hbb/image/upload/dungeon_entrance_o9qtwu.png" />
                <div class="flex flex-col justify-between gap-10 rounded-2xl bg-muted p-10">
                    <p class="text-sm text-muted-foreground">NOTRE VISION</p>
                    <p class="text-lg font-medium">
                        Notre objectif est de créer des aventures infinies, toujours surprenantes. Grâce à l'IA, chaque
                        donjon est une nouvelle histoire à raconter, à explorer et à conquérir.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-6 md:gap-20">
                <div class="max-w-2xl">
                    <h2 class="mb-3 text-3xl font-semibold md:text-5xl">
                        Un donjon sans limites
                    </h2>
                    <p class="text-muted-foreground">
                        Crawl Of Gencraft vous offre une expérience renouvelée à chaque partie. L'IA génère des salles,
                        des ennemis et des trésors selon vos actions. Êtes-vous prêt à affronter l'inconnu ?
                    </p>
                </div>

                <div class="grid gap-10 md:grid-cols-3">
                    <div class="flex flex-col">
                        <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-accent">
                            <Files class="size-5" />
                        </div>
                        <h3 class="mb-3 mt-2 text-lg font-semibold">
                            Donjons infinis
                        </h3>
                        <p class="text-muted-foreground">
                            Aucun donjon ne ressemble à un autre. Chaque salle est unique, générée en fonction de vos
                            choix et de l'univers de jeu. Explorez sans cesse des terres inconnues.
                        </p>
                    </div>

                    <div class="flex flex-col">
                        <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-accent">
                            <CircleArrowRightIcon class="size-5" />
                        </div>
                        <h3 class="mb-3 mt-2 text-lg font-semibold">
                            Choix décisifs
                        </h3>
                        <p class="text-muted-foreground">
                            Vos décisions influencent l'histoire et les événements. Chaque action, que ce soit combattre
                            ou fuir, change la trajectoire de votre exploration.
                        </p>
                    </div>

                    <div class="flex flex-col">
                        <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-accent">
                            <SettingsIcon class="size-5" />
                        </div>
                        <h3 class="mb-3 mt-2 text-lg font-semibold">
                            Immersion totale
                        </h3>
                        <p class="text-muted-foreground">
                            Plongez dans un monde où l'IA vous guide, mais où vous gardez le contrôle. Le donjon évolue
                            en temps réel en fonction de votre progression.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-32 mb-12">
            <div class="container">
                <div class="flex flex-col items-center rounded-lg bg-accent p-8 text-center md:rounded-xl lg:p-16">
                    <h3 class="mb-3 max-w-3xl text-2xl font-semibold md:mb-4 md:text-4xl lg:mb-6">
                        Rejoignez l'aventure de Crawl of Gencraft
                    </h3>
                    <p class="mb-8 max-w-3xl text-muted-foreground lg:text-lg">
                        Prenez part à une expérience immersive unique et créez votre propre chemin dans le donjon.
                        Inscrivez-vous maintenant et préparez-vous pour l'aventure.
                    </p>
                    <div class="flex w-full flex-col justify-center gap-2 sm:flex-row">
                        <Button class="cursor-pointer" variant="outline">S'inscrire</Button>
                        <Button class="cursor-pointer">Connexion</Button>
                    </div>
                </div>
            </div>
        </footer>
    </main>
</template>
