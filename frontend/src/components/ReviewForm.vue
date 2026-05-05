<template>
  <q-card flat bordered class="review-form-card">
    <q-card-section>
      <q-form @submit="submit">
        <!-- Star ratings -->
        <div class="text-subtitle2 text-weight-medium q-mb-md">Suas notas (1 a 5)</div>
        <div class="row q-col-gutter-md q-mb-lg">
          <div v-for="item in ratingFields" :key="item.key" class="col-6 col-sm-3 text-center">
            <div class="text-caption text-grey-7 q-mb-sm">{{ item.label }}</div>
            <StarRating v-model="form[item.key]" :size="'md'" />
            <div v-if="form[item.key] === 0" class="text-caption text-negative q-mt-xs">
              Obrigatorio
            </div>
          </div>
        </div>

        <q-separator class="q-mb-md" />

        <!-- Comment -->
        <div class="text-subtitle2 text-weight-medium q-mb-sm">Comentario</div>
        <q-input v-model="form.comentario" type="textarea" outlined
          placeholder="Conte sobre sua experiencia com esta optativa..."
          :rules="[v => (v && v.trim().length >= 10) || 'Minimo 10 caracteres']"
          counter maxlength="1000" class="q-mb-md" />

        <!-- Tags -->
        <div class="text-subtitle2 text-weight-medium q-mb-sm">Tags</div>
        <q-input v-model="tagsInput" outlined
          placeholder="Ex: projetos praticos, provas dificeis, muita leitura"
          hint="Separe as tags por virgula" class="q-mb-md" />

        <!-- Anonymous toggle -->
        <div class="q-mb-lg">
          <q-toggle v-model="form.anonima" color="primary" size="md"
            label="Postar como anonimo" left-label />
          <div class="text-caption text-grey-6 q-ml-lg" style="padding-left: 44px">
            Seu nome sera exibido como "Aluno Anonimo" para outros alunos.
            Administradores ainda poderao ver seu nome real.
          </div>
        </div>

        <q-separator class="q-mb-md" />

        <!-- Submit -->
        <q-btn type="submit" color="primary" label="Enviar Avaliacao"
          class="full-width" size="md" :loading="loading" no-caps />

        <div v-if="error" class="text-negative text-center q-mt-sm">
          <q-icon name="error" size="xs" /> {{ error }}
        </div>
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

const ratingFields = [
  { key: 'nota_geral', label: 'Nota Geral' },
  { key: 'nota_didatica', label: 'Didatica' },
  { key: 'nota_conteudo', label: 'Conteudo' },
  { key: 'nota_dificuldade', label: 'Dificuldade' },
]

async function submit() {
  if (!form.nota_geral || !form.nota_didatica || !form.nota_conteudo || !form.nota_dificuldade) {
    error.value = 'Selecione todas as notas'
    return
  }
  if (!form.comentario.trim() || form.comentario.trim().length < 10) {
    error.value = 'Escreva um comentario com pelo menos 10 caracteres'
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

<style scoped>
.review-form-card {
  border-radius: 12px;
  border-left: 4px solid #3949ab;
}
</style>
