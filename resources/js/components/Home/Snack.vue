<template>
    <v-snackbar class="snack"
      v-model="activator" max-height="auto"
      content-class="text-center" outlined rounded="lg"
      :timeout="1300" color="success accent-1"
      min-width="300" min-height="30" height="39"
      elevation="24" text transition="scroll-y-transition"
    >
      <slot/>

      <!-- <template v-slot:action="{ attrs }">
        <v-btn
          icon
          v-bind="attrs"
          @click="activator = false"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template> -->
    </v-snackbar>
</template>
<script>
export default {

    name: "Snack",

    props: {
        trigger: Boolean,
        callback: Function
    },

    data() {
        return {
            activator: false,
        }
    },

    watch: {
        trigger: function() {
            if(this.trigger)
            this.activator = this.trigger
        },

        activator: function() {
            this.callback(this.activator)
        }
    }
}
</script>
<style scoped>
</style>