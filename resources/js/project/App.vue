<template>
  <div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link bar-code" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside v-if="!hasToken"  class="main-sidebar sidebar-dark-primary elevation-4">
      <menu-component />
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div v-if="!hasToken" class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <router-view></router-view>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
    </div>
    <!-- Main Footer -->
    <footer v-if="!hasToken" class="main-footer">
      <strong>Copyright &copy; 2023 <a href="https://Ingebsoluciones.cl">Ingebsoluciones.cl</a>.</strong>
      Todos los derechos reservados.
    </footer>
    <div v-if="hasToken" class="content">
      <div class="content-fluid">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    hasToken() {
      return this.$route.path.includes("token");
    }
  }
};
</script>