<script setup>
import { computed } from 'vue';
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Select, SelectItem, SelectTrigger, SelectContent, SelectValue } from "@/Components/ui/select";
import { CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/Components/ui/card";
import AlignmentSelector from '@/Components/Character/AlignmentSelector.vue';

const props = defineProps({
  form: {
    type: Object,
    required: true
  },
  alignments: {
    type: Object,
    required: true
  },
  races: {
    type: Array,
    required: true
  },
  genders: {
    type: Array,
    required: true
  },
  characterClasses: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['submit']);

const formIsValid = computed(() => {
  return (
    props.form.name.trim() !== '' &&
    props.form.alignmentAxis1 !== '' &&
    props.form.alignmentAxis2 !== '' &&
    props.form.race !== '' &&
    props.form.gender !== '' &&
    props.form.class !== ''
  );
});

const submit = () => {
  if (formIsValid.value) {
    emit('submit', props.form);
  }
};
</script>

<template>
  <div class="flex flex-col rounded-md p-2 sm:p-4 border border-border bg-card shadow-sm">
    <CardHeader>
      <CardTitle>Nouveau personnage</CardTitle>
      <CardDescription>Créez votre nouveau héros pour l'aventure</CardDescription>
    </CardHeader>

    <CardContent>
      <form @submit.prevent="submit">
        <fieldset>
          <legend class="sr-only">Informations du personnage</legend>
          <div class="grid gap-4">
            <div class="mb-4">
              <Label for="name">Nom du personnage</Label>
              <Input class="mt-1" id="name" v-model="form.name" type="text" required />
            </div>

            <AlignmentSelector 
              :alignments="alignments" 
              v-model:axis1="form.alignmentAxis1"
              v-model:axis2="form.alignmentAxis2"
            />

            <Select class="w-full" v-model="form.race">
              <SelectTrigger>
                <SelectValue placeholder="Race" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem v-for="race in races" :key="race.value" :value="race.value">
                  {{ race.label }}
                </SelectItem>
              </SelectContent>
            </Select>

            <div class="grid gap-4">
              <Select class="w-full" v-model="form.gender">
                <SelectTrigger>
                  <SelectValue placeholder="Genre" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem v-for="gender in genders" :key="gender.value" :value="gender.value">
                    {{ gender.label }}
                  </SelectItem>
                </SelectContent>
              </Select>

              <Select class="w-full" v-model="form.class">
                <SelectTrigger>
                  <SelectValue placeholder="Classe" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem v-for="characterClass in characterClasses" :key="characterClass.value" :value="characterClass.value">
                    {{ characterClass.label }}
                  </SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>
        </fieldset>
      </form>
    </CardContent>

    <CardFooter class="mt-auto">
      <Button class="w-full" @click="submit" type="submit" :disabled="!formIsValid">
        Créer le personnage
      </Button>
    </CardFooter>
  </div>
</template>
