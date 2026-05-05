<template>
  <q-page padding class="flex flex-center">
    <q-card style="width: 400px; max-width: 90vw">
      <q-card-section class="text-h5">Login</q-card-section>
      <q-card-section>
        <q-form @submit="login">
          <q-input v-model="email" label="Email" type="email" outlined dense class="q-mb-sm"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-input v-model="password" label="Senha" type="password" outlined dense class="q-mb-md"
            :rules="[v => !!v || 'Obrigatorio']" />
          <q-btn type="submit" color="primary" label="Entrar" class="full-width" :loading="loading" />
          <div v-if="error" class="text-negative q-mt-sm">{{ error }}</div>
        </q-form>
      </q-card-section>
      <q-card-section class="text-center">
        <router-link to="/registro">Criar conta</router-link>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../boot/api'

const router = useRouter()
const email = ref('')
const password = ref('')
const loading = ref(false)
const error = ref('')

async function login() {
  loading.value = true
  error.value = ''
  try {
    const { data } = await api.post('/auth/login', {
      email: email.value,
      password: password.value,
    })
    localStorage.setItem('token', data.token)
    localStorage.setItem('user', JSON.stringify(data.user))
    router.push('/')
  } catch (e) {
    error.value = e.response?.data?.message || 'Erro ao fazer login'
  } finally {
    loading.value = false
  }
}
</script>
