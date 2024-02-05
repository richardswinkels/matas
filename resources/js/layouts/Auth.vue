<template>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center">
        <main>
            <div class="py-12">
                <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

