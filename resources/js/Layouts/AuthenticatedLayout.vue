<script setup>
import {
    SquareTerminal,
    Triangle,
} from "lucide-vue-next";
import { usePage } from '@inertiajs/vue3';
import Button from "@/Components/ui/button/Button.vue";
import Tooltip from "@/Components/ui/tooltip/Tooltip.vue";
import { TooltipProvider } from "@/Components/ui/tooltip";

const page = usePage();
const userPseudo = page.props.auth.user.pseudo;
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
                    <h1 class="text-xl font-semibold">{{ userPseudo }}</h1>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-auto md:p-4">
                    <slot></slot>
                </main>
            </div>
        </div>
    </TooltipProvider>
</template>
