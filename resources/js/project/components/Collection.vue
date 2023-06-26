<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 margin-left">
                        <h1>
                            Recaudaciones
                        </h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Datos</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <o-table :loading="isLoading" :data="posts.current_page && posts.data.length == 0 ? [] : posts.data">
                                    <o-table-column field="id" label="Id" numeric v-slot="p">
                                        {{ p.row.id }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Sucursal" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Caja" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Monto Bruto Efectivo" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Monto Bruto Tarjeta" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Fecha de Recaudación" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Última Actualización" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="" label="" v-slot="p">
                                        <router-link :to="`/cashier/edit/${p.row.id}`" class="btn btn-success mr-2">
                                            <i class="fa-solid fa-eye"></i>
                                        </router-link>
                                    </o-table-column>
                                </o-table>
                                <hr />
                                <o-pagination
                                v-if="posts.current_page && posts.data.length > 0"
                                @change="updatePage"
                                :total="posts.total"
                                v-model:current="currentPage"
                                :range-before="2"
                                :range-after="2"
                                order="centered"
                                :size="small"
                                :simple="false"
                                :rounded="true"
                                :per-page="posts.per_page"
                                >
                                </o-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            isLoading: true,
            currentPage: 1
        }
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 200);
        },
        listPage() {
            this.isLoading = true;
            this.$axios.get('api/cashier?page='+this.currentPage).then((res) => {
                this.posts = res.data.data;
                this.isLoading = false;
            })
        }
    },
    async mounted() {
        this.listPage();
    }
}
</script>