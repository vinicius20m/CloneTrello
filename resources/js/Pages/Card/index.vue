<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Card List'" />
            <div class="row">

                  <h1 class="mt-3 col-md-9">Cards List</h1>
                  <div class="col-md-3 d-flex align-items-end">
                        <Link class="btn btn-outline-success" type="button" as="button" :href="routes.create">
                              <i class="bi bi-plus-circle"></i> Create
                        </Link>
                  </div>
            </div>
            <h2 style="color: green" v-if="$page.props.flash.success">{{$page.props.flash.message}}</h2>
            <h2 style="color: red" v-else-if="$page.props.flash.error">{{$page.props.flash.message}}</h2>

            <table v-if="cards.length" class="table mt-5">
                  <thead class="thead-light">
                        <tr>
                              <th scope="col">Title</th>
                              <th scope="col">Content</th>
                              <th scope="col">Index</th>
                              <th scope="col">Lane</th>
                              <th scope="col">Actions</th>

                        </tr>
                  </thead>

                  <tbody>

                        <tr v-for="(card, index) in cards" :key="index">
                              <td>{{card.title}}</td>
                              <td>{{card.content}}</td>
                              <td>{{card.index}}</td>
                              <td>{{card.lane.title}}</td>
                              <td>

                                    <div class="btn-group">
                                          <Link :id="'edit-button_'+card.id"
                                                type="button" as="button"
                                                class="btn btn-outline-primary"
                                                :href="routes.edit+ card.id"
                                          >
                                                <i class="bi bi-pencil-square"></i>
                                          </Link>
                                          <button :id="'delete-button_'+card.id" type="button"
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="modal" :data-bs-target="'#deleteItemModal_'+card.id"
                                          >
                                                <i class="bi bi-trash3-fill"></i>
                                          </button>
                                    </div>
                              </td>

                              <!-- {{-- ------------------------ MODAL ------------------------- --}} -->
                              <!-- {{-- ------------------------ MODAL ------------------------- --}} -->
                              <div class="modal fade" :id="'deleteItemModal_'+card.id"
                                    tabIndex="-1" role="dialog" aria-hidden="true"
                              >
                                    <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 600px">

                                          <div class="modal-content">

                                                <div style="background: #b54c4c" class="modal-header">

                                                      <h4 class="modal-title" id="modalLongTitle">Deleting the Card: <strong>{{card.title}}</strong></h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                      <h2 class="text-center">You really want to delete this Card?</h2>
                                                </div>
                                                <div class="modal-footer">

                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                      <Link
                                                            type="button" as="button"
                                                            :href="routes.destroy+ card.id"
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
            <h3 class="text-center mt-5" v-else>Nenhum Cartão por enquanto. Crie um novo <Link :href="routes.create">Aqui</Link>.</h3>
      </Layout>
</template>
<script>
export default {
      name: 'indexPage',
      props: {

            appName: String,
            cards: Array,
            routes: Object,
      }
}
</script>