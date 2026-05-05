<template>
  <q-page class="flex flex-center q-pa-md">
    <div style="width: 420px; max-width: 90vw">
      <!-- Brand -->
      <div class="text-center q-mb-lg">
        <q-icon name="school" size="3rem" color="primary" />
        <div class="text-h4 text-weight-bold text-primary q-mt-sm">AvaliaOptativa</div>
        <div class="text-body1 text-grey-6">Entre para avaliar e descobrir optativas</div>
      </div>

      <q-card flat bordered class="card-hover">
        <q-card-section class="q-pb-none">
          <div class="text-h6 text-weight-medium">Login</div>
        </q-card-section>

        <q-card-section>
          <q-form @submit="login">
            <q-input v-model="email" label="Email" type="email" outlined dense
              class="q-mb-sm" autocomplete="email"
              :rules="[v => !!v || 'Obrigatorio']">
              <template v-slot:prepend>
                <q-icon name="email" />
              </template>
            </q-input>

            <q-input v-model="password" label="Senha" type="password" outlined dense
              class="q-mb-md" autocomplete="current-password"
              :rules="[v => !!v || 'Obrigatorio']">
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
            </q-input>

            <q-btn type="submit" color="primary" label="Entrar" class="full-width"
              size="md" :loading="loading" no-caps />

            <div v-if="error" class="text-negative text-center q-mt-sm">
              <q-icon name="error" size="xs" /> {{ error }}
            </div>
          </q-form>
        </q-card-section>

        <q-separator />

        <q-card-section class="text-center">
          <span class="text-grey-7">Nao tem conta?</span>
          <router-link to="/registro" class="q-ml-xs text-primary text-weight-medium"
            style="text-decoration: none">
            Criar conta
          </router-link>
        </q-card-section>
      </q-card>
    </div>
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
