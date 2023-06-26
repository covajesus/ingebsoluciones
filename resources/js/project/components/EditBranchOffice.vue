<template>
    <div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Editar Sucursal</h3>
                            </div>
                            <form @submit.prevent="submit">
                                <div class="card-body">
                                    <o-field label="Nombre de la Sucursal" :variant="errors.branch_office ? 'danger' : 'primary'" :message="errors.branch_office">
                                        <o-input type="text" v-model="form.branch_office" model-value="" maxlength="100"> </o-input>
                                    </o-field>
                                    <o-field label="Dirección" :variant="errors.address ? 'danger' : 'primary'" :message="errors.address">
                                        <o-input type="text" v-model="form.address" model-value="" maxlength="100"> </o-input>
                                    </o-field>
                                    <o-field label="Fecha de Apertura" :variant="errors.opening_date ? 'danger' : 'primary'" :message="errors.opening_date">
                                        <o-input type="date" v-model="form.opening_date" model-value="" maxlength="100"> </o-input>
                                    </o-field>
                                </div>

                                <div class="card-footer">
                                    <o-field
                                    ><!-- Label left empty for spacing -->
                                        <o-button variant="success" native-type="submit"> Actualizar </o-button>
                                    </o-field>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                branch_office: '',
                address: '',
                opening_date: ''
            },
            errors: {
                branch_office: '',
                address: '',
                opening_date: ''
            }
        }
    },
    methods: {
        submit() {
            this.$axios.put('/api/branch_office/' + this.$route.params.id, this.form)
                .then(response => {
                    this.$router.push('/branch_office')
                })
                .catch(error => {
                    console.log(error.response.data)
                })
        },
        edit() {
            this.$axios.get('/api/branch_office/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.form = response.data.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }
    },
    async mounted() {
        axios.get('/session-data')
        .then(response => {
            this.id = response.data.id;
            this.listPage(this.id); // pasa this.id a listPage()
        })
        .catch(error => {
            console.log(error);
        });
        
        this.edit();
    }
}
</script>