<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Editing the Card'" />

            <h1 class="mt-3 mb-3">Editing the Card</h1>
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
            card: Object,
            lanes: Array,
      },
      data() {
            return {
                  form: this.$inertia.form({

                        title: this.card.title,
                        content: this.card.content,
                        lane_id: this.card.lane_id,
                  })
            }
      },
}
</script>