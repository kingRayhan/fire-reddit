<template>
  <form @submit.prevent="handleRegister">
    <h3 class="text-primaryDark font-bold mb-4">CREATE A NEW ACCOUNT</h3>
    <Input
      v-model="form.username"
      name="username"
      label="User Name"
      placeholder="Your username"
    />
    <Input
      v-model="form.email"
      name="email"
      type="email"
      label="Email address"
      placeholder="Your email address"
    />
    <Input
      v-model="form.password"
      name="password"
      type="password"
      label="Password"
      placeholder="Password"
    />
    <Input
      v-model="form.password_confirmation"
      name="password_confirmation"
      type="password"
      label="Confirm password"
      placeholder="Confirm password"
    />
    <Button>Register</Button>
  </form>
</template>
<script>
export default {
  data() {
    return {
      form: {
        username: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  head: {
    title: "Create new account",
  },
  methods: {
    async handleRegister() {
      try {
        await this.$store.dispatch("user/register", this.form);

        this.form = {
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
        };
      } catch (error) {}
    },
  },
};
</script>
