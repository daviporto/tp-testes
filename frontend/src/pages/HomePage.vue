<template>
  <div>
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-inner">
        <div class="row items-center">
          <div class="col-12 col-md-8">
            <h1 class="text-h3 text-weight-bold q-mb-sm" style="line-height: 1.2">
              Avalie suas optativas e veja o que os colegas dizem
            </h1>
            <p class="text-h6 q-mb-md" style="opacity: 0.85; font-weight: 400">
              Compartilhe sua experiencia e tenha acesso a todas as avaliacoes.
            </p>
            <div v-if="!isLoggedIn" class="q-mb-md">
              <q-btn color="accent" text-color="dark" label="Comece agora" to="/registro" size="md"
                class="q-mr-sm" no-caps />
              <q-btn outline color="white" label="Fazer login" to="/login" size="md" no-caps />
            </div>
          </div>
          <div class="col-12 col-md-4 q-mt-md q-mt-md-none">
            <div class="row q-col-gutter-sm">
              <div class="col-6">
                <div class="stat-badge">
                  <div class="stat-number">{{ stats.optativas }}</div>
                  <div class="stat-label">Optativas</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-badge">
                  <div class="stat-number">{{ stats.avaliacoes }}</div>
                  <div class="stat-label">Avaliacoes</div>
                </div>
              </div>
              <div class="col-6 q-mt-sm">
                <div class="stat-badge">
                  <div class="stat-number">{{ stats.professores }}</div>
                  <div class="stat-label">Professores</div>
                </div>
              </div>
              <div class="col-6 q-mt-sm">
                <div class="stat-badge">
                  <div class="stat-number">{{ stats.cursos }}</div>
                  <div class="stat-label">Cursos</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <q-page padding>
      <!-- Search -->
      <div class="row items-center q-mb-lg">
        <div class="col-12 col-sm-6">
          <q-input v-model="search" outlined dense debounce="300"
            placeholder="Buscar por nome, codigo ou professor..."
            color="primary" class="search-input">
            <template v-slot:prepend>
              <q-icon name="search" color="primary" />
            </template>
            <template v-slot:append>
              <q-icon v-if="search" name="clear" class="cursor-pointer" @click="search = ''" />
            </template>
          </q-input>
        </div>
        <div class="col-12 col-sm-6 text-right q-mt-sm q-mt-sm-none">
          <span class="text-caption text-grey-7">
            {{ filteredOptativas.length }} de {{ optativas.length }} optativas
          </span>
        </div>
      </div>

      <!-- Loading skeleton -->
      <div v-if="loading" class="row q-col-gutter-md">
        <div v-for="i in 6" :key="i" class="col-12 col-sm-6 col-md-4">
          <q-card class="skeleton-pulse">
            <q-card-section>
              <q-skeleton type="text" width="80%" />
              <q-skeleton type="text" width="40%" class="q-mt-sm" />
              <q-skeleton type="text" width="60%" class="q-mt-sm" />
              <q-skeleton type="rect" height="20px" width="50%" class="q-mt-md" />
            </q-card-section>
          </q-card>
        </div>
      </div>

      <!-- Card grid -->
      <transition-group v-else name="slide-up" tag="div" class="row q-col-gutter-md">
        <div v-for="optativa in filteredOptativas" :key="optativa.id"
          class="col-12 col-sm-6 col-md-4">
          <ElectiveCard :optativa="optativa" @click="$router.push(`/optativas/${optativa.id}`)" />
        </div>
      </transition-group>

      <!-- Empty state -->
      <div v-if="!loading && filteredOptativas.length === 0" class="text-center q-my-xl">
        <q-icon name="search_off" size="4rem" color="grey-5" />
        <div class="text-h6 text-grey-7 q-mt-sm">Nenhuma optativa encontrada</div>
        <div class="text-body1 text-grey-6 q-mt-xs">
          Tente buscar por outro nome, codigo ou professor.
        </div>
      </div>
    </q-page>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../boot/api'
import ElectiveCard from '../components/ElectiveCard.vue'

const isLoggedIn = computed(() => !!localStorage.getItem('token'))
const optativas = ref([])
const search = ref('')
const loading = ref(true)

const stats = reactive({
  optativas: 0,
  avaliacoes: 0,
  professores: 0,
  cursos: 0,
})

import { reactive } from 'vue'

onMounted(async () => {
  try {
    const [optRes, profRes, cursoRes] = await Promise.all([
      api.get('/optativas'),
      api.get('/professores'),
      api.get('/cursos'),
    ])
    optativas.value = optRes.data
    stats.optativas = optRes.data.length
    stats.avaliacoes = optRes.data.reduce((sum, o) => sum + (o.total_avaliacoes || 0), 0)
    stats.professores = profRes.data.length
    stats.cursos = cursoRes.data.length
  } finally {
    loading.value = false
  }
})

const filteredOptativas = computed(() => {
  if (!search.value) return optativas.value
  const q = search.value.toLowerCase()
  return optativas.value.filter(o =>
    o.nome.toLowerCase().includes(q) ||
    o.codigo.toLowerCase().includes(q) ||
    o.professor?.nome?.toLowerCase().includes(q)
  )
})
</script>
