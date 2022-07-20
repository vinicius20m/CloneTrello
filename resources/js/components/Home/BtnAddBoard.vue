

<template>
  <div class="btn-add-board">
    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
      offset-y bottom
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="success"
          dark v-bind="attrs" v-on="on"
        >
          <v-icon>mdi-plus</v-icon> Novo Quadro
        </v-btn>
      </template>

      <v-card class="px-2">
        <v-card-title>Criando Quadro</v-card-title>

        <form @submit="create">
          <label class="h5 ms-3">Título</label>
          <input class="form-control mb-3"
              v-model="form.title" type="text"
          >
          <label class="h5 ms-3">Descrição</label>
          <textarea class="form-control"
              v-model="form.description"
          ></textarea>
          <v-divider class="bg-dark"></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success" text type="submit"> Criar </v-btn>
            <v-btn text @click="cancel"> Cancelar </v-btn>
          </v-card-actions>
        </form>
      </v-card>
    </v-menu>
  </div>
</template>
<script>
export default {
    name: "BtnAddBoard",
    props: {
      createRoute: String,
    },
    data() {
        return {
            menu: false,
            form: this.$inertia.form({
              title: null,
              description: null,
            })
        };
    },
    methods: {
      cancel() {
        this.menu = false
        this.form.title = null
        this.form.description = null
      },
      create() {
        this.form.post(this.createRoute)
        this.cancel()
      }
    }
};
</script>
<style scoped>
</style>