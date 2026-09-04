<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
    name:'Login'
})
const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
})

function submit(){
  form.post(route('login_check'),{
    onSuccess:(success)=>{
      console.log('success',success);
      
    },
    onError:(err)=>{
        console.log(err);
        
    }
  })
}

</script>

<template>
    <div class="min-h-screen bg-slate-100 flex">

        <!-- Left Branding -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-[#0f172a] relative overflow-hidden"
        >
            <!-- Background circles -->
            <div
                class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blue-600/20"
            ></div>

            <div
                class="absolute -bottom-40 -right-20 w-[500px] h-[500px] rounded-full bg-blue-500/10"
            ></div>

            <div
                class="relative z-10 flex flex-col justify-center px-16 xl:px-24 text-white"
            >
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg"
                    >
                        <span class="text-2xl">👥</span>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold">
                            HRM System
                        </h1>

                        <p class="text-sm text-blue-300">
                            Human Resource Management
                        </p>
                    </div>
                </div>

                <h2 class="text-4xl xl:text-5xl font-bold leading-tight">
                    Manage your
                    <span class="text-blue-500">
                        workforce
                    </span>
                    smarter.
                </h2>

                <p class="mt-6 text-slate-400 text-lg leading-8 max-w-lg">
                    Manage employees, attendance, leave, payroll,
                    recruitment and performance from one powerful platform.
                </p>

                <!-- Features -->
                <div class="mt-10 space-y-4">

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center"
                        >
                            ✓
                        </div>

                        <span class="text-slate-300">
                            Employee Management
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center"
                        >
                            ✓
                        </div>

                        <span class="text-slate-300">
                            Attendance & Leave
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center"
                        >
                            ✓
                        </div>

                        <span class="text-slate-300">
                            Payroll & Performance
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right Login -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12"
        >
            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="inline-flex w-14 h-14 rounded-xl bg-blue-600 items-center justify-center"
                    >
                        <span class="text-2xl">👥</span>
                    </div>

                    <h1 class="text-2xl font-bold text-[#0f172a] mt-3">
                        HRM System
                    </h1>

                    <p class="text-sm text-gray-500">
                        Human Resource Management
                    </p>
                </div>

                <!-- Login Card -->
                <div
                    class="bg-white rounded-2xl border border-gray-200 shadow-xl p-8 md:p-10"
                >

                    <div class="mb-8">
                        <h2
                            class="text-3xl font-bold text-[#0f172a]"
                        >
                            Welcome back 👋
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Sign in to access your HRM dashboard.
                        </p>
                    </div>

                    <form
                        @submit.prevent="submit"
                        class="space-y-5"
                    >

                        <!-- Email -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Email Address
                            </label>

                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-18 0v1.5a2.5 2.5 0 005 0V12"
                                        />
                                    </svg>
                                </div>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-300
                                           bg-white text-gray-800
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                           outline-none transition"
                                    :class="{
                                        'border-red-500':
                                            form.errors.email
                                    }"
                                />
                            </div>

                            <p
                                v-if="form.errors.email"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <label
                                    class="block text-sm font-semibold text-gray-700"
                                >
                                    Password
                                </label>

                                <a
                                    href="#"
                                    class="text-sm text-blue-600 hover:text-blue-700"
                                >
                                    Forgot password?
                                </a>
                            </div>

                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                </div>

                                <input
                                    v-model="form.password"
                                    :type="
                                        showPassword
                                            ? 'text'
                                            : 'password'
                                    "
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-300
                                           bg-white text-gray-800
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                           outline-none transition"
                                    :class="{
                                        'border-red-500':
                                            form.errors.password
                                    }"
                                />

                                <button
                                    type="button"
                                    @click="
                                        showPassword = !showPassword
                                    "
                                    class="absolute right-0 top-0 h-full px-4 text-gray-400 hover:text-gray-600"
                                >
                                    <svg
                                        v-if="!showPassword"
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>

                                    <svg
                                        v-else
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.341-3.914M6.228 6.228A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.132 5.411M6.228 6.228L3 3m3.228 3.228l11.544 11.544"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <p
                                v-if="form.errors.password"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center">
                            <label
                                class="flex items-center gap-2 cursor-pointer"
                            >
                                <input
                                    v-model="form.remember"
                                    type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                />

                                <span class="text-sm text-gray-600">
                                    Remember me
                                </span>
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold shadow-lg shadow-blue-600/20
                                   transition duration-200
                                   disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            <span v-if="!form.processing">
                                Sign In
                            </span>

                            <span
                                v-else
                                class="flex items-center justify-center gap-2"
                            >
                                <svg
                                    class="animate-spin w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    />
                                </svg>

                                Signing in...
                            </span>
                        </button>
                    </form>

                    <!-- Register -->
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500">
                            Don't have an account?

                            <a
                                
                                class="font-semibold text-blue-600 hover:text-blue-700"
                            >
                                Create account
                            </a>
                        </p>
                    </div>

                </div>

                <p class="text-center text-xs text-gray-400 mt-6">
                    © 2026 HRM System. All rights reserved.
                </p>

            </div>
        </div>
    </div>
</template>