<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Creating a Card'" />

            <h1 class="mt-3 mb-3">Creating a Card</h1>
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
                              <select v-model="form.lane_id" class="m-4 form-control" name="lane_id" id="lane_id">
                                    <option disabled value="">Select the Lane</option>
                                    <option v-for="(lane, index) in lanes"
                                          :key="index" :value="lane.id"
                                    >{{lane.title}}</option>
                              </select>
                        </div>
                  </div>
                  <textarea v-model="form.content" class="m-4 form-control" placeholder="content" name="content" >
                  </textarea>
                  <div class="text-end">
                        <button class="btn btn-success" type="submit">Create</button>
                  </div>
            </form>
      </Layout>
</template>
<script>
export default {

      name: 'creatingCardPage',
      props: {

            appName: String,
            lanes: Array,
            formRoute: String,
            errors: Object,
      },
      data() {
            return {
                  form: this.$inertia.form({

                        title: null,
                        content: null,
                        lane_id: null,
                  })
            }
      },
}
</script>