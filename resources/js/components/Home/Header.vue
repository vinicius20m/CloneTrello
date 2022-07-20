
<template>
      <v-card class="header mx-auto"
            :elevation="11"
      >
            <slot />
      </v-card>
</template>
<script>
export default {
      name: "Header",
}
</script>

<style scoped>
.header {
      /* margin: 0 30px; */
      /* background: var(--color-secondary-light) ; */
      background: #5f7d8f59;
      height: 4rem ;
      width: 65rem;
      border-radius: 7px;
}
</style>