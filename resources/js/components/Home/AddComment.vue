

<template>
  <div class="add-comment">
    <!-- <v-textarea label="Escreva um Comentário" v-model="comment"></v-textarea> -->
    <v-card class="pt-3 bg-light bg-gradient"
      elevation="2"
    >

      <v-textarea v-model="comment"
        class="mx-2"
        label="Escreva um Comentário"
        rows="1"
        prepend-icon="mdi-comment"
      ></v-textarea>
    </v-card>
    <v-card-actions class="justify-end ms-5 pe-5 pt-3">
      <v-btn text @click="save"
        color="primary"
      >Comentar</v-btn>
      <v-btn text @click="clean"
      >Limpar</v-btn>
    </v-card-actions>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "AddComment",
  props: {
    snackTrigger: Function,
    cardComments : Array,
    createRoute: String,
    card_id: Number,
    user_id: Number,
  },
  data() {
    return {
      comment: null,
    };
  },
  methods: {

    save() {
      if(this.comment)
        axios
          .post(this.createRoute, {
            user_id: this.user_id,
            card_id: this.card_id,
            content: this.comment,
          })
          .then((response) => {

            this.snackTrigger(true, response.data.message)

            this.cardComments.push(response.data.comment) ;
            this.clean() ;
          })
          .catch((error) => {
            console.log(error);
          })
        ;
      else alert('O comentário não pode ser vazio.')
    },

    clean() {
      this.comment = null
    },
  },
};
</script>
<style scoped>
</style>