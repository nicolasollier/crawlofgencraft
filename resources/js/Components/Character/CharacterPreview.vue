<script setup>
import { Compass, Swords, Users, User } from "lucide-vue-next";
import { CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/Components/ui/card";
import CitationBlock from '@/Components/Character/CitationBlock.vue';

defineProps({
  name: String,
  portraitUrl: String,
  parsedInputs: {
    type: Object,
    required: true
  }
});
</script>

<template>
  <div class="flex flex-col rounded-md p-2 sm:p-4 border border-border bg-card shadow-sm">
    <CardHeader>
      <div class="w-full h-48 bg-gray-200 rounded-md flex justify-center items-center mb-4">
        <img :src="portraitUrl" alt="Portrait du personnage" class="w-full h-full object-cover object-top rounded-md">
      </div>
      <CardTitle>{{ name || 'Nom du personnage' }}</CardTitle>

      <CardDescription class="flex flex-wrap items-center gap-3 text-sm">
        <span class="flex items-center gap-1">
          <Compass class="h-4 w-4" /> Alignement : {{ parsedInputs.alignment }}
        </span>
        <span class="flex items-center gap-1">
          <Users class="h-4 w-4" /> Race : {{ parsedInputs.race }}
        </span>
        <span class="flex items-center gap-1">
          <User class="h-4 w-4" /> Genre : {{ parsedInputs.gender }}
        </span>
        <span class="flex items-center gap-1">
          <Swords class="h-4 w-4" /> Classe : {{ parsedInputs.characterClass }}
        </span>
      </CardDescription>
    </CardHeader>

    <CardContent></CardContent>

    <CardFooter class="mt-auto">
      <CitationBlock v-if="parsedInputs.citation" :citation="parsedInputs.citation" />
    </CardFooter>
  </div>
</template>
