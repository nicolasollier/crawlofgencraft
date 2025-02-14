<script setup>
defineProps({
  citation: {
    type: Object,
    required: true,
    validator: (value) => {
      return value.hasOwnProperty('content') && value.hasOwnProperty('author');
    }
  }
});
</script>

<template>
  <div class="w-full text-sm">
    <blockquote class="relative border-l-2 pl-6 italic">
      {{ citation.content }}
      <footer class="mt-2 text-muted-foreground/80">
        — {{ citation.author }}
      </footer>
    </blockquote>
  </div>
</template>
