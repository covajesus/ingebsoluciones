<template>
    <div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Agregar Caja</h3>
                            </div>
                            <form @submit.prevent="submit">
                                <div class="card-body">
                                    <o-field label="Sucursal" :variant="errors.branch_office_id ? 'danger' : 'primary'" :message="errors.branch_office_id">
                                        <o-select v-model="form.branch_office_id" model-value="" expanded>
                                            <option value="" selected disabled> - Seleccionar - </option>
                                            <option v-for="post in posts" :key="post.id" :value="post.id">{{ post.branch_office }}</option>
                                        </o-select>
                                    </o-field>
                                    <o-field label="Nombre de la Caja" :variant="errors.cashier ? 'danger' : 'primary'" :message="errors.cashier">
                                        <o-input type="text" v-model="form.cashier" model-value="" maxlength="100"> </o-input>
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
            posts: [],
            form: {
                branch_office_id: '',
                cashier: ''
            },
            errors: {
                branch_office_id: '',
                cashier: ''
            }
        }
    },
    methods: {
        listPage() {
            this.$axios.get('/api/branch_office/all_data/get_select').then((res) => {
                this.posts = res.data.data;
                console.log(this.posts)
            })
        },
        submit() {
            this.$axios.post('/api/cashier', this.form)
                .then(response => {
                    this.$router.push('/cashier')
                })
                .catch(error => {
                    console.log(error.response.data)
                    
                    if(error.response.data.branch_office_id) {
                        this.errors.branch_office_id = error.response.data.branch_office_id[0]
                    }

                    if(error.response.data.cashier) {
                        this.errors.cashier = error.response.data.cashier[0]
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
    async mounted() {
        axios.get('/session-data')
        .then(response => {
            this.id = response.data.id;
            this.listPage();
        })
        .catch(error => {
            console.log(error);
        });
    }
}
</script>