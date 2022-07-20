<template>
  <v-app>
    <header>
      <v-app-bar color="indigo lighten-1" dark>
        <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
        <Link class="mr-5" href="/">
          <v-toolbar-title>{{$page.props.appName}}</v-toolbar-title>
        </Link>

        <!-- <Link class="mr-5" href="/boards">
          <v-toolbar-title>Boards</v-toolbar-title>
        </Link>

        <Link class="mr-5" href="/lanes">
          <v-toolbar-title>Lanes</v-toolbar-title>
        </Link>

        <Link class="mr-5" href="/cards">
          <v-toolbar-title>Cards</v-toolbar-title>
        </Link> -->

        <v-spacer></v-spacer>

        <v-menu
          rounded="b-xl"
          offset-y
        >
          <template v-slot:activator="{ attrs, on }">
            <v-btn
              color="primary"
              class="white--text ma-5"
              v-bind="attrs"
              v-on="on"
            >
              {{$page.props.user_name}}
            </v-btn>
          </template>

          <v-list>
            <v-list-item
              link
              v-on:click="logout"
            >
              <v-list-item-title
                v-text="'Sair'"
              ></v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>
    </header>

    <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <main class="page-content pt-5">
      <slot />
    </main>

    <footer>
      <v-footer
        dark
        padless
      >
        <v-card
          flat
          tile
          class="indigo lighten-1 white--text text-center"
        >
          <v-card-text>
            <v-btn
              v-for="icon in icons"
              :key="icon"
              class="mx-4 white--text"
              icon
            >
              <v-icon size="24px">
                {{ icon }}
              </v-icon>
            </v-btn>
          </v-card-text>

          <v-card-text class="white--text pt-0">
            Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum. Praesent ut risus eget metus luctus accumsan id ultrices nunc. Sed at orci sed massa consectetur dignissim a sit amet dui. Duis commodo vitae velit et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat augue vel ipsum ultrices, cursus iaculis dui sollicitudin. Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
          </v-card-text>

          <v-divider style="background: black"></v-divider>

          <v-card-text class="white--text">
            {{ new Date().getFullYear() }} — <strong>{{$page.props.appName}}</strong>
          </v-card-text>
        </v-card>
      </v-footer>
    </footer>
  </v-app>
</template>
<script>
export default {
  name: "Layout",
  props: {
    // appName: {
    //   type: String,
    //   required: true,
    // },
  },
  data () {
    return {
      drawer: false,
      group: null,
      icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
    }
  },
  methods: {
    logout() {

//  -----------  TODO: to add a loading component for this timeOut  --------------------------------------
      this.$inertia.post('/logout', {})
      setTimeout(function(){window.location='/login'}, 300)
    }
  }
};
</script>