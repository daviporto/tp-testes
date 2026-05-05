<template>
  <q-card flat bordered class="card-hover cursor-pointer elective-card" @click="$emit('click')">
    <q-card-section>
      <!-- Header: code + semester badge -->
      <div class="row items-center justify-between q-mb-xs">
        <q-badge outline color="primary" :label="optativa.codigo" class="text-caption" />
        <q-badge color="grey-3" text-color="grey-8" :label="optativa.semestre" class="text-caption" />
      </div>

      <!-- Course name -->
      <div class="text-h6 text-weight-medium q-mb-xs ellipsis-line">{{ optativa.nome }}</div>

      <!-- Professor -->
      <div class="row items-center text-body2 text-grey-7 q-mb-xs">
        <q-icon name="person" size="xs" class="q-mr-xs" />
        <span>{{ optativa.professor?.nome || '—' }}</span>
      </div>

      <!-- Course + credits -->
      <div class="row items-center text-caption text-grey-6 q-mb-sm">
        <q-icon name="book" size="xs" class="q-mr-xs" />
        <span>{{ optativa.curso?.nome || '—' }} &middot; {{ optativa.creditos }} creditos</span>
      </div>

      <!-- Description -->
      <div v-if="optativa.descricao" class="text-body2 text-grey-7 q-mb-sm ellipsis-2-lines">
        {{ optativa.descricao }}
      </div>

      <q-separator class="q-mb-sm" />

      <!-- Rating -->
      <div class="row items-center justify-between">
        <div>
          <StarRating :model-value="Math.round(optativa.media_geral || 0)" readonly size="sm" />
          <span class="text-caption text-grey-6 q-ml-sm">
            {{ optativa.media_geral ? optativa.media_geral.toFixed(1) : '—' }}
            ({{ optativa.total_avaliacoes || 0 }})
          </span>
        </div>
        <q-icon name="chevron_right" color="grey-5" size="sm" />
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup>
import StarRating from './StarRating.vue'
defineProps({
  optativa: { type: Object, required: true },
})
defineEmits(['click'])
</script>

<style scoped>
.elective-card {
  border-radius: 12px;
}

.ellipsis-line {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.ellipsis-2-lines {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
