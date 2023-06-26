<template>
    <div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Agregar Sucursal</h3>
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
                                        <o-button variant="success" native-type="submit"> Guardar </o-button>
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
            this.$axios.post('/api/branch_office', this.form)
                .then(response => {
                    this.$router.push('/branch_office')
                })
                .catch(error => {
                    console.log(error.response.data)

                    if(error.response.data.branch_office) {
                        this.errors.branch_office = error.response.data.branch_office[0]
                    }

                    if(error.response.data.address) {
                        this.errors.address = error.response.data.address[0]
                    }

                    if(error.response.data.opening_date) {
                        this.errors.opening_date = error.response.data.opening_date[0]
                    }
                })
        },
        getUser() {
            this.$axios.get('/api/user')
                .then(response => {
                    console.log(response.data.name)
                    this.form.name = response.data.name
                    this.form.email = response.data.email
                })
                .catch(error => {
                    console.log(error.response.data)
                })
        }
    },
}
</script>