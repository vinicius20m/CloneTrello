

<template>
  <div class="checklist_item">
    <input class="align-top mt-1" v-if="user_permissions.can_edit"
      type="checkbox" :value="true" v-model="checked"
      @click="check"
    >
    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :nudge-width="80"
      max-width="auto"
      :close-on-content-click="false"
    >
      <template v-slot:activator="{ on, attrs }">
        <p ref="item_text" class="fs-6 me-5" :class="checked?'striked':''" v-bind="attrs" v-on="can_edit(on)">
          {{ item.title }}
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
        <v-btn color="error" class="aligne-middle ms-5 mb-1" icon x-small v-bind="attrs" v-on="on">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-toolbar class="text-light fs-5" color="error"
          max-height="auto"
          height="auto"
        >{{ item.title }}</v-toolbar>
        <h4 class="px-3 py-3 mb-0 align-middle">Remover o Item ?</h4>
        <v-card-actions class="pt-0">
          <v-btn small color="error" text @click="remove"> Sim </v-btn>
          <v-btn small text @click="cancel"> Não </v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
  </div>
</template>
<script>
import axios from 'axios';
export default {

  name: "ChecklistItem",

  props: {
    snackTrigger: Function,
    user_permissions: Object,
    item: Object,
    routes: Object,
    index: Number,
    items: Array,
  },

  data() {
    return {
      menu: false,
      deleteMenu: false,
      title: this.item.title,
      checked: this.item.checked,
    };
  },

  methods: {

    cancel() {
      this.menu = false;
      this.deleteMenu = false;
      this.title = this.item.title;
    },

    save() {
      axios
        .post(this.routes.edit+this.item.id, {
          title: this.title,
        })
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.items[this.index].title = this.title
          this.cancel();
        })
        .catch((error) => {
          console.log(error);
        })
      ;
    },

    remove() {
      axios
        .get(this.routes.destroy+this.item.id)
        .then((response) => {

          this.snackTrigger(true, response.data.message)

          this.items.splice(this.index, 1)
          this.cancel();
        })
        .catch((error) => {
          console.log(error);
        })
      ;
    },

    check() {

      if(this.user_permissions.can_edit)
      axios
        .post(this.routes.check+this.item.id, {
          checked: !this.checked,
        })
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error)
        })
      ;
    },

    can_edit(event){
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
    },

    checked: function(){
      const text=this.$refs.item_text;
      if(this.checked)
        text.classList.add('striked')
      else
        text.classList.remove('striked')
    }
  },
};
</script>
<style scoped>
.checklist_item p{
  display: inline;
}

.checklist_item p:hover{
  color: #6c6bafbe;
  transition: all 0.5ms;
}

.striked {
  text-decoration: line-through ;
}
</style>