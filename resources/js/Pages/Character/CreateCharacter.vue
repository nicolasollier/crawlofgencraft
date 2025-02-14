<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CharacterForm from '@/Components/Character/CharacterForm.vue';
import CharacterPreview from '@/Components/Character/CharacterPreview.vue';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import citations from '@/utils/citations.json';

const alignments = ref({
  axis1: [
    { label: 'Loyal', value: 'lawful' },
    { label: 'Neutre', value: 'neutral' },
    { label: 'Chaotique', value: 'chaotic' },
  ],
  axis2: [
    { label: 'Bon', value: 'good' },
    { label: 'Neutre', value: 'neutral' },
    { label: 'Mauvais', value: 'evil' },
  ],
});

const characterClasses = ref([
  { label: 'Guerrier', value: 'warrior' },
  { label: 'Mage', value: 'mage' },
  { label: 'Voleur', value: 'thief' },
]);

const races = ref([
  { label: 'Humain', value: 'human' },
  { label: 'Elfe', value: 'elf' },
  { label: 'Orc', value: 'orc' },
]);

const genders = ref([
  { label: 'Masculin', value: 'male' },
  { label: 'Féminin', value: 'female' },
  { label: 'Autre', value: 'other' },
]);

const portraitUrl = ref('https://cdn.midjourney.com/ea04ef8a-d979-42c0-87b6-9c0509c2d59b/0_1.png');

const form = useForm({
  name: '',
  alignmentAxis1: '',
  alignmentAxis2: '',
  race: '',
  gender: '',
  class: '',
  strength: '',
  agility: '',
  intelligence: ''
});

const generateStats = () => {
  if(form.race === 'human') {
    form.strength = 10;
    form.agility = 10;
    form.intelligence = 10;
  }
  if(form.race === 'elf') {
    form.strength = 8;
    form.agility = 12;
    form.intelligence = 10;
  }
  if(form.race === 'orc') {
    form.strength = 12;
    form.agility = 8;
    form.intelligence = 10;
  }
}

const parsedInputs = computed(() => {
  const axis1Label = form.alignmentAxis1 ? alignments.value.axis1.find(a => a.value === form.alignmentAxis1)?.label || '' : '';
  const axis2Label = form.alignmentAxis2 ? alignments.value.axis2.find(a => a.value === form.alignmentAxis2)?.label || '' : '';
  const fullAlignment = axis1Label && axis2Label ? `${axis1Label} ${axis2Label}` : 'N/A';
  
  const alignmentMap = {
    'lawful good': 'loyalGood',
    'neutral good': 'neutralGood',
    'chaotic good': 'chaoticGood',
    'lawful neutral': 'lawfulNeutral',
    'neutral neutral': 'trueNeutral',
    'chaotic neutral': 'chaoticNeutral',
    'lawful evil': 'lawfulEvil',
    'neutral evil': 'neutralEvil',
    'chaotic evil': 'chaoticEvil',
  };

  const alignmentKey = axis1Label && axis2Label ? alignmentMap[`${form.alignmentAxis1} ${form.alignmentAxis2}`] : 'trueNeutral';

  return {
    alignment: fullAlignment,
    race: form.race ? races.value.find(race => race.value === form.race)?.label || 'N/A' : 'N/A',
    characterClass: form.class ? characterClasses.value.find(characterClass => characterClass.value === form.class)?.label || 'N/A' : 'N/A',
    gender: form.gender ? genders.value.find(gender => gender.value === form.gender)?.label || 'N/A' : 'N/A',
    citation: citations.citations[alignmentKey],
  };
});

const handleSubmit = () => {
  generateStats();

  form.post(route('characters.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full h-full bg-zinc-100 rounded-md p-4">
      <CharacterForm
        :form="form"
        :alignments="alignments"
        :races="races"
        :genders="genders"
        :character-classes="characterClasses"
        @submit="handleSubmit"
      />
      
      <CharacterPreview
        :name="form.name"
        :portrait-url="portraitUrl"
        :parsed-inputs="parsedInputs"
      />
    </div>
  </AuthenticatedLayout>
</template>
