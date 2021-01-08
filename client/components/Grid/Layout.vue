<template>
  <div>
    <section class="container">
      <main>
        <slot />
      </main>
      <aside>
        <Sidebar />
      </aside>
    </section>
    <Footer />
  </div>
</template>

<style scoped lang="scss">
section {
  @apply grid grid-cols-12 mx-auto;
}
main {
  @apply col-span-9 pr-5;
}
aside {
  @apply col-span-3;
}
</style>
