<template>
  <q-page padding v-if="optativa">
    <div class="text-h4">{{ optativa.nome }}</div>
    <div class="text-subtitle1 text-grey-7 q-mb-md">
      {{ optativa.codigo }} — {{ optativa.professor?.nome }} — {{ optativa.semestre }}
    </div>

    <q-card class="q-mb-md">
      <q-card-section>
        <div class="text-h6">Medias</div>
        <div class="row q-col-gutter-md q-mt-sm">
          <div class="col-3 text-center">
            <div class="text-h5 text-primary">{{ medias.geral }}</div>
            <div class="text-caption">Geral</div>
          </div>
          <div class="col-3 text-center">
            <div class="text-h5">{{ medias.didatica }}</div>
            <div class="text-caption">Didatica</div>
          </div>
          <div class="col-3 text-center">
            <div class="text-h5">{{ medias.conteudo }}</div>
            <div class="text-caption">Conteudo</div>
          </div>
          <div class="col-3 text-center">
            <div class="text-h5">{{ medias.dificuldade }}</div>
            <div class="text-caption">Dificuldade</div>
          </div>
        </div>
      </q-card-section>
    </q-card>

    <div class="text-h6 q-mb-sm">Avaliacoes ({{ reviews.length }})</div>

    <!-- Gate state 1: not logged in -->
    <q-banner v-if="!isLoggedIn" class="bg-info text-white q-mb-md" rounded>
      <q-icon name="lock" /> Faca <router-link to="/login" class="text-white">login</router-link> para ver as avaliacoes.
    </q-banner>

    <!-- Gate state 2: logged in but no review posted -->
    <q-banner v-else-if="!userHasPosted" class="bg-warning q-mb-md" rounded>
      Poste uma avaliacao para desbloquear os comentarios dos colegas.
    </q-banner>

    <!-- Show reviews based on gate -->
    <template v-if="canSeeReviews">
      <ReviewCard v-for="review in reviews" :key="review.id" :review="review" />
    </template>
    <template v-else>
      <q-card v-for="review in reviews" :key="review.id" class="q-mb-sm">
        <q-card-section>
          <StarRating :model-value="review.nota_geral" readonly />
          <span class="text-grey q-ml-sm">Postado {{ review.created_at?.split('T')[0] }}</span>
        </q-card-section>
      </q-card>
    </template>

    <div v-if="reviews.length === 0" class="text-grey q-my-md">
      Nenhuma avaliacao ainda. Seja o primeiro!
    </div>

    <!-- Review form -->
    <q-separator class="q-my-lg" />
    <div class="text-h6 q-mb-md">Deixe sua avaliacao</div>

    <div v-if="!isLoggedIn" class="text-grey">
      Faca <router-link to="/login">login</router-link> para avaliar.
    </div>
    <div v-else-if="hasAlreadyReviewed" class="text-grey">
      Voce ja avaliou esta optativa.
    </div>
    <ReviewForm v-else :optativa-id="optativa.id" @submitted="loadData" />
  </q-page>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../boot/api'
import ReviewCard from '../components/ReviewCard.vue'
import ReviewForm from '../components/ReviewForm.vue'
import StarRating from '../components/StarRating.vue'

const route = useRoute()
const optativa = ref(null)
const reviews = ref([])
const userHasPosted = ref(undefined)
const hasAlreadyReviewed = ref(false)

const isLoggedIn = computed(() => !!localStorage.getItem('token'))

const canSeeReviews = computed(() => {
    const user = JSON.parse(localStorage.getItem('user') || 'null')
    if (user?.role === 'admin') return true
    return userHasPosted.value === true
})

const medias = computed(() => {
  if (reviews.value.length === 0) return { geral: '-', didatica: '-', conteudo: '-', dificuldade: '-' }
  const avg = (key) => (reviews.value.reduce((s, r) => s + r[key], 0) / reviews.value.length).toFixed(1)
  return {
    geral: avg('nota_geral'),
    didatica: avg('nota_didatica'),
    conteudo: avg('nota_conteudo'),
    dificuldade: avg('nota_dificuldade'),
  }
})

onMounted(() => loadData())

async function loadData() {
    const id = route.params.id
    const { data } = await api.get(`/optativas/${id}`)
    optativa.value = data.optativa
    reviews.value = data.reviews
    userHasPosted.value = data.user_has_posted
    hasAlreadyReviewed.value = data.has_already_reviewed
}
</script>
