<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Board List'" />
            <div class="row">

                  <h1 class="mt-3 col-md-9">Lista de Quadros</h1>
                  <div class="col-md-3 d-flex align-items-end">
                        <Link class="btn btn-outline-success" type="button" as="button" :href="routes.create">
                              <i class="bi bi-plus-circle"></i> Novo Quadro
                        </Link>
                  </div>
            </div>
            <h2 style="color: green" v-if="$page.props.flash.success">{{$page.props.flash.message}}</h2>
            <h2 style="color: red" v-else-if="$page.props.flash.error">{{$page.props.flash.message}}</h2>

            <table v-if="boards.length" class="table mt-5">
                  <thead class="thead-light">
                        <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Descrição</th>
                              <th scope="col">Ações</th>
                        </tr>
                  </thead>

                  <tbody>

                        <tr v-for="(board, index) in boards" :key="index">
                              <td>{{board.title}}</td>
                              <td>{{board.description}}</td>
                              <td>

                                    <div class="btn-group">
                                          <template v-if="board.pivot.is_owner">

                                                <Link :id="'edit-button_'+board.id"
                                                      type="button" as="button"
                                                      class="btn btn-outline-primary"
                                                      :href="routes.edit+ board.id"
                                                >
                                                      <i class="bi bi-pencil-square"></i>
                                                </Link>

                                                <button :id="'delete-button_'+board.id" type="button"
                                                      class="btn btn-outline-danger"
                                                      data-bs-toggle="modal" :data-bs-target="'#deleteItemModal_'+board.id"
                                                >
                                                      <i class="bi bi-trash3-fill"></i>
                                                </button>
                                          </template>
                                          <Link :id="'show-button_'+board.id"
                                                type="button" as="button"
                                                class="btn btn-outline-warning"
                                                :href="routes.show+ board.id"
                                          >
                                                <i class="bi bi-eye"></i>
                                          </Link>
                                    </div>
                              </td>

                              <!-- {{-- ------------------------ MODAL ------------------------- --}} -->
                              <!-- {{-- ------------------------ MODAL ------------------------- --}} -->
                              <div class="modal fade" :id="'deleteItemModal_'+board.id"
                                    tabIndex="-1" role="dialog" aria-hidden="true"
                              >
                                    <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 600px">

                                          <div class="modal-content">

                                                <div style="background: #b54c4c" class="modal-header">

                                                      <h4 class="modal-title" id="modalLongTitle">Excluindo o Quadro: <strong>{{board.title}}</strong></h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                      <h2 class="text-center">Você realmente quer excluir este Quadro?</h2>
                                                </div>
                                                <div class="modal-footer">

                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                      <Link
                                                            type="button" as="button"
                                                            :href="routes.destroy+ board.id"
                                                            class="btn btn-danger"
                                                            data-bs-dismiss="modal"
                                                      >Yes</Link>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </tr>
                  </tbody>
            </table>
            <h3 class="text-center mt-5" v-else>Nenhum Quadro por enquanto. Crie um novo <Link :href="routes.create">Aqui</Link>.</h3>
      </Layout>
</template>
<script>
export default {
      name: 'indexBoardPage',
      props: {

            appName: String,
            boards: Array,
            routes: Object,
      }
}
</script>