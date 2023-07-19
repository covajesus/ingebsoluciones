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
        async downloadPdf(folio) {
            const id = folio; // Reemplaza 123 con el ID del PDF que deseas descargar
            try {
                // Realizar la solicitud al backend para descargar el PDF
                const response = await axios.get(`/api/descargar-pdf/${id}`, {
                responseType: 'blob', // Para recibir la respuesta como un objeto Blob
                });

                // Crear una URL del blob y abrir el PDF en una nueva ventana/tab o descargarlo
                const url = URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
                const link = document.createElement('a');
                link.href = url;
                link.target = '_blank'; // Para abrir en una nueva ventana/tab
                link.download = 'dte_emitido_pdf.pdf'; // Nombre de archivo para la descarga
                link.click();

                // Limpiar la URL creada
                URL.revokeObjectURL(url);
            } catch (error) {
                console.error(error);
                // Aquí puedes mostrar un mensaje de error si algo falla
            }
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