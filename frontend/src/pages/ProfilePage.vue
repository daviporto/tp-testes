<template>
  <q-page padding>
    <div class="text-h4 q-mb-md">Meu Perfil</div>

    <q-card class="q-mb-lg">
      <q-card-section>
        <div class="text-h6">{{ user?.name }}</div>
        <div>{{ user?.email }} | {{ user?.curso }}</div>
        <div class="text-caption">Matricula: {{ user?.matricula }}</div>
      </q-card-section>
    </q-card>

    <div class="text-h5 q-mb-sm">Minhas Avaliacoes</div>

    <div v-if="reviews.length === 0" class="text-grey">
      Voce ainda nao postou nenhuma avaliacao.
    </div>

    <ReviewCard v-for="review in reviews" :key="review.id" :review="review" />
  </q-page>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../boot/api'
import ReviewCard from '../components/ReviewCard.vue'

const user = computed(() => JSON.parse(localStorage.getItem('user') || 'null'))
const reviews = ref([])

onMounted(async () => {
  const { data } = await api.get('/avaliacoes/minha')
  reviews.value = data
})
</script>
