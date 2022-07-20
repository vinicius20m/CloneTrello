

<template>
  <div class="row member-chip">
    <div class="col-md-8 py-0">
      <v-menu
        transition="slide-y-transition"
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="450"
        offset-y bottom
        :max-width="450"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-if="!members[index].is_owner" rounded small
            class="ms-4" color="primary" dark
            v-bind="attrs" v-on="allowEditPermissions?on:false"
          >
            <v-icon class="me-2">mdi-account-edit-outline</v-icon> {{members[index].user.name}}
          </v-btn>

          <v-btn v-else
            color="indigo" rounded
          >
            <v-icon class="me-2">mdi-account-tie</v-icon> {{members[index].user.name}}
          </v-btn>
        </template>

        <v-card class="px-5">
          <v-card-title>
            Editar as Permissões
          </v-card-title>
          <v-divider class="bg-dark"></v-divider>

          <v-select clearable clear-icon="mdi-close-circle-outline"
            class="col-md-10" solo
            v-model="user_permissions"
            :items="permissions"
            label="Permissões deste Membro"
            multiple rounded small-chips deletable-chips
          >
            <template v-slot:prepend-item>
              <v-list-item
                ripple
                @mousedown.prevent
                @click="toggle"
              >
                <v-list-item-action>
                  <v-icon :color="user_permissions.length > 0 ? 'indigo darken-4' : ''">
                    {{ icon }}
                  </v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-title>
                    Selecionar Todas
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="mt-2"></v-divider>
            </template>
          </v-select>
          <v-divider class="bg-dark"></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="primary" text @click="save"> Salvar </v-btn>
            <v-btn text @click="cancel"> Cancelar </v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </div>
      <!-- <v-spacer></v-spacer> -->
    <div class="col-md-2">

      <v-menu
        transition="slide-y-transition"
        v-model="deleteMenu"
        :close-on-content-click="false"
        :nudge-width="450"
        offset-y bottom
        :max-width="450"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-if="showDeleteBtn" icon
            class="ms-4 text-end" small style="top: -35%"
            color="error" dark v-bind="attrs" v-on="on"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </template>

        <v-card>

          <v-toolbar
              color="error"
              dark
              class="h5"
          >
            <v-card-title>
              Removendo: {{members[index].user.name}}
            </v-card-title>
          </v-toolbar>

          <div class="px-5">
            <br>
            <h4 class="text-center">Deseja remover este membro do Quadro?</h4>
            <v-divider class="bg-dark"></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="error" text @click="remove"> Sim </v-btn>
              <v-btn text @click="cancel"> Não </v-btn>
            </v-card-actions>
          </div>
        </v-card>
      </v-menu>
    </div>
  </div>
</template>
<script>
export default {
  name: "MemberChip",
  props: {
    snackTrigger: Function,
    current_user_permissions: Object,
    can_remove_member: Number,
    members: Array,
    index: Number,
    editRoute: String,
    destroyRoute: String,
  },
  created() {
    let permissionsList = this.permissions.map((result)=>result.value)
    let list = []
    permissionsList.map((r) => {if(this.members[this.index][r]) list.push(r) });

    this.original_permissions = list
    this.user_permissions = list
  },
  data () {
    return {

      menu: false,
      deleteMenu: false,
      original_permissions: [],
      user_permissions: [],
      permissions: [
        {text: 'Criar', value: 'can_create'},
        {text: 'Editar', value: 'can_edit'},
        {text: 'Excluir', value: 'can_delete'},
        {text: 'Mover', value: 'can_move'},
        {text: 'Adicionar Membro', value: 'can_add_member'},
        {text: 'Editar e Remover Membro', value: 'can_remove_member'},
      ]
    }
  },

  computed: {
    allowAllPermissions () {
      return this.user_permissions.length === this.permissions.length
    },
    allowSomePermissions () {
      return this.user_permissions.length > 0 && !this.allowAllPermissions
    },
    icon () {
      if (this.allowAllPermissions) return 'mdi-close-box'
      if (this.allowSomePermissions) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
    showDeleteBtn() {
      return (this.can_remove_member &&
        !this.members[this.index].is_owner &&
        this.members[this.index].user_id != this.current_user_permissions.user_id)
    },
    allowEditPermissions() {
      return (
        this.can_remove_member &&
        this.members[this.index].user_id != this.current_user_permissions.user_id
      )
    }
  },
  methods: {
    toggle () {
      this.$nextTick(() => {
        if (this.allowAllPermissions) {
          this.user_permissions = []
        } else {
          this.user_permissions = this.permissions.map((result) => result.value)
        }
      })
    },


    save() {
      // console.log(this.user_permissions)
      axios.post(this.editRoute+this.members[this.index].id, {
        permissions: this.user_permissions,
      }).then((response) => {

        this.snackTrigger(true, response.data.message)

        // this.permission = response.data.permission
        this.members.splice(this.index, 1, response.data.permission)
        this.menu = false
      }).catch((error) => {
        console.log(error);
      })
    },

    cancel() {
      this.menu = false
      this.deleteMenu = false
      this.user_permissions = this.original_permissions
    },

    remove() {
      axios.get(this.destroyRoute+this.members[this.index].id).then((response) => {

        this.snackTrigger(true, response.data.message)

        this.members.splice(this.index, 1)
      }).catch((error) => {
        console.log(error)
      })
    },
  }
};
</script>
<style scoped>
.member-chip div{
  height: 45px;
}
</style>