

<template>
    <div
        @click.stop="modal = true"
    >

        <h4>{{ lane.title }}</h4>

        <Snack :trigger="snack_trigger" :callback="snackCallback"
        ><span class="h5">{{snack_message}}</span></Snack>

        <v-dialog
            transition="dialog-top-transition"
            v-model="modal"
            max-width="600"
        >
            <v-card>
                <v-toolbar
                    color="primary"
                    dark
                    :height="'auto'"
                >
                    <div class="toolbarr">
                        <h4> Lista: {{lane.title}}</h4>
                        <span>Criada por: {{lane.author.name}}</span>
                    </div>
                </v-toolbar>
                <div class="form-edit-lane p-4">
                    <label class="h5 ms-3">Título</label>
                    <input class="form-control mb-3"
                        v-model="form.title" type="text"
                        :disabled="can_edit?false:true"
                    >
                    <label class="h5 ms-3">Descrição</label>
                    <textarea class="form-control"
                        v-model="form.description"
                        :disabled="can_edit?false:true"
                    ></textarea>
                </div>
                <v-card-actions class="justify-end">
                <v-btn
                    text @click="save"
                    outlined
                    color="primary"
                    :disabled="can_edit?false:true"
                >Salvar</v-btn>
                <v-btn
                    text @click="cancel"
                    outlined
                >Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    name: "EditDialog",
    props: {
        can_edit: Number,
        editRoute: String,
        lane: Object,
    },
    data () {
        return {
            snack_trigger: false,
            snack_message: null,
            modal: false,
            form: {
                title: this.lane.title,
                description: this.lane.description,
            }
        }
    },
    methods: {

        save() {

            if(this.can_edit){

                axios.post(this.editRoute+this.lane.id, {
                    title: this.form.title,
                    description: this.form.description
                }).then((response) => {

                    this.lane.title = this.form.title
                    this.lane.description = this.form.description

                    this.snack_message = response.data.message
                    this.snack_trigger = true

                    this.modal = false
                }).catch((error) => {
                    console.log(error)
                })
            }else {alert('Você não tem permissão para editar'); return this.cancel()}
        },

        cancel() {
            this.form.title = this.lane.title
            this.form.description = this.lane.description
            this.modal = false
        },

        snackCallback(result) {
            this.snack_trigger = result
        }
    }
}
</script>
<style scoped>

.toolbarr{
    display: flex;
    flex-direction: column !important ;
}
</style>