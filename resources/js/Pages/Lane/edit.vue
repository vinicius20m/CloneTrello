<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Editing the Lane'" />

            <h1 class="mt-3 mb-3">Editing the Lane</h1>
            <form @submit.prevent="form.post(formRoute)">

                  <div>

                        <div v-if="Object.keys(errors).length" id="error-card" class="alert alert-danger row">
                              <div class="col-md-11">

                                    <ul>

                                          <li v-for="(error, index) in errors" :key="index"> {{ error }} </li>
                                    </ul>
                              </div>
                              <div class="col-md-1">

                                    <button type="button" data-bs-target="#error-card" class="btn-close mt-1"
                                          aria-label="close" id="hide-error" data-bs-dismiss="alert"
                                    ></button>
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-6">
                              <input v-model="form.title"  required class="m-4 form-control" placeholder="title" name="title" type="text">
                        </div>
                        <div class="col-md-6">
                              <select v-model="form.board_id" required class="m-4 form-control" name="board_id" id="board_id">
                                    <option disabled value="">Select the Board</option>
                                    <option v-for="(board, index) in boards"
                                          :key="index" :value="board.id"
                                    >{{board.title}}</option>
                              </select>
                        </div>
                  </div>
                  <textarea v-model="form.description" class="m-4 form-control" placeholder="description" name="description" >
                  </textarea>
                  <div class="text-end">
                        <button class="btn btn-success" type="submit">Edit</button>
                  </div>
            </form>
      </Layout>
</template>
<script>
export default {

      name: 'editingCardPage',
      props: {

            appName: String,
            formRoute: String,
            errors: Object,
            lane: Object,
            boards: Array,
      },
      data() {
            return {
                  form: this.$inertia.form({

                        title: this.lane.title,
                        description: this.lane.description,
                        board_id: this.lane.board_id,
                  })
            }
      },
}
</script>