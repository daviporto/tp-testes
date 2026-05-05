<template>
  <q-page padding class="flex flex-center">
    <q-card style="width: 400px; max-width: 90vw">
      <q-card-section class="text-h5">Cadastro</q-card-section>
      <q-card-section>
        <q-form @submit="register">
          <q-input v-model="name" label="Nome" outlined dense class="q-mb-sm"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-input v-model="email" label="Email" type="email" outlined dense class="q-mb-sm"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-input v-model="matricula" label="Matricula" outlined dense class="q-mb-sm"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-input v-model="curso" label="Curso" outlined dense class="q-mb-sm"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-input v-model="password" label="Senha" type="password" outlined dense class="q-mb-sm"
            :rules="[v => v.length >= 6 || 'Minimo 6 caracteres']" />
          <q-input v-model="passwordConfirmation" label="Confirmar Senha" type="password" outlined dense class="q-mb-md"
            :rules="[v => v === password || 'Senhas nao conferem']" />
          <q-btn type="submit" color="primary" label="Cadastrar" class="full-width" :loading="loading" />
          <div v-if="error" class="text-negative q-mt-sm">{{ error }}</div>
        </q-form>
      </q-card-section>
      <q-card-section class="text-center">
        <router-link to="/login">Ja tem conta? Faca login</router-link>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../boot/api'

const router = useRouter()
const name = ref('')
const email = ref('')
const matricula = ref('')
const curso = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const loading = ref(false)
const error = ref('')

async function register() {
  loading.value = true
  error.value = ''
  try {
    const { data } = await api.post('/auth/register', {
      name: name.value,
      email: email.value,
      matricula: matricula.value,
      curso: curso.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    })
    localStorage.setItem('token', data.token)
    localStorage.setItem('user', JSON.stringify(data.user))
    router.push('/')
  } catch (e) {
    error.value = e.response?.data?.message || 'Erro ao cadastrar'
  } finally {
    loading.value = false
  }
}
</script>
