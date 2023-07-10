<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 margin-left">
                        <h1>
                            Boletas
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
                                    <o-table-column field="folio" label="Folio" numeric v-slot="p">
                                        {{ p.row.folio }}
                                    </o-table-column>
                                    <o-table-column field="total" label="Total" numeric v-slot="p">
                                        $ {{ formatPrice(p.row.total) }}
                                    </o-table-column>
                                    <o-table-column field="date" label="Fecha" numeric v-slot="p">
                                        {{ formatDate(p.row.created_at) }}
                                    </o-table-column>
                                    <o-table-column field="" label="" v-slot="p">
                                        <button class="btn btn-success mr-2" @click="downloadPDF(p.row.folio)">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </button>
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
        downloadPDF(folio) {
            const url = `/api/dte/download/${folio}`;

            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', '005-dte_emitido_pdf.pdf');
                link.click();
                })
                .catch(error => {
                console.error('Error al descargar el PDF:', error);
                });
        },
        updatePage() {
            setTimeout(this.listPage, 200);
        },
        listPage() {
            this.isLoading = true;
            this.$axios.get('/api/dte/show/' + this.$route.params.branch_office_id + '/' + this.$route.params.cashier_id + '/'+ this.$route.params.date +'?page='+this.currentPage).then((res) => {
                this.posts = res.data.data;
                this.isLoading = false;
            })
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        formatDate(value) {
            return moment(value).format('DD-MM-YYYY');
        }
    },
    async mounted() {
        this.listPage();
    }
}
</script>