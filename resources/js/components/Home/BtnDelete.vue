

<template>
  <div :class="'btn-delete-' + type">

    <v-btn
      color="error"
      :elevation="isLane ? 11 : 1"
      :icon="isCard"
      :small="isLane"
      :x-small="isCard"
      @click="dialog = true"
      ><v-icon>mdi-close</v-icon></v-btn
    >

    <v-dialog
      v-model="dialog"
      max-width="750"
    >
      <v-card>
        <v-toolbar
          color="error"
          height="auto"
          min-height="64"
          dark
          class="h4 d-flex align-center"
        >Deletando {{isLane? 'a Lista:' : 'o Cartão:'}} {{title}}</v-toolbar>
        <v-card-text>
          <div class="text-h3 pa-12">Tem certeza de que deseja excluir  {{isLane? 'esta Lista' : 'este Cartão'}}?</div>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn
            text @click="deleting"
            x-large
            outlined
            color="error"
          >Sim</v-btn>
          <v-btn
            text @click="dialog = false"
            x-large
            outlined
          >Não</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "BtnDelete",
  props: {
    snackTrigger: Function,
    can_delete: Number,
    deleteRoute: String,
    index: Number,
    collection: Array,
    title: String,
    id: Number,
    type: String,
  },
  methods: {
    deleting() {
      axios.get(this.deleteRoute+this.id).then((response) => {

        this.snackTrigger(true, response.data.message)

        this.collection.splice(this.index, 1)
      }).catch((error) => {
        console.log(error)
      })
      this.dialog = false
    },
  },
  data() {
    return {
      isCard: this.type == "card" ? true : false,
      isLane: this.type == "lane" ? true : false,
      dialog: false,
    };
  },
};
</script>
<style>
.btn-delete-lane {
  margin-left: 0.3rem;
}

.btn-delete-card {
  margin-left: 1.1rem;
}

.btn-delete-lane button:hover {
  transform: scale(110%);
  box-shadow: -0.2rem 0.3rem 1rem 0.8px #c7080879 !important ;
}

.v-dialog {
  border-radius: 11px !important;
}
</style>