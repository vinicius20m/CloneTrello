

<template>
  <div class="btn-delete-board">
    <v-btn
      color="error"
      @click="dialog = true"
      >Excluir Quadro</v-btn
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
        >Excluindo o Quadro: {{board.title}}</v-toolbar>
        <v-card-text>
          <div class="text-h3 pa-12">Tem certeza de que deseja excluir este Quadro?</div>
          <span class="text-h4 pa-15">Esta ação não pode ser desfeita!</span>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn
            text @click="remove"
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

  name: "BtnDeleteBoard",

  props: {
    deleteRoute: String,
    board: Object,
  },

  data() {
    return {
      dialog: false,
    };
  },

  methods: {
    remove() {
      this.$inertia.post(deleteRoute+this.board.id)
    }
  },
};
</script>
<style>

.v-dialog {
  border-radius: 11px !important;
}
</style>