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
                                    <o-table-column field="branch_office" label="Sucursal" v-slot="p">
                                        {{ p.row.branch_office }}
                                    </o-table-column>
                                    <o-table-column field="cashier" label="Caja" v-slot="p">
                                        {{ p.row.cashier }}
                                    </o-table-column>
                                    <o-table-column field="cash_amount" label="Monto Bruto Efectivo" v-slot="p">
                                        $ {{ formatPrice(p.row.cash_amount) }}
                                    </o-table-column>
                                    <o-table-column field="card_amount" label="Monto Bruto Tarjeta" v-slot="p">
                                        $ {{ formatPrice(p.row.card_amount) }}
                                    </o-table-column>
                                    <o-table-column field="created_at" label="Fecha de Recaudación" v-slot="p">
                                        {{ formatDate(p.row.created_at) }}
                                    </o-table-column>
                                    <o-table-column field="created_at" label="Última Actualización" v-slot="p">
                                        {{ formatLongDate(p.row.updated_at) }}
                                    </o-table-column>
                                    <o-table-column field="" label="" v-slot="p">
                                        <router-link :to="`/dte/show/${p.row.branch_office_id}/${p.row.cashier_id}/${formatDate(p.row.created_at)}`" class="btn btn-success mr-2">
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
import moment from 'moment'

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
            this.$axios.get('api/collection?page='+this.currentPage).then((res) => {
                this.posts = res.data.data;
                this.isLoading = false;
            })
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        formatDate(value) {
            var day;

            value = value.split("T");
            value = value[0].split("-");
            value = value[2] + "-" + value[1] + "-" + value[0];
            return value;
        },
        formatLongDate(value) {
            var value_1;
            var value_2;
            var value_3;
            var time;

            value_1 = value.split("T");
            time = value_1[1].split(".");
            value_2 = value_1[0].split("-");
            value_3 = value_2[2] + "-" + value_2[1] + "-" + value_2[0] + " " + time[0];
            return value_3;
        }
    },
    async mounted() {
        this.listPage();
    }
}
</script>