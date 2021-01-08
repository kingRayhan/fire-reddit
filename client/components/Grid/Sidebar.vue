<template>
  <div>
    <EmailVarificationStatus />

    <div v-if="$auth.loggedIn">
      <nuxt-link class="submitter-button mb-4" to="/new">
        <span>Submit now</span>
        <div class="nub"></div>
      </nuxt-link>
    </div>

    <img
      src="~/static/images/toto-logo-1599689481-30467661479.png"
      alt="reddit"
      class="my-4"
    />

    <div v-if="!$auth.loggedIn">
      <Register v-if="mode == 'register'" />
      <Login v-if="mode == 'login'" />

      <div class="mt-2" v-if="mode == 'login'">
        Don't have an account?
        <a href="#" @click.prevent="mode = 'register'">Register now</a>
      </div>
      <div class="mt-2" v-if="mode == 'register'">
        Already have an account?
        <a href="#" @click.prevent="mode = 'login'">Login now</a>
      </div>
    </div>

    <Rules />
  </div>
</template>

<script>
export default {
  data() {
    return {
      mode: "login",
    };
  },
};
</script>
