<template>
  <q-page padding>
    <div class="row items-center q-mb-md">
      <q-icon name="admin_panel_settings" size="md" color="primary" class="q-mr-sm" />
      <div class="text-h4 text-weight-bold">Painel Admin</div>
    </div>
    <div class="text-subtitle1 text-grey-7 q-mb-lg">
      Gerencie todas as avaliacoes do sistema
    </div>

    <q-card flat bordered>
      <q-table :rows="reviews" :columns="columns" row-key="id" :loading="loading"
        :pagination="{ rowsPerPage: 15 }"
        :no-data-label="'Nenhuma avaliacao encontrada'"
        :loading-label="'Carregando...'"
        :no-results-label="'Nenhum resultado'">
        <template v-slot:header="props">
          <q-tr :props="props">
            <q-th v-for="col in props.cols" :key="col.name" :props="props" class="text-weight-bold">
              {{ col.label }}
            </q-th>
          </q-tr>
        </template>

        <template v-slot:body-cell-anonima="props">
          <q-td :props="props">
            <q-badge :color="props.value ? 'orange' : 'green'" rounded class="q-px-sm">
              <q-icon :name="props.value ? 'visibility_off' : 'visibility'" size="xs" class="q-mr-xs" />
              {{ props.value ? 'Anonima' : 'Identificada' }}
            </q-badge>
          </q-td>
        </template>

        <template v-slot:body-cell-created_at="props">
          <q-td :props="props">
            <span class="text-caption">{{ formatDate(props.value) }}</span>
          </q-td>
        </template>

        <template v-slot:body-cell-acoes="props">
          <q-td :props="props">
            <q-btn flat round color="negative" icon="delete" size="sm" @click="confirmDelete(props.row)">
              <q-tooltip>Remover avaliacao</q-tooltip>
            </q-btn>
          </q-td>
        </template>
      </q-table>
    </q-card>
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
  { name: 'id', label: 'ID', field: 'id', sortable: true, align: 'left' },
  { name: 'user', label: 'Aluno', field: row => row.user?.name, sortable: true, align: 'left' },
  { name: 'optativa', label: 'Optativa', field: row => row.optativa?.nome, sortable: true, align: 'left' },
  { name: 'nota_geral', label: 'Geral', field: 'nota_geral', sortable: true, align: 'center' },
  { name: 'anonima', label: 'Tipo', field: 'anonima', sortable: true, align: 'center' },
  { name: 'created_at', label: 'Data', field: 'created_at', sortable: true, align: 'left' },
  { name: 'acoes', label: 'Acoes', field: 'acoes', align: 'center', sortable: false },
]

function formatDate(dateStr) {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleDateString('pt-BR', {
    day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
  })
}

onMounted(() => load())

async function load() {
  loading.value = true
  try {
    const { data } = await api.get('/admin/avaliacoes')
    reviews.value = data
  } finally {
    loading.value = false
  }
}

function confirmDelete(review) {
  $q.dialog({
    title: 'Remover Avaliacao',
    message: `Remover avaliacao de ${review.user?.name} para ${review.optativa?.nome}? Esta acao nao pode ser desfeita.`,
    ok: { label: 'Remover', color: 'negative' },
    cancel: { label: 'Cancelar', flat: true },
  }).onOk(async () => {
    await api.delete(`/admin/avaliacoes/${review.id}`)
    load()
  })
}
</script>
