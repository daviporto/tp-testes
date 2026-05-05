<template>
  <q-layout view="hHh Lpr lFf">
    <q-header elevated class="bg-primary">
      <q-toolbar>
        <q-toolbar-title>
          <router-link to="/" class="text-white" style="text-decoration: none">
            Avaliacao de Optativas
          </router-link>
        </q-toolbar-title>
        <q-space />
        <template v-if="isLoggedIn">
          <q-btn flat :label="user?.name" to="/perfil" />
          <q-btn v-if="user?.role === 'admin'" flat label="Admin" to="/admin" />
          <q-btn flat label="Sair" @click="logout" />
        </template>
        <template v-else>
          <q-btn flat label="Login" to="/login" />
          <q-btn flat label="Cadastro" to="/registro" />
        </template>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const isLoggedIn = computed(() => !!localStorage.getItem('token'))
const user = computed(() => JSON.parse(localStorage.getItem('user') || 'null'))

function logout() {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')
}
</script>
