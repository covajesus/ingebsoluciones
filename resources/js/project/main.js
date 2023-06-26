import { createApp } from 'vue';
import App from './App.vue';
import Menu from './components/Menu.vue';
import router from './router';
import axios from 'axios';
import Oruga from '@oruga-ui/oruga-next'
import '@oruga-ui/oruga-next/dist/oruga.css'
import '@oruga-ui/oruga-next/dist/oruga-full.css'
import QrReader from 'vue3-qr-reader';

import "@mdi/font/css/materialdesignicons.min.css"

const app = createApp(App).use(Oruga).use(router);

app.use(QrReader);
app.component('menu-component', Menu);

app.mount('#app');

app.config.globalProperties.$axios = axios;
window.axios = axios;