<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-black/50 p-8 rounded-xl border border-white/10">
      <div>
        <div class="flex justify-center">
          <span class="text-3xl text-primary font-bold">🔐 ادیکدز</span>
        </div>
        <h2 class="mt-4 text-center text-xl font-extrabold text-white font-vazir">ورود به پنل مدیریت</h2>
      </div>
      
      <!-- Alert for errors -->
      <div v-if="error" class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg text-sm font-vazir">
        {{ error }}
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="username" class="sr-only">نام کاربری</label>
            <input v-model="username" id="username" name="username" type="text" required
              class="appearance-none rounded-none relative block w-full px-3 py-3 bg-black/50 border border-white/10 placeholder-white/40 text-white focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm font-vazir rounded-t-lg"
              placeholder="نام کاربری" dir="ltr"
            />
          </div>
          <div>
            <label for="password" class="sr-only">رمز عبور</label>
            <input v-model="password" id="password" name="password" type="password" required
              class="appearance-none rounded-none relative block w-full px-3 py-3 bg-black/50 border border-white/10 placeholder-white/40 text-white focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm font-vazir rounded-b-lg"
              placeholder="رمز عبور" dir="ltr"
            />
          </div>
        </div>

        <div>
          <button type="submit" :disabled="loading"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-vazir font-bold rounded-lg text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 disabled:opacity-75"
          >
            <span v-if="loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
              <font-awesome-icon icon="circle-notch" class="animate-spin h-5 w-5 text-white/70" />
            </span>
            <span v-else class="absolute left-0 inset-y-0 flex items-center pl-3">
              <font-awesome-icon icon="lock" class="h-5 w-5 text-white/70" />
            </span>
            {{ loading ? 'درحال ورود...' : 'ورود' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const username = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
  try {
    loading.value = true;
    error.value = '';
    
    // Call the admin login API
    const response = await axios.post(`${import.meta.env.VITE_API_BASE_URL}/api/admin/login`, {
      email: username.value, 
      password: password.value
    });
    
    // Store the token
    localStorage.setItem('admin_token', response.data.token);
    
    // Redirect to dashboard or intended page
    const redirectPath = route.query.redirect || '/admin';
    router.push(redirectPath);
  } catch (err) {
    console.error('Login error:', err);
    error.value = err.response?.data?.message || 'خطا در ورود. لطفا مجددا تلاش کنید.';
  } finally {
    loading.value = false;
  }
};
</script> 