
<template>
  <Layout :appName="appName">
    <Head :title="appName + '- Home '" />

    <Snack :trigger="snack_trigger" :callback="snackCallback"
    ><span class="h5">{{snack_message}}</span></Snack>

    <Header class=" row">
      <div class="col-md-1">

        <BtnDeleteBoard v-if="user_permissions.is_owner" class="text-start"
          :board="board"
          :deleteRoute="routes.board.destroy"
        ></BtnDeleteBoard>

        <BtnExitBoard v-else class="text-start"
          :board="board"
          :deleteRoute="routes.board.destroy"
        ></BtnExitBoard>
      </div>
      <div class="col-md-8 d-flex" style="justify-content:end;">

        <SelectBoard
          :showRoute="routes.board.show"
          :board="board"
          :boards="boards"
          class="me-5"
        ></SelectBoard>

        <BtnAddBoard
          class="ms-5"
          :createRoute="routes.board.create"
        ></BtnAddBoard>
      </div>

      <div class="col-md-3">
        <BoardMembers
          :snackTrigger="snackCallback"
          :user_permissions="user_permissions"
          :can_add_member="user_permissions.can_add_member"
          :can_remove_member="user_permissions.can_remove_member"
          :original_permissions="permissions"
          :board_id="board.id"
          :routes="routes.permission"
          :users="users"
          class=" text-end me-4"
        ></BoardMembers>
      </div>
    </Header>

    <div class="board">
      <Container
        drag-class="card-ghost"
        drop-class="card-ghost-drop"
        orientation="horizontal"
        group-name="board"
        @drag-start="handleDragStart('board', 0, $event)"
        @drop="handleColumnDrop($event)"
        drag-handle-selector=".lane-title"
        :get-child-payload="getBoardChildPayload"
        :drop-placeholder="{
          className: 'cards-drop-preview',
          animationDuration: '150',
          showOnTop: true
        }"
      >

        <Draggable v-for="(lane, index) in lanes" :key="lane.id">
          <div :id="'lane_'+index" class="lane">

            <div class="row lane-header">

              <EditDialog
                :can_edit="user_permissions.can_edit"
                :editRoute="routes.lane.edit"
                :lane="lanes[index]"
                class="lane-title col-md-10"
              ></EditDialog>

              <div class="col-md-2">
                <BtnDelete v-if="user_permissions.can_delete"
                  :snackTrigger="snackCallback"
                  :can_delete="user_permissions.can_delete"
                  :deleteRoute="routes.lane.destroy"
                  :index="index"
                  :collection="lanes"
                  :title="lane.title"
                  type="lane"
                  :id="lane.id"
                ></BtnDelete>
              </div>
            </div>

            <Container
              drag-class="card-ghost"
              drop-class="card-ghost-drop"
              group-name="lanes"
              @drag-start="handleDragStart('lane', index, $event)"
              @drop="handleDrop('lane', index, $event)"
              :get-child-payload="getChildPayload"
              :drop-placeholder="{ className: 'placeholder' }"
            >
              <Draggable v-for="(card, cardIndex) in lane.cards" :key="card.id">
                <Card
                  :snackTrigger="snackCallback"
                  :user_permissions="user_permissions"
                  :card="lanes[index].cards[cardIndex]"
                  :cardRoutes="routes.card"
                >
                  <div class="row">

                    <p class="col-md-10">{{ card.title }}</p>
                    <BtnDelete v-if="user_permissions.can_delete"
                      :snackTrigger="snackCallback"
                      :can_delete="user_permissions.can_delete"
                      :deleteRoute="routes.card.destroy"
                      :index="cardIndex"
                      :collection="lane.cards"
                      :title="card.title"
                      class="col-md-1"
                      type="card"
                      :id="card.id"
                    ></BtnDelete>
                  </div>
                </Card>
              </Draggable>
            </Container>
            <BtnAddCard v-if="user_permissions.can_create"
              :snackTrigger="snackCallback"
              :lane_id="lane.id"
              :createRoute="routes.card.create"
              :cards="lane.cards"
              :user_id="$page.props.user_id"
            ></BtnAddCard>
          </div>
        </Draggable>
      </Container>
      <BtnAddLane v-if="user_permissions.can_create"
        :snackTrigger="snackCallback"
        :lanes="lanes"
        :createRoute="routes.lane.create"
        :board_id="board.id"
        :user_id="$page.props.user_id"
      ></BtnAddLane>
    </div>
  </Layout>
