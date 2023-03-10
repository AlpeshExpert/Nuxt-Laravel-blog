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
						<h3 class="pt-4 text-2xl text-center">Create an Account!</h3>
						<form class="px-8 pt-6 pb-8 mb-4 bg-white rounded"  ref="loginForm" @submit.prevent="login">
                            <div class="mb-4">
								<label class="block mb-2 text-sm font-bold text-gray-700" for="email">
									Email
								</label>
								<input
									class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
									id="email"
									name="email"
									type="email"
									placeholder="Email"
									required
								/>
							</div>
							<div class="mb-4">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="password">
										Password
									</label>
									<input
										class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
										id="password"
										name="password"
										type="password"
										placeholder="***********"
										required
									/>
							</div>
							<div class="mb-6 text-center">
								<button
									class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
									type="submit"
								>
									Login
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
  auth: "guest",
  data() {
    return {
      form: {
        email: null,
        password: null,
      },
    };
  },
  mounted() {
    this.$axios.$get("/sanctum/csrf-cookie");
  },
  methods: {
    async login() {
      this.$nuxt.$loading.start();
      try {
        const formData = new FormData(this.$refs.loginForm)
        await this.$auth.loginWith("laravelSanctum", { data: formData });
        
		this.$toast.success('Successfully logged-in',{
			onComplete : function(){
				this.$router.push({
					path: "/",
				});
			}
		}).goAway(2000);

      } catch (err) {
		this.$toast.error('Failed to log-in').goAway(2000);
        console.log(err);
      }
      this.$nuxt.$loading.finish();
    },
  },
};
</script>
