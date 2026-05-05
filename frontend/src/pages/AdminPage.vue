<template>
  <q-page padding>
    <div class="text-h4 q-mb-md">Painel Admin</div>

    <q-table :rows="reviews" :columns="columns" row-key="id" :loading="loading">
      <template v-slot:body-cell-anonima="props">
        <q-td :props="props">
          <q-badge :color="props.value ? 'orange' : 'green'">
            {{ props.value ? 'Anonima' : 'Identificada' }}
          </q-badge>
        </q-td>
      </template>
      <template v-slot:body-cell-acoes="props">
        <q-td :props="props">
          <q-btn flat round color="negative" icon="delete" @click="confirmDelete(props.row)">
            <q-tooltip>Remover</q-tooltip>
          </q-btn>
        </q-td>
      </template>
    </q-table>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'
import api from '../boot/api'

const $q = useQuasar()
const reviews = ref([])
const loading = ref(false)

const columns = [
  { name: 'id', label: 'ID', field: 'id', sortable: true },
  { name: 'user', label: 'Aluno', field: 'user.name', sortable: true },
  { name: 'optativa', label: 'Optativa', field: 'optativa.nome', sortable: true },
  { name: 'nota_geral', label: 'Nota', field: 'nota_geral', sortable: true },
  { name: 'anonima', label: 'Tipo', field: 'anonima', sortable: true },
  { name: 'created_at', label: 'Data', field: 'created_at', sortable: true },
  { name: 'acoes', label: 'Acoes', field: 'acoes' },
]

onMounted(() => load())

async function load() {
  loading.value = true
  const { data } = await api.get('/admin/avaliacoes')
  reviews.value = data
  loading.value = false
}

function confirmDelete(review) {
  $q.dialog({
    title: 'Confirmar',
    message: `Remover avaliacao de ${review.user.name}?`,
    ok: { label: 'Remover', color: 'negative' },
    cancel: { label: 'Cancelar' },
  }).onOk(async () => {
    await api.delete(`/admin/avaliacoes/${review.id}`)
    load()
  })
}
</script>
