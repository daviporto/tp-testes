import { createApp } from 'vue'
import { Quasar, Notify, Dialog } from 'quasar'
import quasarIconSet from 'quasar/icon-set/material-icons'
import router from './router'
import App from './App.vue'

import '@quasar/extras/material-icons/material-icons.css'
import 'quasar/src/css/index.sass'
import './css/app.sass'

const app = createApp(App)

app.use(Quasar, {
  plugins: { Notify, Dialog },
  iconSet: quasarIconSet,
  config: {
    brand: {
      primary: '#1a237e',
      secondary: '#283593',
      accent: '#ffab00',
      dark: '#1d1d1d',
      positive: '#2e7d32',
      negative: '#c62828',
      info: '#0277bd',
      warning: '#f57c00',
    },
  },
})

app.use(router)
app.mount('#app')
