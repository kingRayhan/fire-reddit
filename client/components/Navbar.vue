<template>
  <section class="navbar bg-primary mb-5">
    <nav class="navbar__inner container mx-auto flex items-end justify-between">
      <nuxt-link class="navbar__logo" to="/"></nuxt-link>

      <div class="navbar__user-menu bg-primaryLight" v-if="$auth.loggedIn">
        Howdy
        <nuxt-link
          :to="{ name: 'u-name', params: { name: $auth.user.username } }"
          class="font-bold"
        >
          /r/{{ $auth.user.username }}
        </nuxt-link>
        <nuxt-link
          class="text-xs text-gray-700"
          :to="{ name: 'auth-settings' }"
        >
          (settings)
        </nuxt-link>
        <span class="font-thin">|</span>
        <nuxt-link to="/notifications">
          Notifications ({{ ureadsCount }})
        </nuxt-link>
        <span class="font-thin">|</span>
        <a @click.prevent="$auth.logout()" class="cursor-pointer">Logout</a>
      </div>

      <div class="navbar__user-menu bg-primaryLight" v-if="!$auth.loggedIn">
        Want to join?
        <button class="link" @click="showLoginModal = true">Login</button>
        or
        <button class="link" @click="showRegisterModal = true">Signup</button>
        in a seconds.
      </div>
    </nav>
    <Modal v-model="showRegisterModal">
      <Register />
    </Modal>
    <Modal v-model="showLoginModal">
      <Login :card="false" />
    </Modal>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      showRegisterModal: false,
      showLoginModal: false,
    };
  },
  computed: mapGetters("notification", ["ureadsCount"]),
};
</script>
