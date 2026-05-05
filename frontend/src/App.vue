<template>
  <q-layout view="hHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <div class="toolbar-inner">
          <router-link to="/" class="row items-center no-wrap" style="text-decoration: none">
            <q-icon name="school" size="md" color="white" class="q-mr-sm" />
            <q-toolbar-title shrink class="text-white" style="font-weight: 700; letter-spacing: -0.5px">
              AvaliaOptativa
            </q-toolbar-title>
          </router-link>

          <q-space />

          <template v-if="isLoggedIn">
            <div class="row items-center q-gutter-sm">
              <q-btn flat round icon="person" to="/perfil" class="text-white">
                <q-tooltip>{{ user?.name }}</q-tooltip>
              </q-btn>
              <q-btn v-if="user?.role === 'admin'" flat round icon="admin_panel_settings" to="/admin" class="text-white">
                <q-tooltip>Painel Admin</q-tooltip>
              </q-btn>
              <q-btn flat round icon="logout" @click="logout" class="text-white">
                <q-tooltip>Sair</q-tooltip>
              </q-btn>
            </div>
          </template>
          <template v-else>
            <q-btn flat label="Entrar" to="/login" class="text-white" />
            <q-btn outline label="Cadastrar" to="/registro" class="text-white" style="border-color: rgba(255,255,255,0.5)" />
          </template>
        </div>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </q-page-container>

    <q-footer bordered>
      <div class="q-pa-md text-center">
        <div class="row justify-center q-gutter-md text-caption">
          <span>AvaliaOptativa &mdash; Trabalho Pratico &mdash; Topicos Especiais</span>
        </div>
        <div class="text-caption q-mt-xs" style="opacity: 0.5">
          Sistema de avaliacao de optativas academicas
        </div>
      </div>
    </q-footer>
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
