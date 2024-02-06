<template>
    <div>
        <form @submit.prevent="register">
            <div>
                <label for="name" class="block text-sm font-semibold mb-1">
                    Name:
                </label>
                <input v-model="registerData.name" id="name" type="text"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in this.validationErrors?.name">
                        {{ message }}
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label for="email" class="block text-sm font-semibold mb-1">
                    E-mail:
                </label>
                <input v-model="registerData.email" id="email" type="text"
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
                <input v-model="registerData.password" id="password" type="password"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in this.validationErrors?.password">
                        {{ message }}
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-semibold mb-1">
                    Password confirmation:
                </label>
                <input v-model="registerData.password_confirmation" id="password_confirmation" type="password"
                       class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
                <div class="text-red-600 text-sm mt-1">
                    <div v-for="message in this.validationErrors?.password_confirmation">
                        {{ message }}
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-between">
                <button type="submit"
                        class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                    <span v-show="isLoading"
                          class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                    <span v-if="isLoading">Registering...</span>
                    <span v-else>Register</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            registerData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            validationErrors: [],
            isLoading: false,
        }
    },
    methods: {
        async register() {
            if (this.isLoading) return;

            this.isLoading = true
            this.validationErrors = {}

            axios.post('/api/register', this.registerData)
                .then(response => {
                    this.$router.push({name: 'login'})
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
