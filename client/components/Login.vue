<template>
  <div>
    <div v-if="card">
      <Card title="Login">
        <p
          v-if="isInvalidCredentials"
          class="font-bold text-red-500 my-1 text-center"
        >
          Invalid Creadentials
        </p>

        <form @submit.prevent="login">
          <Input
            name="email"
            v-model="form.email"
            placeholder="Email"
            label="Email"
          />
          <Input
            name="password"
            type="password"
            v-model="form.password"
            label="Password"
            placeholder="Password"
          />
          <Button>Login</Button>
        </form>
      </Card>
    </div>
    <div v-else>
      <p
        v-if="isInvalidCredentials"
        class="font-bold text-red-600 my-1 text-center"
      >
        Invalid Creadentials
      </p>

      <form @submit.prevent="login">
        <Input
          name="email"
          v-model="form.email"
          placeholder="Email"
          label="Email"
        />
        <Input
          name="password"
          type="password"
          v-model="form.password"
          label="Password"
          placeholder="Password"
        />
        <Button>Login</Button>
      </form>
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  name: "Login",
  props: {
    card: {
      default: true,
    },
  },
  data() {
    return {
      form: { email: "", password: "" },
      isInvalidCredentials: false,
    };
  },
  computed: { ...mapState(["errors"]) },
  methods: {
    ...mapActions(["catchErrors"]),
    async login() {
      try {
        this.isInvalidCredentials = false;
        await this.$auth.loginWith("local", { data: this.form });
      } catch (error) {
        this.isInvalidCredentials = true;
      }
    },
  },
};
</script>
