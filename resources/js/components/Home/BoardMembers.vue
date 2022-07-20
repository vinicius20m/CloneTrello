

<template>
  <div class="board-members">
    <div>
      <v-menu
        transition="slide-y-transition"
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="450"
        offset-y bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="indigo" dark v-bind="attrs" v-on="on">
            <v-icon>mdi-account-multiple</v-icon> Membros
          </v-btn>
        </template>

        <v-card class="px-5">
          <v-card-title class="text-center">
          <v-icon class="me-2">mdi-account-multiple</v-icon>  Membros
          </v-card-title>

          <v-divider class="bg-dark"></v-divider>

          <div class="row">

            <v-text-field class="col-md-8 member-search-bar"
              v-model="search"
              label="Procurar" prepend-inner-icon="mdi-account-search"
              placeholder="Digite o nome do Membro"
              dense filled rounded
            ></v-text-field>

            <BtnAddMember v-if="can_add_member"
              :snackTrigger="snackTrigger"
              class="col-md-4 justify-center d-flex align-center pt-0"
              :permissions="original_permissions"
              :board_id="board_id"
              :inviteRoute="routes.invite"
              :users="users.filter(userIsNotMember)"
            ></BtnAddMember>
          </div>


          <MemberChip v-for="(permission, index) in permissions"
            :snackTrigger="snackTrigger"
            :key="permission.id"
            :can_remove_member="can_remove_member"
            :current_user_permissions="user_permissions"
            :members="permissions"
            :index="index"
            :editRoute="routes.edit"
            :destroyRoute="routes.destroy"
          ></MemberChip>
        </v-card>
      </v-menu>
    </div>
  </div>
</template>
<script>
import BtnAddMember from './BtnAddMember.vue';
import MemberChip from './MemberChip.vue';
export default {
    name: "BoardMembers",
    props: {
      snackTrigger: Function,
      user_permissions: Object,
      can_add_member: Number,
      can_remove_member: Number,
      original_permissions: Array,
      board_id: Number,
      routes: Object,
      users: Array,
    },
    data() {
        return {
            menu: false,
            search: "",
            members_id: this.original_permissions.map((v)=>{return v.user_id}),
            permissions: this.original_permissions,
        };
    },
    created(){
      // console.log(this.members_id);
    },
    watch: {
      search: function(){
        if(this.search.length){
          this.permissions = this.original_permissions.filter(this.searchMember)
        }else
        this.permissions = this.original_permissions
      }
    },
    methods: {

      userIsNotMember(user){
        return !this.members_id.includes(user.id)
      },

      searchMember(member){
        return member.user.name.toUpperCase().indexOf(this.search.toUpperCase()) > -1
      }
    },
    components: { BtnAddMember, MemberChip }
};
</script>
<style scoped>
</style>