<template>
    <div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Editar Perfil</h3>
                            </div>
                            <form @submit.prevent="submit">
                                <div class="card-body">
                                    <o-field label="Correo" :variant="errors.email ? 'danger' : 'primary'" :message="errors.email">
                                        <o-input type="email" v-model="form.email" model-value="" maxlength="100"> </o-input>
                                    </o-field>
                                    <o-field label="Nueva Contraseña" :variant="errors.password ? 'danger' : 'primary'" :message="errors.password">
                                        <o-input type="password" v-model="form.password" model-value="" maxlength="100"> </o-input>
                                    </o-field>
                                </div>
                                <b-field type="hidden" label="Campo oculto">
                                    <input v-model="form.id" type="hidden">
                                </b-field>
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
                id: '',
                email: '',
                password: ''
            },
            errors: {
                id: '',
                email: '',
                password: ''
            }
        }
    },
    mounted() {
        this.getUser();
    },
    methods: {
        submit() {
            this.$axios.put('/api/user/' + this.form.id, this.form)
                .then(response => {
                    this.$router.push('/setting')
                })
                .catch(error => {
                    console.log(error.response.data)

                    if(error.response.data.email) {
                        this.errors.email = error.response.data.email[0]
                    }

                    if(error.response.data.password) {
                        this.errors.password = error.response.data.password[0]
                    }
                })
        },
        async getUser() {
            try {
                // Obtén el ID de sesión de Laravel
                const UserIdResponse = await this.$axios.get('/user_id');
                const userId = UserIdResponse.data.user_id;

                // Realiza la solicitud para obtener los datos del usuario
                const userResponse = await this.$axios.get('/api/user/' + userId);
                this.form.id = userId;
                this.form.email = userResponse.data.data.email;
                this.form.password = userResponse.data.data.password;
            } catch (error) {
                console.log(error);
            }
        }
    },
}
</script>