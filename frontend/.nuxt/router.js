import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from 'ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _a5f9492c = () => interopDefault(import('../pages/login.vue' /* webpackChunkName: "pages/login" */))
const _e828ba58 = () => interopDefault(import('../pages/posts.vue' /* webpackChunkName: "pages/posts" */))
const _77fc0d32 = () => interopDefault(import('../pages/register.vue' /* webpackChunkName: "pages/register" */))
const _f6ed447e = () => interopDefault(import('../pages/post/add.vue' /* webpackChunkName: "pages/post/add" */))
const _053af245 = () => interopDefault(import('../pages/post/edit/_id.vue' /* webpackChunkName: "pages/post/edit/_id" */))
const _2345225a = () => interopDefault(import('../pages/post/_id.vue' /* webpackChunkName: "pages/post/_id" */))
const _39488f5a = () => interopDefault(import('../pages/index.vue' /* webpackChunkName: "pages/index" */))

const emptyFn = () => {}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/login",
    component: _a5f9492c,
    name: "login"
  }, {
    path: "/posts",
    component: _e828ba58,
    name: "posts"
  }, {
    path: "/register",
    component: _77fc0d32,
    name: "register"
  }, {
    path: "/post/add",
    component: _f6ed447e,
    name: "post-add"
  }, {
    path: "/post/edit/:id?",
    component: _053af245,
    name: "post-edit-id"
  }, {
    path: "/post/:id?",
    component: _2345225a,
    name: "post-id"
  }, {
    path: "/",
    component: _39488f5a,
    name: "index"
  }],

  fallback: false
}

export function createRouter (ssrContext, config) {
  const base = (config._app && config._app.basePath) || routerOptions.base
  const router = new Router({ ...routerOptions, base  })

  // TODO: remove in Nuxt 3
  const originalPush = router.push
  router.push = function push (location, onComplete = emptyFn, onAbort) {
    return originalPush.call(this, location, onComplete, onAbort)
  }

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    return resolve(to, current, append)
  }

  return router
}
