<template>
  <q-page padding>
    <div class="text-h4 q-mb-md">Optativas</div>

    <q-input v-model="search" outlined dense debounce="300" placeholder="Buscar por nome, codigo, professor..."
      class="q-mb-md">
      <template v-slot:prepend>
        <q-icon name="search" />
      </template>
    </q-input>

    <div class="row q-col-gutter-md">
      <div v-for="optativa in filteredOptativas" :key="optativa.id" class="col-12 col-sm-6 col-md-4">
        <ElectiveCard :optativa="optativa" @click="$router.push(`/optativas/${optativa.id}`)" />
      </div>
    </div>

    <div v-if="filteredOptativas.length === 0" class="text-center text-grey q-mt-xl">
      Nenhuma optativa encontrada.
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '../boot/api'
import ElectiveCard from '../components/ElectiveCard.vue'

const optativas = ref([])
const search = ref('')

onMounted(async () => {
  const { data } = await api.get('/optativas')
  optativas.value = data
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
