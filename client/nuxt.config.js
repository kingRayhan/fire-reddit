export default {
  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: "Fire Reddit",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" },
    ],
    link: [
      {
        rel: "stylesheet",
        href:
          "https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,400&display=swap",
      },
      { rel: "icon", type: "image/x-icon", href: "/images/favicon-96x96.png" },
    ],
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: ["~/assets/styles/app.scss"],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    { src: "~/plugins/infiniteloading", ssr: false },
    "~/plugins/tabs",
    "~/plugins/dropzone",
    "~/plugins/axios",
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
    "@nuxtjs/tailwindcss",
    "@nuxtjs/laravel-echo",
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    // https://go.nuxtjs.dev/axios
    "@nuxtjs/axios",
    "@nuxtjs/auth",
    ["nuxt-tailvue", { all: true }],
  ],

  loading: {
    color: "#336699",
    height: "5px",
  },

  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    baseURL: process.env.NUXT_ENV_APP_API,
  },

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: "/auth/login",
            method: "post",
            propertyName: "token",
          },
          logout: { url: "/auth/logout", method: "post" },
          user: { url: "/auth/me", method: "get", propertyName: "data" },
        },
      },
    },
    redirect: {
      logout: "/auth/login",
    },
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {},

  echo: {
    broadcaster: "pusher",
    key: "a697086a1aadd4dbc528",
    cluster: "mt1",
    plugins: ["~/plugins/echo.js"],
    // auth
    authModule: true,
    connectOnLogin: true,
    disconnectOnLogout: false,
  },

  generate: {
    fallback: true,
  },
};
