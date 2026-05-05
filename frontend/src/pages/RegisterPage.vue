<template>
  <q-page class="flex flex-center q-pa-md">
    <div style="width: 420px; max-width: 90vw">
      <!-- Brand -->
      <div class="text-center q-mb-lg">
        <q-icon name="school" size="3rem" color="primary" />
        <div class="text-h4 text-weight-bold text-primary q-mt-sm">AvaliaOptativa</div>
        <div class="text-body1 text-grey-6">Crie sua conta para comecar a avaliar</div>
      </div>

      <q-card flat bordered class="card-hover">
        <q-card-section class="q-pb-none">
          <div class="text-h6 text-weight-medium">Cadastro</div>
        </q-card-section>

        <q-card-section>
          <q-form @submit="register">
            <q-input v-model="name" label="Nome completo" outlined dense
              class="q-mb-sm" autocomplete="name"
              :rules="[v => !!v || 'Obrigatorio']">
              <template v-slot:prepend>
                <q-icon name="person" />
              </template>
            </q-input>

            <q-input v-model="email" label="Email" type="email" outlined dense
              class="q-mb-sm" autocomplete="email"
              :rules="[v => !!v || 'Obrigatorio']">
              <template v-slot:prepend>
                <q-icon name="email" />
              </template>
            </q-input>

            <div class="row q-col-gutter-sm q-mb-sm">
              <div class="col-6">
                <q-input v-model="matricula" label="Matricula" outlined dense
                  :rules="[v => !!v || 'Obrigatorio']">
                  <template v-slot:prepend>
                    <q-icon name="badge" />
                  </template>
                </q-input>
              </div>
              <div class="col-6">
                <q-input v-model="curso" label="Curso" outlined dense
                  :rules="[v => !!v || 'Obrigatorio']">
                  <template v-slot:prepend>
                    <q-icon name="book" />
                  </template>
                </q-input>
              </div>
            </div>

            <q-input v-model="password" label="Senha" type="password" outlined dense
              class="q-mb-sm" autocomplete="new-password"
              :rules="[v => v.length >= 6 || 'Minimo 6 caracteres']">
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
            </q-input>

            <q-input v-model="passwordConfirmation" label="Confirmar Senha" type="password"
              outlined dense class="q-mb-md" autocomplete="new-password"
              :rules="[v => v === password || 'Senhas nao conferem']">
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
            </q-input>

            <q-btn type="submit" color="primary" label="Cadastrar" class="full-width"
              size="md" :loading="loading" no-caps />

            <div v-if="error" class="text-negative text-center q-mt-sm">
              <q-icon name="error" size="xs" /> {{ error }}
            </div>
          </q-form>
        </q-card-section>

        <q-separator />

        <q-card-section class="text-center">
          <span class="text-grey-7">Ja tem conta?</span>
          <router-link to="/login" class="q-ml-xs text-primary text-weight-medium"
            style="text-decoration: none">
            Fazer login
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
