<template>
      <Layout :appName="appName">
            <Head :title="appName+ '- Criando um Quadro'" />

            <h1 class="my-3 ms-5 ps-5">Criando um Quadro</h1>
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

                              <input v-model="form.title" required class="m-4 form-control" placeholder="Título" name="title" type="text">

                              <textarea v-model="form.description" class="m-4 form-control" placeholder="Descrição" name="description" >
                              </textarea>
                              <div class="text-end">
                                    <button class="btn btn-success" type="submit">Criar</button>
                              </div>
                        </div>
                  </div>
            </form>
      </Layout>
</template>
<script>
export default {

      name: 'creatingBoardPage',
      props: {

            appName: String,
            formRoute: String,
            errors: Object,
      },
      data() {
            return {
                  form: this.$inertia.form({

                        title: null,
                        description: null,
                  })
            }
      },
}
</script>