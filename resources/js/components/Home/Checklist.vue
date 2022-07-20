

<template>
  <v-card class="py-3 px-2 mb-5 checklist bg-light bg-gradient"
    elevation="2"
  >
  <!-- <div class="checklist border rounded-2 mb-5 p-2"> -->

    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
    >
      <template v-slot:activator="{ on, attrs }">
        <p class="h5 me-5" v-bind="attrs" v-on="canEdit(on)">
          <v-icon>mdi-checkbox-multiple-marked-outline</v-icon> {{ checklist.title }}
        </p>
      </template>

      <v-card class="p-2">
        <input class="form-control" ref="title_input" v-model="title" type="text" />
        <!-- <v-divider class="bg-dark"></v-divider> -->
        <v-card-actions class="pb-0">
          <v-btn small color="primary" text @click="save"> Salvar </v-btn>
          <v-btn small text @click="cancel"> <v-icon>mdi-close</v-icon> </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>


    <v-menu v-if="user_permissions.can_delete"
      transition="slide-y-transition"
      v-model="deleteMenu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="error" class="ms-5 mb-2" icon x-small v-bind="attrs" v-on="on">
          <v-icon>mdi-close-box-multiple</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-toolbar class="text-light fs-5" color="error"
          max-height="auto"
          height="auto"
        >{{ checklist.title }}</v-toolbar>
        <h4 class="px-3 py-3 mb-0 align-middle">Remover a Checklist ?</h4>
        <v-card-actions class="pt-0">
          <v-btn small color="error" text @click="remove"> Sim </v-btn>
          <v-btn small text @click="cancel"> Não </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>

    <div class="items ps-3 mt-4">

      <ChecklistItem class="mb-1" v-for="(item, index) in checklist.items"
        :snackTrigger="snackTrigger"
        :user_permissions="user_permissions"
        :key="index"
        :item="item"
        :index="index"
        :items="checklist.items"
        :routes="cardRoutes.checklist_item"
      ></ChecklistItem>

      <BtnAddChecklistItem v-if="user_permissions.can_create"
        :snackTrigger="snackTrigger"
        :checklist="checklist"
        :items="checklist.items"
        :createRoute="cardRoutes.checklist_item.create"
      ></BtnAddChecklistItem>
    </div>
  <!-- </div> -->
  </v-card>
</template>
<script>
import BtnAddChecklistItem from "./BtnAddChecklistItem.vue";
import ChecklistItem from "./ChecklistItem.vue";

export default {

  name: "Checklist",

  props: {
    user_permissions: Object,
    snackTrigger: Function,
    checklist: Object,
    cardRoutes: Object,
    index: Number,
    checklists: Array,
  },

  data() {
    return {
      menu: false,
      deleteMenu: false,
      title: this.checklist.title,
    };
  },

  methods: {

    cancel() {
      this.menu = false;
      this.deleteMenu = false;
      this.title = this.checklist.title;
    },

    save() {
      axios
        .post(this.cardRoutes.checklist.edit + this.checklist.id, {
          title: this.title,
        })
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.checklists.splice(this.index, 1, response.data.checklist)
          this.menu = false
        })
        .catch((error) => {
          console.log(error);
        })
      ;
    },

    remove() {
      axios
        .get(this.cardRoutes.checklist.destroy+this.checklist.id)
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.checklists.splice(this.index, 1)
          this.cancel();
        })
        .catch((error) => {
          console.log(error);
        })
      ;
    },

    canEdit(event){
      if(this.user_permissions.can_edit)
        return event
      else return false
    },
  },

  watch: {
    menu: async function() {
      if(this.menu){

        await new Promise(resolve => setTimeout(resolve, 30));
        this.$refs.title_input.focus()
      }
    }
  },

  components: { BtnAddChecklistItem, ChecklistItem, },
};
</script>
<style scoped>
.checklist p {
  display: inline;
}

.checklist p:hover {
  color: #6c6bafbe;
  transition: all 0.5ms;
}
</style>