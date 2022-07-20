
<template>
  <div class="card" @click="open">
    <slot />
    <v-dialog
      transition="dialog-top-transition"
      v-model="modal" max-width="760"
      scrollable
    >

      <v-card>
        <v-toolbar color="primary" dark :height="'auto'">
          <div class="toolbarr">
            <h4>Cartão: {{ card.title }}</h4>
            <span>Criado por: {{ card.author.name }}</span>
          </div>
        </v-toolbar>

        <v-card-text style="height: 550px">
          <div class="form-edit-card px-4 pt-5">

            <label class="h5 ms-3">Título</label>
            <input
              class="form-control mb-5"
              v-model="form.title"
              type="text"
              :disabled="user_permissions.can_edit ? false : true"
            />

            <label class="h5 ms-3">Descrição</label>
            <textarea
              class="form-control"
              v-model="form.content"
              :disabled="user_permissions.can_edit ? false : true"
            ></textarea>

            <v-card-actions class="justify-end pb-1">
              <v-btn
                text @click="save"
                outlined color="primary"
                :disabled="user_permissions.can_edit ? false : true"
              >Salvar</v-btn>
              <v-btn text @click="cancel" outlined>Cancelar</v-btn>
            </v-card-actions>
          </div>

          <v-divider class="bg-dark"></v-divider>

          <div class="px-4">
            <div class="checklists pt-5 pb-5">
              <h5 class="text-center mt-5">CheckLists</h5>

              <BtnAddChecklist v-if="user_permissions.can_create"
                :snackTrigger="snackTrigger"
                :createRoute="cardRoutes.checklist.create"
                :card="card"
                :checklists="card.checklists"
              ></BtnAddChecklist>

              <Checklist
                v-for="(checklist, index) in card.checklists" :key="index"
                :snackTrigger="snackTrigger"
                :user_permissions="user_permissions"
                :cardRoutes="cardRoutes"
                :checklists="card.checklists"
                :index="index"
                :checklist="checklist"
              >{{checklist.title}}</Checklist>
            </div>

            <div class="comments">
              <h5 class="text-center mt-2 mb-5 pb-4">Comentários</h5>

              <AddComment class="mb-5"
                :snackTrigger="snackTrigger"
                :cardComments="card.comments"
                :card_id="card.id"
                :user_id="$userId"
                :createRoute="cardRoutes.comment.create"
              ></AddComment>

              <v-divider class="bg-dark mx-5 my-1 mt-5 mb-5"></v-divider>

              <Comment v-for="(comment, index) in card.comments" :key="index"
                :snackTrigger="snackTrigger"
                :routes="cardRoutes.comment"
                :comment="comment"
                :cardComments="card.comments"
                :index="index"
              ></Comment>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import BtnAddChecklist from "./BtnAddChecklist.vue";
import Checklist from "./Checklist.vue";
import AddComment from "./AddComment.vue";
import Comment from "./Comment.vue";
export default {

  name: "Card",

  props: {
    snackTrigger: Function,
    user_permissions: Object,
    card: Object,
    cardRoutes: Object,
  },

  data() {
    return {
      modal: false,
      form: {
        title: this.card.title,
        content: this.card.content,
      },
    };
  },

  methods: {

    open(event) {
      let target = event.target.classList[0];
      // console.log(target)
      let missClasses = ["v-icon", "v-btn__content", "v-btn"];
      if (!missClasses.includes(target)) this.modal = true;
    },

    save() {
      if (this.user_permissions.can_edit) {
        axios
          .post(this.cardRoutes.edit + this.card.id, {
            title: this.form.title,
            content: this.form.content,
          })
          .then((response) => {

            this.snackTrigger(true, response.data.message)

            this.card.title = this.form.title;
            this.card.content = this.form.content;
            this.modal = false;
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alert("Você não tem permissão para editar");
        return this.cancel();
      }
    },

    cancel() {
      this.form.title = this.card.title;
      this.form.content = this.card.content;
      this.modal = false;
    },
  },

  components: { BtnAddChecklist, Checklist, AddComment, Comment },
};
</script>
<style scoped>
.card {
  background: var(--color-white);
  padding: 0 0.8rem;
  border-radius: 0.4rem;
  box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
  margin-bottom: 0.8rem;
  font-size: 1.3rem;
  cursor: pointer;
}

.toolbarr {
  display: flex;
  flex-direction: column !important ;
}
.card:hover {
  background: #d6e0ded1;
}

.card p {
  margin: 0;
}
</style>