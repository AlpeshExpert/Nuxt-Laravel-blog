<template>
    <div class="font-mono bg-gray-400 py-5">
		<!-- Container -->
		<div class="container mx-auto">
			<div class="flex justify-center px-6 my-12">
				<!-- Row -->
				<div class="w-full xl:w-3/4 lg:w-11/12 flex">
					<!-- Col -->
					<div
						class="w-full h-auto bg-gray-400 hidden lg:block lg:w-5/12 bg-cover rounded-l-lg"
						style="background-image: url('https://source.unsplash.com/Mv9hjnEUHR4/600x800')"
					></div>
					<!-- Col -->
					<div class="w-full lg:w-7/12 bg-white p-5 rounded-lg lg:rounded-l-none">
						<h3 class="pt-4 text-2xl text-center">Create a Post!</h3>
						<form class="px-8 pt-6 pb-8 mb-4 bg-white rounded"  ref="addpostform" @submit.prevent="addPost" enctype="multipart/form-data">
							<div class="mb-4">
								<label class="block mb-2 text-sm font-bold text-gray-700" for="email">
									Title
								</label>
								<input
									class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
									id="title"
									name="title"
									type="text"
									placeholder="Post Title"
									required
								/>
							</div>
                            <div class="mb-4">
								<label class="block mb-2 text-sm font-bold text-gray-700" for="email">
									Content
								</label>
								<textarea
									class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
									id="content"
									name="content"
									type="content"
									placeholder="Please enter post content"
									required
								></textarea>
							</div>
							<div class="mb-4 md:flex md:justify-between">
								<label class="block mb-2 text-sm font-bold text-gray-700" for="email">
									Feature Image
								</label>
								<input
									class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
									id="featured_image"
									name="featured_image"
									type="file"
									required
									 accept="image/x-png,image/gif,image/jpeg"
								/>
							</div>
							<div class="mb-6 text-center">
								<button
									class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
									type="submit"
								>
									Create Post
								</button>
							</div>
							<hr class="mb-6 border-t" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
  middleware: "auth",
    data() {
    return {
      form: {
        title: null,
        content: null,
        featured_image: null,
      },
      errors: []
    }
  },
  mounted() {
    this.$axios.$get("/sanctum/csrf-cookie");
  },
  methods: {
    addPost() {
      try {
			const formData = new FormData(this.$refs.addpostform);
			this.$axios.post("/api/post/store", formData).then((res) => {
				this.$toast.success('Successfully Post Added').goAway(2000);
			});
			this.$router.push({
				path: "/",
			});
      } catch (err) {
        console.log(err);
		this.$toast.error('Failed to add post').goAway(2000);
      }
    },
  },
};
</script>
