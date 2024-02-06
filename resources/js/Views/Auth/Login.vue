<template>
    <div>
        <form @submit.prevent="login">
            <div>
                <label for="email" class="block text-sm font-semibold mb-1">
                    E-mail:
                </label>
                <input v-model="loginData.email" id="email" type="text"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in this.validationErrors?.email">
                        {{ message }}
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label for="password" class="block text-sm font-semibold mb-1">
                    Password:
                </label>
                <input v-model="loginData.password" id="password" type="password"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in this.validationErrors?.password">
                        {{ message }}
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-between">
                <button type="submit"
                        class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                    <span v-show="isLoading"
                          class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                    <span v-if="isLoading">Logging in...</span>
                    <span v-else>Login</span>
                </button>

                <router-link :to="{ name: 'register' }" class="underline self-end">Register</router-link>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loginData: {
                email: '',
                password: ''
            },
            validationErrors: [],
            isLoading: false,
        }
    },
    methods: {
        async login() {
            if (this.isLoading) return;

            this.isLoading = true
            this.validationErrors = {}

            axios.post('/api/login', this.loginData)
                .then(response => {
                    const {is_admin} = response.data;

                    localStorage.setItem('loggedIn', JSON.stringify(true))
                    localStorage.setItem('isAdmin', is_admin);

                    this.$router.push({name: 'components.index'})
                })
                .catch(error => {
                    if (error.response?.data) {
                        this.validationErrors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
        }
    }
}
</script>
