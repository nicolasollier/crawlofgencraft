<script setup>
import { Select, SelectItem, SelectTrigger, SelectContent, SelectValue } from "@/Components/ui/select";
import { Label } from "@/Components/ui/label";

const props = defineProps({
  alignments: {
    type: Object,
    required: true
  },
  axis1: {
    type: String,
    required: true
  },
  axis2: {
    type: String,
    required: true
  }
});

const emit = defineEmits(['update:axis1', 'update:axis2']);
</script>

<template>
  <div class="space-y-4">
    <Label>Alignement</Label>
    <div class="flex flex-col sm:flex-row gap-4">
      <Select 
        class="w-full" 
        :value="axis1"
        @update:modelValue="$emit('update:axis1', $event)"
      >
        <SelectTrigger>
          <SelectValue placeholder="Moralité" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem 
            v-for="alignment in alignments.axis1" 
            :key="alignment.value" 
            :value="alignment.value"
          >
            {{ alignment.label }}
          </SelectItem>
        </SelectContent>
      </Select>

      <Select 
        class="w-full" 
        :value="axis2"
        @update:modelValue="$emit('update:axis2', $event)"
      >
        <SelectTrigger>
          <SelectValue placeholder='Alignement' />
        </SelectTrigger>
        <SelectContent>
          <SelectItem 
            v-for="alignment in alignments.axis2" 
            :key="alignment.value" 
            :value="alignment.value"
          >
            {{ alignment.label }}
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
  </div>
</template> 