<template>
  <q-page padding>
    <!-- Profile header -->
    <q-card flat class="q-mb-lg profile-header-card">
      <q-card-section>
        <div class="row items-center q-col-gutter-md">
          <div>
            <q-avatar size="64px" color="primary" text-color="white" font-size="28px">
              {{ initials }}
            </q-avatar>
          </div>
          <div>
            <div class="text-h5 text-weight-medium">{{ user?.name }}</div>
            <div class="text-body1 text-grey-7">{{ user?.email }}</div>
            <div class="text-caption text-grey-6 q-mt-xs">
              {{ user?.curso }} &middot; Matricula: {{ user?.matricula }}
            </div>
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Stats row -->
    <div class="row q-col-gutter-md q-mb-lg">
      <div class="col-4 col-sm-3">
        <q-card flat bordered class="text-center">
          <q-card-section>
            <q-icon name="rate_review" size="md" color="primary" />
            <div class="text-h5 text-weight-bold q-mt-xs">{{ reviews.length }}</div>
            <div class="text-caption text-grey-7">Avaliacoes</div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-4 col-sm-3">
        <q-card flat bordered class="text-center">
          <q-card-section>
            <q-icon name="star" size="md" color="accent" />
            <div class="text-h5 text-weight-bold q-mt-xs">{{ avgRating }}</div>
            <div class="text-caption text-grey-7">Media Geral</div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-4 col-sm-3">
        <q-card flat bordered class="text-center">
          <q-card-section>
            <q-icon name="visibility" size="md" :color="reviews.length > 0 ? 'positive' : 'grey-6'" />
            <div class="text-h6 text-weight-bold q-mt-xs" style="line-height: 1.2">
              {{ reviews.length > 0 ? 'Desbloqueado' : 'Bloqueado' }}
            </div>
            <div class="text-caption text-grey-7">Acesso a reviews</div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-4 col-sm-3" v-if="reviews.length > 0">
        <q-card flat bordered class="text-center">
          <q-card-section>
            <q-icon name="visibility_off" size="md" color="orange" />
            <div class="text-h5 text-weight-bold q-mt-xs">{{ anonymousCount }}</div>
            <div class="text-caption text-grey-7">Anonimas</div>
          </q-card-section>
        </q-card>
      </div>
    </div>

    <!-- Reviews list -->
    <div class="text-h6 text-weight-medium q-mb-sm">Minhas Avaliacoes</div>

    <div v-if="reviews.length === 0" class="text-center q-my-lg">
      <q-icon name="rate_review" size="3rem" color="grey-5" />
      <div class="text-body1 text-grey-7 q-mt-sm">Voce ainda nao postou nenhuma avaliacao.</div>
      <div class="text-caption text-grey-6 q-mt-xs">
        Avalie uma optativa para desbloquear as avaliacoes dos colegas.
      </div>
      <q-btn color="primary" label="Ver optativas" to="/" class="q-mt-md" no-caps />
    </div>

    <transition-group name="slide-up" tag="div">
      <ReviewCard v-for="review in reviews" :key="review.id" :review="review" />
    </transition-group>
  </q-page>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../boot/api'
import ReviewCard from '../components/ReviewCard.vue'

const user = computed(() => JSON.parse(localStorage.getItem('user') || 'null'))
const reviews = ref([])

const initials = computed(() => {
  if (!user.value?.name) return '?'
  return user.value.name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase()
})

const avgRating = computed(() => {
  if (reviews.value.length === 0) return '-'
  const avg = reviews.value.reduce((s, r) => s + r.nota_geral, 0) / reviews.value.length
  return avg.toFixed(1)
})

const anonymousCount = computed(() => reviews.value.filter(r => r.anonima).length)

onMounted(async () => {
  const { data } = await api.get('/avaliacoes/minha')
  reviews.value = data
})
</script>

<style scoped>
.profile-header-card {
  border-left: 4px solid #1a237e;
}
</style>
