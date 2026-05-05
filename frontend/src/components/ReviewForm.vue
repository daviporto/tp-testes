<template>
  <q-card>
    <q-card-section>
      <q-form @submit="submit">
        <div class="row q-col-gutter-md q-mb-md">
          <div class="col-6 col-sm-3 text-center">
            <div class="text-caption">Nota Geral</div>
            <StarRating v-model="form.nota_geral" />
          </div>
          <div class="col-6 col-sm-3 text-center">
            <div class="text-caption">Didatica</div>
            <StarRating v-model="form.nota_didatica" />
          </div>
          <div class="col-6 col-sm-3 text-center">
            <div class="text-caption">Conteudo</div>
            <StarRating v-model="form.nota_conteudo" />
          </div>
          <div class="col-6 col-sm-3 text-center">
            <div class="text-caption">Dificuldade</div>
            <StarRating v-model="form.nota_dificuldade" />
          </div>
        </div>

        <q-input v-model="form.comentario" label="Comentario" type="textarea" outlined
          :rules="[v => !!v || 'Obrigatorio']" class="q-mb-sm" />

        <q-input v-model="tagsInput" label="Tags (separadas por virgula)" outlined class="q-mb-sm"
          hint="Ex: projetos praticos, provas dificeis" />

        <q-toggle v-model="form.anonima" label="Postar como anonimo" class="q-mb-md" />

        <q-btn type="submit" color="primary" label="Enviar Avaliacao" :loading="loading" />
        <div v-if="error" class="text-negative q-mt-sm">{{ error }}</div>
      </q-form>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { ref, reactive } from 'vue'
import api from '../boot/api'
import StarRating from './StarRating.vue'

const props = defineProps({
  optativaId: { type: [Number, String], required: true },
})
const emit = defineEmits(['submitted'])

const form = reactive({
  nota_geral: 0,
  nota_didatica: 0,
  nota_conteudo: 0,
  nota_dificuldade: 0,
  comentario: '',
  anonima: false,
})
const tagsInput = ref('')
const loading = ref(false)
const error = ref('')

async function submit() {
  if (!form.nota_geral || !form.nota_didatica || !form.nota_conteudo || !form.nota_dificuldade) {
    error.value = 'Selecione todas as notas'
    return
  }
  if (!form.comentario.trim()) {
    error.value = 'Escreva um comentario'
    return
  }
  loading.value = true
  error.value = ''
  try {
    const tags = tagsInput.value
      .split(',')
      .map(t => t.trim())
      .filter(Boolean)
    await api.post(`/optativas/${props.optativaId}/avaliacoes`, {
      ...form,
      tags: tags.length ? tags : null,
    })
    emit('submitted')
  } catch (e) {
    error.value = e.response?.data?.message || 'Erro ao enviar avaliacao'
  } finally {
    loading.value = false
  }
}
</script>
