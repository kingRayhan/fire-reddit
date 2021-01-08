<template>
  <main class="thread-submitter-page">
    <h2 class="text-2xl mb-4">Submit post/link</h2>
    <tabs :options="{ useUrlFragment: false }">
      <tab name="Link">
        <ThreadLinkEditor />
      </tab>
      <tab name="Post">
        <ThreadPostEditor />
      </tab>
    </tabs>
    <div class="mt-4">
      <div>
        please be mindful of reddit's
        <a href="https://old.reddit.com/help/contentpolicy" target="_blank"
          >content policy</a
        >
        and practice
        <a href="https://old.reddit.com/wiki/reddiquette" target="_blank"
          >good reddiquette</a
        >.
      </div>
      <div class="link-notice" style="display: none">
        posting this link saves the image or gif to reddit.
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "SubmitThread",
  middleware: "authenticated",
};
</script>

<style>
.thread-submitter-page .input-component {
  background-color: #cee3f8;
  padding: 15px;
  border-radius: 5px;
}
</style>
