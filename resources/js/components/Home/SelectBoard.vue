

<template>
  <div class="select-board">
    <v-menu
      transition="slide-y-transition"
      v-model="menu"
      :close-on-content-click="false"
      offset-y bottom
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn width="330" color="indigo"
          dark v-bind="attrs" v-on="on" class="btn-boards"
        >
          Quadro: {{board.title}} <v-icon></v-icon>
        </v-btn>
      </template>

      <v-card color="indigo lighten-4" light class="pb-4">
        <div class="board-option row m-0" v-for="(boardOption, index) in boards" :key="index">
          <Link class="text-center py-3"
            :href="showRoute+boardOption.id"
          >{{boardOption.title}}</Link>
        </div>
      </v-card>
    </v-menu>
  </div>
</template>
<script>
export default {
    name: "SelectBoard",
    props: {
      showRoute: String,
      boards: Array,
      board: Object,
    },
    data() {
        return {
            menu: false,
        };
    },
    components: { }
};
</script>
<style scoped>
.btn-boards {
  /* border-radius: 40% 40% 0 0; */
  border-radius: 10px 10px 0 0;
}

.board-option a{
  text-decoration: none;
  color: #fff !important ;
  transition: all 0.3s cubic-bezier(0.45, 0.05, 0, 0.61) !important;
}

.board-option a:hover{
  display: block;
  color: #373e62 !important ;
  transform: scale(110%)
}


.v-card, .v-sheet, .v-menu__content {
  border-radius: 0 0 10px 10px !important ;
}
</style>