</template>
<script>
import BtnAddLane from "../components/Home/BtnAddLane.vue"
import BtnAddCard from "../components/Home/BtnAddCard.vue"
import Header from "../components/Home/Header.vue";
import Card from "../components/Home/Card.vue";
import { Container, Draggable } from "vue-smooth-dnd";
import axios from "axios";
import BtnAddCard1 from "../components/Home/BtnAddCard.vue";
import BtnDelete from "../components/Home/BtnDelete.vue";
import EditDialog from "../components/Home/EditDialog.vue";
import BoardMembers from "../components/Home/BoardMembers.vue";
import SelectBoard from "../components/Home/SelectBoard.vue";
import BtnAddBoard from "../components/Home/BtnAddBoard.vue";
import Vue from 'vue';
import BtnDeleteBoard from "../components/Home/BtnDeleteBoard.vue";
import BtnExitBoard from "../components/Home/BtnExitBoard.vue";


export default {
  name: "homePage",
  props: {
    board: Object,
    boards: Array,
    appName: String,
    routes: Object,
    lanes: Array,
    users: Array,
    permissions: Array,
    user_permissions: Object,
  },
  components: {
    Header,
    Card,
    Container,
    Draggable,
    BtnAddLane,
    BtnAddCard,
    BtnAddCard1,
    BtnDelete,
    EditDialog,
    BoardMembers,
    SelectBoard,
    BtnAddBoard,
    BtnDeleteBoard,
    BtnExitBoard
},
  created() {
    Vue.prototype.$userId = this.user_permissions.user_id ;
  },
  data() {
    return {
      snack_trigger: false,
      snack_message: null,
      draggingCard: {
        lane: null,
        index: -1,
        cardData: {},
      },
    };
  },
  methods: {

    handleDragStart(type, laneIndex, result) {
      const { payload, isSource } = result;
      if (isSource)
        this.draggingCard = {
          lane: laneIndex,
          index: payload.index,
          cardData: {
            ...this.lanes[laneIndex].cards[payload.index],
          },
        };
    },

    handleDrop(type, laneIndex, result) {
      const { removedIndex, addedIndex } = result;

      if (laneIndex === this.draggingCard.lane && removedIndex === addedIndex) {
        return;
      }
      if (removedIndex === null && addedIndex === null) return;
      if(!this.user_permissions.can_move){ alert('Você não tem permissão para mover'); return }

      if (removedIndex !== null) {
        this.lanes[laneIndex].cards.splice(removedIndex, 1);
      }

      if (addedIndex !== null) {
        this.lanes[laneIndex].cards.splice(
          addedIndex,
          0,
          this.draggingCard.cardData
        );
      }
      if (addedIndex !== null) {
        // save the change in db
        // console.log(removedIndex, addedIndex);
        axios
          .post(this.routes.card.move + this.lanes[laneIndex].id, {
            card_id: this.draggingCard.cardData.id,
            oldIndex: this.draggingCard.index,
            newIndex: addedIndex,
          })
          .then((response) => {
            // console.log(response.data);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    handleColumnDrop(result) {
      const { removedIndex, addedIndex } = result;

      if(!this.user_permissions.can_move) return alert('Você não tem permissão para mover')
      if(removedIndex == addedIndex) return ;

      let draggingColumn = this.lanes[removedIndex]
      this.lanes.splice(removedIndex, 1);
      this.lanes.splice(
        addedIndex,
        0,
        draggingColumn
      );

      axios.
        post(this.routes.lane.move + this.board.id, {
          lane_id: draggingColumn.id,
          oldIndex: removedIndex,
          newIndex: addedIndex,
        }).then((response) => {
          console.log(response.data);
        }).catch((e) => {
          console.log(e);
        })
    },

    getChildPayload(index) {
      return { index };
    },

    getBoardChildPayload(index) {
      let el = document.getElementById('lane_'+index)
      setTimeout(() => {

        let placeholder = document.querySelector('.smooth-dnd-drop-preview-constant-class')
        // console.log(placeholder)
        placeholder.style.height = el.offsetHeight+'px'
      }, 30);
      // console.log(el.offsetHeight)
      return { index };
    },

    snackCallback(result, message='') {
      this.snack_trigger = result
      if(message)
        this.snack_message = message
    }
  },

// ----------------------------------------------------------
// ----------------------------------------------------------

  mounted() {

    const slider = document.querySelector('.board')
    // const lanes = document.querySelector('.lane')
    // console.log(lanes);
    let isDown = false
    let startX
    let scrollLeft

    slider.addEventListener('mousedown', (e) => {
      let scrollableClasses = [
        'smooth-dnd-draggable-wrapper',
        'board',
      ]
      isDown = scrollableClasses.includes(e.path[0].classList[0])? true : false
      slider.classList.add('active')
      // console.log(e.path[0].classList[0])
      startX = e.pageX - slider.offsetLeft
      scrollLeft = slider.scrollLeft
    })
    slider.addEventListener('mouseleave', () => {
      isDown = false
      slider.classList.remove('active')
    })
    slider.addEventListener('mouseup', () => {
      isDown = false
      slider.classList.remove('active')
    })
    slider.addEventListener('mousemove', (e) => {
      if(!isDown) return // stop the function before running
      e.preventDefault()
      const x = e.pageX - slider.offsetLeft
      const walk = (x - startX) * 1
      slider.scrollLeft = scrollLeft - walk
    })
  },
};
</script>

<style>
.board {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  padding: 4rem 0 ;
  overflow: overlay;
  min-height: 590px;
}
/* .board div{
  align-items: flex-start;
} */
.lane {
  background: rgb(219, 228, 235);
  min-width: 19rem;
  max-width: 19rem;
  border-radius: 0.61rem;
  box-shadow: 0.3rem 0.3rem 1.1rem 0.9px #21212169 ;
  margin: 0 0.8rem;
  /* margin-top: 4rem; */
  padding: 0 0.6rem;
  padding-bottom: 0.8rem ;
}
.lane-title {
  padding: 0.7rem 0.4rem;
  margin-bottom: 0.9rem;
}
.lane-title:hover{
  transition: color 0.11s cubic-bezier(0.58, 1.1, 0.95, 0.99);
  color: rgba(85, 105, 105, 0.884);
  cursor: pointer;
}

.placeholder {
  background: rgba(124, 124, 124, 0.493);
  border-radius: 0.4rem;
  transform: scaleY(0.85);
  transform-origin: 0% 0%;
}

.boardPlaceholder {
  background: rgba(124, 124, 124, 0.493);
  border-radius: 0.4rem;
  transform: scaleY(0.85);
  transform-origin: 0% 0%;
}

.card-ghost {
    transition: transform 0.18s ease;
    transform: rotateZ(5deg)
}

.card-ghost-drop {
    transition: transform 0.18s ease-in-out;
    transform: rotateZ(0deg)
}
.cards-drop-preview {
  background-color: rgba(150, 150, 200, 0.1);
  border: 1px dashed #abc;
  border-radius: 0.61rem;
  transform: scaleX(0.97);
  transform-origin: 0% 0%;
  margin-left: 12px;
}
</style>