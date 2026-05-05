<template>
  <div>
    <!-- Loading skeleton -->
    <q-page v-if="loading" padding>
      <q-skeleton type="text" width="60%" height="40px" />
      <q-skeleton type="text" width="40%" class="q-mt-sm" />
      <q-card class="q-mt-md">
        <q-card-section>
          <q-skeleton type="text" width="30%" />
          <div class="row q-mt-sm q-col-gutter-md">
            <div v-for="i in 4" :key="i" class="col-3 text-center">
              <q-skeleton type="circle" size="48px" />
              <q-skeleton type="text" class="q-mt-sm" />
            </div>
          </div>
        </q-card-section>
      </q-card>
    </q-page>

    <q-page v-else-if="optativa" padding>
      <!-- Header -->
      <div class="text-h4 text-weight-bold">{{ optativa.nome }}</div>
      <div class="text-subtitle1 text-grey-7 q-mb-sm">
        {{ optativa.codigo }} &middot; {{ optativa.professor?.nome }}
        &middot; {{ optativa.semestre }} &middot; {{ optativa.creditos }} creditos
      </div>
      <div class="q-mb-lg">
        <q-badge color="primary" class="q-mr-xs">{{ optativa.curso?.nome }}</q-badge>
        <q-badge v-if="optativa.departamento" outline color="primary" class="q-mr-xs">
          {{ optativa.departamento }}
        </q-badge>
        <span class="text-caption text-grey-6 q-ml-sm">
          {{ reviews.length }} avaliacao{{ reviews.length !== 1 ? 'oes' : '' }}
        </span>
      </div>

      <!-- Averages card -->
      <q-card class="q-mb-lg rating-summary-card">
        <q-card-section>
          <div class="text-subtitle1 text-weight-medium q-mb-md">Medias das Avaliacoes</div>
          <div class="row q-col-gutter-sm">
            <div v-for="item in averageItems" :key="item.label" class="col-6 col-sm-3">
              <div class="rating-display">
                <div class="rating-number">{{ medias[item.key] }}</div>
                <StarRating :model-value="Math.round(medias[item.key])" readonly size="sm" class="rating-stars" />
                <div class="rating-label">{{ item.label }}</div>
              </div>
            </div>
          </div>
        </q-card-section>
      </q-card>

      <!-- Reviews section -->
      <div class="text-h6 text-weight-medium q-mb-sm">Avaliacoes</div>

      <!-- Gate: not logged in -->
      <q-banner v-if="!isLoggedIn" rounded class="bg-info text-white gate-banner">
        <template v-slot:avatar>
          <q-icon name="lock" size="md" />
        </template>
        <div>
          <div class="text-weight-medium">Avaliacoes bloqueadas</div>
          <div class="text-caption" style="opacity: 0.9">
            Faca login para ver as avaliacoes dos colegas.
          </div>
        </div>
        <template v-slot:action>
          <q-btn flat color="white" label="Entrar" to="/login" />
        </template>
      </q-banner>

      <!-- Gate: no review posted -->
      <q-banner v-else-if="!canSeeReviews" rounded class="bg-warning gate-banner">
        <template v-slot:avatar>
          <q-icon name="rate_review" size="md" />
        </template>
        <div>
          <div class="text-weight-medium">Compartilhe sua experiencia</div>
          <div class="text-caption">
            Poste uma avaliacao para desbloquear os comentarios dos colegas.
          </div>
        </div>
        <template v-slot:action>
          <q-btn flat label="Avaliar agora" @click="scrollToForm" />
        </template>
      </q-banner>

      <!-- Review list (full access) -->
      <template v-if="canSeeReviews">
        <transition-group name="slide-up" tag="div">
          <ReviewCard v-for="review in reviews" :key="review.id" :review="review" />
        </transition-group>
      </template>

      <!-- Review list (censored) -->
      <template v-else>
        <q-card v-for="review in reviews" :key="review.id" class="q-mb-sm">
          <q-card-section class="row items-center justify-between">
            <div class="row items-center q-gutter-md">
              <div class="text-center">
                <StarRating :model-value="review.nota_geral" readonly size="sm" />
                <div class="text-caption text-grey">Geral</div>
              </div>
            </div>
            <div class="text-caption text-grey">
              {{ formatDate(review.created_at) }}
            </div>
          </q-card-section>
        </q-card>
      </template>

      <!-- Empty reviews -->
      <div v-if="reviews.length === 0" class="text-center q-my-lg">
        <q-icon name="rate_review" size="3rem" color="grey-5" />
        <div class="text-body1 text-grey-7 q-mt-sm">Nenhuma avaliacao ainda.</div>
        <div class="text-caption text-grey-6">Seja o primeiro a avaliar esta optativa!</div>
      </div>

      <!-- Review form -->
      <q-separator class="q-my-xl" />
      <div id="review-form-section">
        <div class="text-h6 text-weight-medium q-mb-md">Deixe sua avaliacao</div>

        <div v-if="!isLoggedIn" class="text-center q-pa-md">
          <q-icon name="login" size="2rem" color="grey-5" class="q-mb-sm" />
          <div class="text-grey-7">
            Faca <router-link to="/login">login</router-link> para avaliar esta optativa.
          </div>
        </div>

        <div v-else-if="hasAlreadyReviewed" class="text-center q-pa-md">
          <q-icon name="check_circle" size="2rem" color="positive" class="q-mb-sm" />
          <div class="text-grey-7">Voce ja avaliou esta optativa.</div>
        </div>

        <ReviewForm v-else :optativa-id="optativa.id" @submitted="loadData" />
      </div>
    </q-page>
  </div>
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
const loading = ref(true)

const isLoggedIn = computed(() => !!localStorage.getItem('token'))

const canSeeReviews = computed(() => {
  const user = JSON.parse(localStorage.getItem('user') || 'null')
  if (user?.role === 'admin') return true
  return userHasPosted.value === true
})

const medias = computed(() => {
  if (reviews.value.length === 0) return { geral: 0, didatica: 0, conteudo: 0, dificuldade: 0 }
  const avg = (key) => parseFloat((reviews.value.reduce((s, r) => s + r[key], 0) / reviews.value.length).toFixed(1))
  return {
    geral: avg('nota_geral'),
    didatica: avg('nota_didatica'),
    conteudo: avg('nota_conteudo'),
    dificuldade: avg('nota_dificuldade'),
  }
})

const averageItems = [
  { key: 'geral', label: 'Geral' },
  { key: 'didatica', label: 'Didatica' },
  { key: 'conteudo', label: 'Conteudo' },
  { key: 'dificuldade', label: 'Dificuldade' },
]

function formatDate(dateStr) {
  if (!dateStr) return ''
  return dateStr.split('T')[0]
}

function scrollToForm() {
  document.getElementById('review-form-section')?.scrollIntoView({ behavior: 'smooth' })
}

onMounted(() => loadData())

async function loadData() {
  try {
    const id = route.params.id
    const { data } = await api.get(`/optativas/${id}`)
    optativa.value = data.optativa
    reviews.value = data.reviews
    userHasPosted.value = data.user_has_posted
    hasAlreadyReviewed.value = data.has_already_reviewed
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.rating-summary-card {
  border-left: 4px solid #1a237e;
}
</style>
