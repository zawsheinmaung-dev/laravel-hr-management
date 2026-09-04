<template>
  <div class="min-h-screen bg-slate-100 flex items-center justify-center p-6">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

      <!-- Left Side -->
      <div
        class="hidden md:flex flex-col justify-center bg-gradient-to-br from-indigo-600 to-blue-700 text-white p-12"
      >
        <h1 class="text-4xl font-bold mb-4">
          Join HRM System
        </h1>

        <p class="text-blue-100 leading-7">
          Create an employee account to access attendance, payroll,
          leave management, and other HR services.
        </p>

        <div class="mt-12 flex justify-center">
          <svg class="w-72 h-72 text-white/70" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z"/>
          </svg>
        </div>
      </div>

      <!-- Right Side -->
      <div class="p-8 md:p-12">

        <div class="mb-8">
          <h2 class="text-3xl font-bold text-gray-800">
            Create Account
          </h2>

          <p class="text-gray-500 mt-2">
            Register a new employee account.
          </p>
        </div>

        <form class="space-y-5">

          <div>
            <label class="block text-sm font-medium mb-2">
              Full Name
            </label>

            <input
              type="text"
              placeholder="John Doe"
              class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
            />
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-2">
                Email
              </label>

              <input
                type="email"
                placeholder="john@example.com"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Phone
              </label>

              <input
                type="text"
                placeholder="+95 9xxxxxxxx"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              />
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-2">
                Department
              </label>

              <select
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              >
                <option>IT</option>
                <option>HR</option>
                <option>Finance</option>
                <option>Marketing</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Role
              </label>

              <select
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              >
                <option>Employee</option>
                <option>Manager</option>
                <option>Admin</option>
              </select>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-2">
                Password
              </label>

              <input
                type="password"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Confirm Password
              </label>

              <input
                type="password"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
              />
            </div>
          </div>

          <button
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition"
          >
            Create Account
          </button>

        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
          Already have an account?
          <a href="#" class="text-blue-600 font-semibold hover:underline">
            Login
          </a>
        </p>

      </div>

    </div>
  </div>
</template>