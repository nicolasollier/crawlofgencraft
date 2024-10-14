<script setup>
import { Card } from "@/Components/ui/card"
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-zinc-100 pt-6 sm:justify-center sm:pt-0"
    >
        <Card class="w-full max-w-sm shadow-none">
            <slot />
        </Card>
    </div>
</template>
