<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Creating a Lane'" />

            <h1 class="mt-3 mb-3">Creating a Lane</h1>
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

                              <input v-model="form.title" class="m-4 form-control" placeholder="title" name="title" type="text">
                        </div>
                        <div class="col-md-6">
                              <select v-model="form.board_id" class="m-4 form-control" name="board_id" id="board_id">
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
                        <button class="btn btn-success" type="submit">Create</button>
                  </div>
            </form>
      </Layout>
</template>
<script>
export default {

      name: 'creatingLanePage',
      props: {

            appName: String,
            formRoute: String,
            errors: Object,
            boards: Array,
      },
      data() {
            return {
                  form: this.$inertia.form({

                        title: null,
                        description: null,
                        board_id: null,
                  })
            }
      },
}
</script>