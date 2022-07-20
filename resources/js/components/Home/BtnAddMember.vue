

<template>
  <div class="btn-add-member">
    <div>
      <v-menu
        transition="slide-x-transition"
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="450"
        offset-x left top
        :max-width="450"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="success" dark v-bind="attrs" small v-on="on">
            <v-icon>mdi-account-plus</v-icon> Adicionar
          </v-btn>
        </template>

        <v-card class="px-5">
          <v-card-title>
            Adicionar Membro
          </v-card-title>

          <v-divider class="bg-dark"></v-divider>
          <v-autocomplete
            v-model="user" placeholder="Selecione"
            auto-select-first label="Membro"
            clearable rounded no-data-text="Nenhum usuário disponível"
            :items="users" item-value="id" item-text="name"
          ></v-autocomplete>
          <v-divider class="bg-dark"></v-divider>

          <v-card-title>Permissões</v-card-title>
          <v-select clearable clear-icon="mdi-close-circle-outline"
            v-model="user_permissions"
            :items="permissionsList" solo
            label="Permissões do novo Membro"
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

            <v-btn color="success" text @click="invite"> Enviar Convite </v-btn>
            <v-btn text @click="cancel"> Cancelar </v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </div>
  </div>
</template>
<script>
export default {
  name: "BtnAddMember",
  props: {
    snackTrigger: Function,
    permissions: Array,
    board_id: Number,
    inviteRoute: String,
    users: Array,
  },
  data () {
    return {

      menu: false,
      user: null,
      user_permissions: [],
      permissionsList: [
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
      return this.user_permissions.length === this.permissionsList.length
    },
    allowSomePermissions () {
      return this.user_permissions.length > 0 && !this.allowAllPermissions
    },
    icon () {
      if (this.allowAllPermissions) return 'mdi-close-box'
      if (this.allowSomePermissions) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
  },
  methods: {
    toggle () {
      this.$nextTick(() => {
        if (this.allowAllPermissions) {
          this.user_permissions = []
        } else {
          this.user_permissions = this.permissionsList.map((result) => result.value)
        }
      })
    },


    invite() {
      axios.post(this.inviteRoute, {
        board_id: this.board_id,
        user_id: this.user,
        permissions: this.user_permissions,
      }).then((response) => {

        this.snackTrigger(true, response.data.message)

        // this.permissions.push(response.data.permission)
        this.cancel()
      }).catch((error) => {
        console.log(error);
      })
    },

    cancel() {
      this.menu = false
      this.user = null
      this.user_permissions = []
    }
  }
};
</script>
<style scoped>
</style>