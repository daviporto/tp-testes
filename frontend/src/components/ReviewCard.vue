<template>
  <q-card flat bordered class="q-mb-sm review-card card-hover">
    <q-card-section>
      <!-- Header: author + date -->
      <div class="row items-center justify-between q-mb-sm">
        <div class="row items-center">
          <q-icon :name="review.anonima ? 'visibility_off' : 'person'"
            size="xs" :color="review.anonima ? 'orange' : 'primary'" class="q-mr-xs" />
          <span class="text-subtitle2 text-weight-medium">{{ authorName }}</span>
          <q-badge v-if="review.anonima" color="orange-2" text-color="orange-9"
            label="anonimo" class="q-ml-sm text-caption" />
        </div>
        <span class="text-caption text-grey-6">{{ formatDate(review.created_at) }}</span>
      </div>

      <!-- Ratings -->
      <div class="row q-col-gutter-sm q-mb-sm">
        <div v-for="item in ratingItems" :key="item.key" class="col-6 col-sm-3">
          <div class="text-caption text-grey-6 q-mb-xs">{{ item.label }}</div>
          <StarRating :model-value="review[item.key]" readonly size="sm" />
        </div>
      </div>

      <q-separator spaced="xs" class="q-mb-sm" />

      <!-- Comment -->
      <div class="text-body1 text-grey-8 q-mb-sm" style="line-height: 1.5">
        {{ review.comentario }}
      </div>

      <!-- Tags -->
      <div v-if="review.tags?.length" class="q-mt-sm">
        <q-chip v-for="tag in review.tags" :key="tag" dense size="sm"
          color="primary" text-color="white" :label="tag"
          class="q-mr-xs" />
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { computed } from 'vue'
import StarRating from './StarRating.vue'

const props = defineProps({
  review: { type: Object, required: true },
})

const authorName = computed(() => {
  if (props.review.anonima) return 'Aluno Anonimo'
  return props.review.user?.name || 'Aluno'
})

const ratingItems = [
  { key: 'nota_geral', label: 'Geral' },
  { key: 'nota_didatica', label: 'Didatica' },
  { key: 'nota_conteudo', label: 'Conteudo' },
  { key: 'nota_dificuldade', label: 'Dificuldade' },
]

function formatDate(dateStr) {
  if (!dateStr) return ''
  return dateStr.split('T')[0]
}
</script>

<style scoped>
.review-card {
  border-radius: 12px;
  border-left: 3px solid #3949ab;
}
</style>
