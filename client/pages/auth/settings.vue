<template>
  <div>
    <h2 class="text-primaryDark text-3xl uppercase">Settings</h2>
    <form @submit.prevent="handleUpdateProfile">
      <Input
        name="username"
        placeholder="Username"
        label="Username"
        v-model="profile.username"
      />
      <Input
        name="email"
        placeholder="Email"
        label="Email"
        v-model="profile.email"
      />
      <Button>Update Profile</Button>
    </form>

    <form class="mt-5" @submit.prevent="handleUpdatePassword">
      <Input
        name="current_password"
        placeholder="Current password"
        label="Current password"
        type="password"
        v-model="credential.current_password"
      />
      <Input
        name="password"
        placeholder="Password"
        label="New password"
        type="password"
        v-model="credential.password"
      />
      <Input
        name="password_confirmation"
        placeholder="Confirm new password"
        label="Confirm password"
        type="password"
        v-model="credential.password_confirmation"
      />
      <Button>Update password</Button>
    </form>

    <form @submit.prevent="handleDestroyProfile" class="mt-8">
      <div class="border-red-500 border-dashed border-2 p-5">
        <div class="mb-3">
          <h3 class="text-red-500 text-2xl font-bold uppercase">Danger zone</h3>
          <p class="text-gray-600 text-xl">
            Be careful. Once you delete your profile, it can not be undone. All
            post/link/comment your created will deleted autometically.
          </p>
        </div>

        <Input
          name="password"
          placeholder="Current password"
          label="Confirm password"
          type="password"
          v-model="deleteProfilePassword"
        />

        <button class="bg-red-500 text-white px-2 py-1 rounded">
          Delete profile
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "Setting",
  middleware: "authenticated",
  data() {
    return {
      profile: {
        ...this.$auth.user,
      },
      credential: {
        current_password: "",
        password: "",
        password_confirmation: "",
      },
      deleteProfilePassword: "",
    };
  },
  methods: {
    async handleUpdateProfile() {
      try {
        await this.$store.dispatch("user/updateProfile", this.profile);
        await this.$auth.fetchUser();
        this.$store.dispatch("errors/showMsg", "Profile updated");
      } catch {}
    },

    async handleUpdatePassword() {
      try {
        await this.$store.dispatch("user/updatePassword", this.credential);
        await this.$auth.fetchUser();
        this.$store.dispatch("errors/showMsg", "Password updated");

        this.credential = {
          current_password: "",
          password: "",
          password_confirmation: "",
        };
      } catch {}
    },

    async handleDestroyProfile() {
      try {
        await this.$store.dispatch("user/destroyProfile", {
          password: this.deleteProfilePassword,
        });
      } catch {}
    },
  },
};
</script>
