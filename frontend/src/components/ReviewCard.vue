<template>
  <q-card class="q-mb-sm">
    <q-card-section>
      <div class="row items-center justify-between">
        <div class="text-subtitle2">{{ authorName }}</div>
        <div class="text-caption text-grey">{{ review.created_at?.split('T')[0] }}</div>
      </div>
      <div class="q-mt-sm row q-col-gutter-sm">
        <div class="col-auto">
          <div class="text-caption">Geral</div>
          <StarRating :model-value="review.nota_geral" readonly />
        </div>
        <div class="col-auto">
          <div class="text-caption">Didatica</div>
          <StarRating :model-value="review.nota_didatica" readonly />
        </div>
        <div class="col-auto">
          <div class="text-caption">Conteudo</div>
          <StarRating :model-value="review.nota_conteudo" readonly />
        </div>
        <div class="col-auto">
          <div class="text-caption">Dificuldade</div>
          <StarRating :model-value="review.nota_dificuldade" readonly />
        </div>
      </div>
      <div class="q-mt-sm">{{ review.comentario }}</div>
      <div v-if="review.tags?.length" class="q-mt-sm">
        <q-badge v-for="tag in review.tags" :key="tag" color="primary" class="q-mr-xs">
          {{ tag }}
        </q-badge>
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
</script>
