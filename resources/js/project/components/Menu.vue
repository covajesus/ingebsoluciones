<template>
    <div>
        
        <!-- /.navbar -->
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/home" class="nav-link active" data-widget="pushmenu" @click="toggleSidebar">
                            <i class="nav-icon fas fa-home"></i>
                            Inicio
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="rol_id == 1">
                        <router-link to="/collection" class="nav-link" data-widget="pushmenu" @click="toggleSidebar">
                            <i class="nav-icon fas fa-money-bill"></i>
                            Recaudaciones
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="rol_id == 1">
                        <router-link to="/branch_office" class="nav-link" data-widget="pushmenu" @click="toggleSidebar">
                            <i class="nav-icon fas fa-building"></i>
                            Sucursales
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="rol_id == 1">
                        <router-link to="/cashier" class="nav-link" data-widget="pushmenu" @click="toggleSidebar">
                            <i class="nav-icon fas fa-cash-register"></i>
                            Cajas
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/setting" class="nav-link" data-widget="pushmenu" @click="toggleSidebar">
                            <i class="nav-icon fas fa-user"></i>
                            Perfil
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a :href="'/logout'" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
                            Salir
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </div>
  </template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            rol_id: '',
            sidebarVisible: true
        }
    },
    methods: {
        toggleSidebar() {
            const pushMenuBtn = this.$refs.pushMenuBtn;

            $(pushMenuBtn).PushMenu('toggle');
        }
    },
    mounted() {
        axios.get('/session-data')
        .then(response => {
            this.rol_id = response.data.rol_id;
        })
        .catch(error => {
            console.log(error);
        });
    }
}
</script>