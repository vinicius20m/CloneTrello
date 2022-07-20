

<template>
  <div class="btn-add-checklist text-end mb-4">
    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
      offset-y bottom
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="success" class="me-5"
          dark v-bind="attrs" v-on="on" small
          elevation="5"
        >
          <v-icon>mdi-checkbox-multiple-marked-outline</v-icon> Nova CheckList
        </v-btn>
      </template>

      <v-card class="px-2">
        <v-card-title>Título da CheckList</v-card-title>

        <input class="form-control mb-3" ref="title_input"
            v-model="title" type="text"
        >
        <!-- <v-divider class="bg-dark"></v-divider> -->
        <v-card-actions>
          <v-btn color="success" text @click="add"> Adicionar </v-btn>
          <v-btn text @click="cancel"> Cancelar </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>
<script>
export default {
  name: "BtnAddChecklist",

  props: {
    snackTrigger: Function,
    card: Object,
    createRoute: String,
    checklists: Array,
  },

  data() {
      return {
          menu: false,
          title: null,
      };
  },

  methods: {

    cancel() {
      this.menu = false
      this.title = null
    },

    add() {
      axios.post(this.createRoute, {
        card_id: this.card.id,
        title: this.title,
      }).then((response)=>{

        this.snackTrigger(true, response.data.message)

        this.checklists.push(response.data.checklist)
        this.cancel()
      }).catch((error)=>{
        console.log(error)
      })
    }
  },

  watch: {
    menu: async function() {
      if(this.menu){

        await new Promise(resolve => setTimeout(resolve, 30));
        this.$refs.title_input.focus()
      }
    }
  }
};
</script>
<style scoped>
</style>