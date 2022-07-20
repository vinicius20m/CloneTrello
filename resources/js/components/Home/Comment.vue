

<template>
  <div class="comment mb-3">

    <span class="fs-5 text-secondary ms-3">{{comment.user.name}}</span>
    <v-card class="py-3 px-2 bg-light bg-gradient"
      elevation="2"
    >
      <span class="fs-6">{{comment.content}}</span>
    </v-card>

    <div v-if="comment.user_id == $userId" class="text-end me-5">

      <v-menu
        transition="slide-y-transition"
        v-model="editMenu"
        :close-on-content-click="false"
        top :nudge-left="485" :nudge-bottom="25" :nudge-width="590"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" v-on="on"
            x-small color="primary" text
          >Editar<v-icon small>mdi-pencil</v-icon></v-btn>
        </template>

        <v-card>
          <v-textarea class="mt-0 px-2 pt-3"
            v-model="content" autofocus rows="1"
          ></v-textarea>

        <v-card-actions class="pt-0 pb-1 justify-end me-5">
          <v-btn small color="primary" text @click="save"> Salvar </v-btn>
          <v-btn small text @click="cancel"> <v-icon>mdi-close</v-icon> </v-btn>
        </v-card-actions>
        </v-card>
      </v-menu>

      <v-menu
        transition="slide-y-transition"
        v-model="removeMenu"
        max-width="auto"
        :close-on-content-click="false"
        left
      >

        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" v-on="on"
            color="error" x-small text
          >
            Excluir<v-icon small>mdi-close</v-icon>
          </v-btn>
        </template>

        <v-card>
          <v-toolbar color="error" height="30"></v-toolbar>
          <h4 class="px-3 py-3 mb-0 align-middle">Remover o Comentário ?</h4>
          <v-card-actions class="pt-0">
            <v-btn small color="error" text @click="remove"> Sim </v-btn>
            <v-btn small text @click="cancel"> Não </v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </div>



  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Comment",
  props: {
    snackTrigger: Function,
    comment: Object,
    routes: Object,
    index: Number,
    cardComments: Array,
  },
  data() {
    return {
      content: this.comment.content,
      editMenu: false,
      removeMenu: false,
    };
  },
  methods: {

    save() {
      if(this.content)
        axios
          .post(this.routes.edit+this.comment.id, {
            content: this.content,
          })
          .then((response) => {

            this.snackTrigger(true, response.data.message)

            this.cardComments.splice(this.index, 1, response.data.comment)
            this.editMenu = false
          })
          .catch((error) => {
            console.log(error);
          })
        ;
      else alert('O comentário não pode ser vazio.')
    },

    remove() {
      axios
        .get(this.routes.destroy+this.comment.id)
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.cardComments.splice(this.index, 1)
          this.cancel()
        })
        .catch((error) => {
          console.log(error)
        })
      ;
    },

    cancel() {
      this.content = this.comment.content
      this.editMenu = false
      this.removeMenu = false
    },

    vote() {

    }
  },
};
</script>
<style scoped>
</style>