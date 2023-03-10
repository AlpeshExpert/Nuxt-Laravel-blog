<template>
  <!-- Create By Joker Banny -->
<div class="min-h-screen bg-gradient-to-tr from-red-300 to-yellow-200 flex justify-center items-center py-20">
  <div class="md:px-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-5 space-y-4 md:space-y-0">
    <div v-for="post in posts" :key="post.id" class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
      <h3 class="mb-3 text-xl font-bold text-indigo-600">{{ post.title }}</h3>
      <div class="relative">
        <img class="w-full rounded-xl" :src="`${ post.image_link }`" alt="Colors" />
      </div>
      <h1 class="mt-4 text-gray-800 text-2xl font-bold cursor-pointer">{{ post.content }}</h1>
      <div class="my-4">
        <div v-if="$auth.loggedIn && post.is_editable" class="flex space-x-1 items-center">
          <NuxtLink :to="`/post/edit/${post.id}`" class="flex space-x-1 items-center">
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </span>
          <p>Edit Post</p>
          </NuxtLink>
        </div>
        <NuxtLink :to="`/post/${post.id}`"><button class="mt-4 text-xl w-full text-white bg-indigo-600 py-2 rounded-xl shadow-lg">View Post</button></NuxtLink>
      </div>
    </div>
  </div>
  <div v-if="!posts.length"><h1 class="mt-4 text-center text-gray-800 text-2xl font-bold cursor-pointer center">There is not any post created by you</h1></div>
</div>
</template>
<script>
export default {
    data() {
        return {
            posts:[],

        }
    },
    mounted() {
        this.$axios.$get("/sanctum/csrf-cookie");
    },
    async fetch(){
        const response = await this.$axios.get("/api/posts?type=my-post");
        if(response.data.success==true){
            this.posts = await response.data.data;
        }else{
            this.posts = [];
        }
        
    }
}
</script>