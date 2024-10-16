<script setup>
import { ref } from "vue";
import {
    SquareTerminal,
    Triangle,
} from "lucide-vue-next";

import Button from "@/Components/ui/button/Button.vue";
import Input from "@/Components/ui/input/Input.vue";
import Badge from "@/Components/ui/badge/Badge.vue";
import Label from "@/Components/ui/label/Label.vue";
import Tooltip from "@/Components/ui/tooltip/Tooltip.vue";
import { TooltipProvider } from "@/Components/ui/tooltip";

const character_name = ref("");
const health = ref(100);
const mana = ref(100);
const userMessage = ref("");

const submitMessage = () => {
    // Implement message submission logic here
    console.log("Sending message:", userMessage.value);
    userMessage.value = "";
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
                <header class="sticky top-0 z-10 flex h-[53px] items-center gap-1 border-b bg-background px-4">
                    <h1 class="text-xl font-semibold">Playground</h1>
                </header>

                <!-- Main content area -->
                <main class="grid flex-1 gap-4 overflow-auto p-4 md:grid-cols-2 lg:grid-cols-3">
                    <div class="relative hidden flex-col items-start gap-8 md:flex">
                        <form class="grid w-full items-start gap-6">
                            <!-- Character fieldset -->
                            <fieldset class="grid gap-6 rounded-lg border p-4">
                                <legend class="-ml-1 px-1 text-sm font-medium">
                                    Fiche de personnage
                                </legend>
                                <div class="grid gap-3">
                                    <Label for="character_name">Nom</Label>
                                    <Input id="character_name" v-model="character_name" type="text" placeholder="John Doe" />
                                </div>
                                <div class="grid grid-col gap-4">
                                    <div class="grid gap-3">
                                        <Label for="health">PV</Label>
                                        <Input id="health" v-model="health" type="number" placeholder="100" disabled />
                                    </div>
                                    <div class="grid gap-3">
                                        <Label for="mana">Mana</Label>
                                        <Input id="mana" v-model="mana" type="number" placeholder="100" disabled />
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <!-- Right column (output and input) -->
                    <div class="relative flex h-full min-h-[50vh] flex-col rounded-xl bg-muted/50 p-4 lg:col-span-2">
                        <Badge variant="outline" class="absolute right-3 top-3">Output</Badge>
                        <div class="flex-1">
                            <!-- Output content goes here -->
                        </div>
                        <form @submit.prevent="submitMessage"
                            class="relative overflow-hidden">
                            <Label for="answer" class="sr-only">Answer</Label>
                            <!-- Buttons for choice will go here -->
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </TooltipProvider>
</template>
