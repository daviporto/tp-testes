<template>
  <q-card class="cursor-pointer" @click="$emit('click')">
    <q-card-section>
      <div class="text-h6">{{ optativa.nome }}</div>
      <div class="text-subtitle2 text-grey-7">{{ optativa.codigo }}</div>
      <div class="text-body2 q-mt-sm">{{ optativa.professor?.nome }}</div>
      <div class="text-caption">{{ optativa.curso?.nome }} | {{ optativa.semestre }} | {{ optativa.creditos }} creditos</div>
      <div v-if="optativa.descricao" class="text-body2 q-mt-sm ellipsis-2-lines">
        {{ optativa.descricao }}
      </div>
      <div class="q-mt-sm" v-if="optativa.media_geral">
        Media: <StarRating :model-value="Math.round(optativa.media_geral)" readonly />
        <span class="text-caption">({{ optativa.total_avaliacoes }} avaliacoes)</span>
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
.ellipsis-2-lines {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
