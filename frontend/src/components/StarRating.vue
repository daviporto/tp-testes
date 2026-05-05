<template>
  <div class="star-rating inline">
    <q-btn v-for="i in max" :key="i" flat round dense size="sm"
      :icon="i <= modelValue ? 'star' : 'star_border'"
      :color="i <= modelValue ? 'amber' : 'grey'"
      :disable="readonly"
      @click="!readonly && $emit('update:modelValue', i)" />
  </div>
</template>

<script setup>
defineProps({
  modelValue: { type: Number, default: 0 },
  max: { type: Number, default: 5 },
  readonly: { type: Boolean, default: false },
})
defineEmits(['update:modelValue'])
</script>
