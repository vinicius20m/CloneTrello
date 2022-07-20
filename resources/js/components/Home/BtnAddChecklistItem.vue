

<template>
  <div class="btn-add-checklist_item mb-3">
    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
      offset-y
      bottom
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary darken-2"
          v-bind="attrs"
          v-on="on"
          x-small
          elevation="2"
        >
          <v-icon small>mdi-plus-box-multiple-outline</v-icon> Adicionar Item
        </v-btn>
      </template>

      <v-card class="px-2">
        <v-card-title>Título do Item</v-card-title>

        <input class="form-control mb-3" v-model="title" type="text" ref="title_input" />
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

  name: "BtnAddChecklistItem",

  props: {
    snackTrigger: Function,
    checklist: Object,
    createRoute: String,
    items: Array,
  },

  data() {
    return {
      menu: false,
      title: null,
    };
  },

  methods: {

    cancel() {
      this.menu = false;
      this.title = null;
    },

    add() {
      axios
        .post(this.createRoute, {
          checklist_id: this.checklist.id,
          title: this.title,
        })
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.items.push(response.data.item)
          this.cancel();
        })
        .catch((error) => {
          console.log(error);
        })
      ;
    },
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