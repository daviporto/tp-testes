<template>
  <div class="star-rating inline">
    <q-btn v-for="i in max" :key="i" flat round dense
      :size="btnSize"
      :icon="i <= modelValue ? 'star' : 'star_border'"
      :color="i <= modelValue ? 'accent' : 'grey-5'"
      :disable="readonly"
      :class="{ 'star-hover': !readonly }"
      @click="!readonly && $emit('update:modelValue', i)"
      @mouseenter="!readonly && (hoverValue = i)"
      @mouseleave="!readonly && (hoverValue = 0)">
      <q-tooltip v-if="!readonly" :delay="300">
        Nota {{ i }}
      </q-tooltip>
    </q-btn>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  modelValue: { type: Number, default: 0 },
  max: { type: Number, default: 5 },
  readonly: { type: Boolean, default: false },
  size: { type: String, default: 'sm' },
})
defineEmits(['update:modelValue'])

const hoverValue = ref(0)

const btnSize = computed(() => {
  switch (props.size) {
    case 'md': return 'md'
    case 'lg': return 'lg'
    default: return 'sm'
  }
})
</script>

<style scoped>
.star-hover {
  transition: transform 0.15s ease;
}
.star-hover:hover {
  transform: scale(1.2);
}
</style>
