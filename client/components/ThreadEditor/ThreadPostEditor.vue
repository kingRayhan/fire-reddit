<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <Input
        name="title"
        label="Title"
        v-model="form.title"
        placeholder="Title"
      />
      <Textarea name="body" v-model="form.body" placeholder="Body" />

      <Dropzone
        id="foo"
        :destroyDropzone="true"
        :options="{
          url: 'https://api.cloudinary.com/v1_1/techdiary-dev/image/upload',
          paramName: 'file',
          params: { upload_preset: 'fire-reddit-assets' },
          dictDefaultMessage: `<i class='fa fa-cloud-upload'></i> UPLOAD ME`,
        }"
        @vdropzone-success="handleThumbnail"
      />

      <div class="mt-4">
        <Button>Submit</Button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  beforeMount() {
    this.$store.commit('errors/CLEAR')
  },
  data() {
    return { form: { title: '', body: '', thumbnail: null } }
  },
  methods: {
    async handleSubmit() {
      try {
        await this.$store.dispatch('threads/store', this.form)
      } catch {}
    },
    handleThumbnail(_, { secure_url }) {
      this.form.thumbnail = secure_url
    },
  },
}
</script>
