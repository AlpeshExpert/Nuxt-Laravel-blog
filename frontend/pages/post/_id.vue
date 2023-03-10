<template>
    <div class="min-h-screen bg-gradient-to-tr from-red-300 to-yellow-200 flex justify-center items-center py-20">
                  <div class=" px-10 py-6 mx-auto">
                        <!--author-->
                     <div class="max-w-6xl px-10 py-6 mx-auto bg-gray-50">
                        
		                <a href="#_" class="block transition duration-200 ease-out transform hover:scale-110">
	                        <img class="object-cover w-full shadow-sm h-full" :src="`${post.image_link}`">
	                    </a>

                        <div class="mt-2">
                        	<!--post heading-->
                        	<a href="#"
                                class="sm:text-3xl md:text-3xl lg:text-3xl xl:text-4xl font-bold text-purple-500  hover:underline">{{ post.title }}</a>

                                <!--post views-->
                                <!--author avator-->
                               <div class="font-light text-gray-600">
	                              
	                        		<a href="#" class="flex items-center mt-6 mb-6">
	                                    <h1 class="font-bold text-gray-700 hover:underline">{{ post.user.name }}</h1>
	                                </a>
                        	  </div>
                       </div>
                    
                       <!--end post header-->
                        	<!--post content-->
                 <div class="max-w-4xl px-10  mx-auto text-2xl text-gray-700 mt-4 rounded bg-gray-100">

                 	<!--content body-->
                 	<div>
                        	<p class="mt-2 p-8">{{ post.content }}</p>
                     </div>

                     

				        </div>
				    </div>

				    <!--form form comments-->
                     
			 <div  class="max-w-4xl py-16 xl:px-8 flex justify-center mx-auto">
						        
				<div v-if="$auth.loggedIn" class="w-full mt-16 md:mt-0 ">
				   <form ref="commentForm" @submit.prevent="addComment" class="relative z-10 h-auto p-8 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
					   <h3 class="mb-6 text-2xl font-medium text-center">Write a comment</h3>
					   <textarea required type="text" name="comment" class="w-full px-4 py-3 mb-4 border border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" placeholder="Write your comment" rows="5" cols="33"></textarea>
					   <input type="submit" value="Submit comment" name="submit" class=" text-white px-4 py-3 bg-blue-500  rounded-lg">
				   </form>
			   </div>
		    </div>


				<!--comments-->
				
		<div class="max-w-4xl px-10 py-16 mx-auto bg-gray-100  bg-white min-w-screen animation-fade animation-delay  px-0 px-8 mx-auto sm:px-12 xl:px-5">
		        
		        <p class="mt-1 text-2xl font-bold text-left text-gray-800 sm:mx-6 sm:text-2xl md:text-3xl lg:text-4xl sm:text-center sm:mx-0">
		            All comments on this post
		        </p>
		        <!--comment 1-->
		        <div v-for="comment in post.comments" :key="post.id"  class="flex  items-center w-full px-6 py-6 mx-auto mt-10 bg-white border border-gray-200 rounded-lg sm:px-8 md:px-12 sm:py-8 sm:shadow lg:w-5/6 xl:w-2/3">
		            <div><h3 class="text-lg font-bold text-purple-500 sm:text-xl md:text-2xl">By {{ comment.user.name }}</h3>
		            	<p class="text-sm font-bold text-gray-300">{{ comment.created_at }}</p>
		            	<p class="mt-2 text-base text-gray-600 sm:text-lg md:text-normal">
		               {{ comment.comment }}
					   </p>
		            </div>
		        </div>
		    </div>
		  </div>
	  </div>
</template>
<script>
export default {
    auth:false,
    data() {
        return {
            post:{},
            form:{
                post_id:this.$route.params.id,
                comment:null
            }
        }
    },
    mounted() {
        this.$axios.$get("/sanctum/csrf-cookie");
    },
    async fetch(){
        const response = await this.$axios.get(`/api/post/show/${this.$route.params.id}`);
        if(response.data.success==true){
            this.post = await response.data.data;
            console.log(this.post);
        }else{
            this.post = {};
        }
    },
	methods:{
		addComment(){
			try {
				const formData = new FormData(this.$refs.commentForm);
				formData.append('post_id',this.$route.params.id);
				this.$axios.post("/api/comment/store", formData).then((res) => {
					if(res.data.success===true){
						this.post.comments.unshift(res.data.data);
						this.$refs.commentForm.reset();
					}
					this.$toast.success('Comment Successfully Added').goAway(2000);
				});
			} catch (err) {
				console.log(err);
			}
		}
  	}
}
</script>