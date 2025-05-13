<template>
  <div class="container mx-auto px-4 py-12 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full bg-white/5 rounded-lg border border-white/10 p-8 text-center">
      <div v-if="loading" class="py-8">
        <div class="spinner mx-auto mb-4"></div>
        <p class="text-gray-300">در حال بررسی وضعیت پرداخت...</p>
      </div>

      <div v-else-if="success" class="py-4">
        <div class="w-20 h-20 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-white mb-4">پرداخت موفق</h1>
        <p class="text-gray-300 mb-6">{{ message }}</p>
        
        <div v-if="donation" class="bg-white/5 rounded-lg p-4 mb-6 text-right">
          <div class="flex justify-between py-2 border-b border-white/10">
            <span class="text-gray-400">شناسه پرداخت:</span>
            <span class="text-white font-medium">{{ donation.id }}</span>
          </div>
          <div class="flex justify-between py-2 border-b border-white/10">
            <span class="text-gray-400">مبلغ:</span>
            <span class="text-white font-medium">{{ donation.amount }}</span>
          </div>
          <div class="flex justify-between py-2 border-b border-white/10">
            <span class="text-gray-400">کد پیگیری:</span>
            <span class="text-white font-medium ltr text-right">{{ donation.ref_id }}</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-gray-400">تاریخ:</span>
            <span class="text-white font-medium">{{ donation.created_at }}</span>
          </div>
        </div>
        
        <router-link to="/" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium">
          بازگشت به صفحه اصلی
        </router-link>
      </div>

      <div v-else class="py-4">
        <div class="w-20 h-20 rounded-full bg-red-500/20 flex items-center justify-center mx-auto mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-white mb-4">خطا در پرداخت</h1>
        <p class="text-gray-300 mb-6">{{ error }}</p>
        
        <router-link to="/#donate" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium">
          تلاش مجدد
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const loading = ref(true)
const success = ref(false)
const error = ref('')
const message = ref('')
const donation = ref(null)

onMounted(async () => {
  const urlParams = new URLSearchParams(window.location.search)
  const authority = urlParams.get('Authority') || urlParams.get('authority')
  const status = urlParams.get('status') || urlParams.get('Status')
  
  // If no payment parameters, show friendly message instead of error
  if (!authority || !status) {
    loading.value = false
    
    // Show success message if manually navigated to this page
    if (!urlParams.toString()) {
      success.value = true
      message.value = 'برای انجام حمایت مالی، لطفا از طریق صفحه اصلی اقدام نمایید.'
    } else {
      // Show error for invalid payment parameters
      error.value = 'اطلاعات پرداخت ناقص است. لطفاً مجدداً تلاش کنید.'
    }
    return
  }
  
  try {
    const apiBaseUrl = import.meta.env.VITE_API_BASE_URL || 'https://api.edrisranjbar.ir'
    
    // Convert status to proper format for API
    const apiStatus = status.toLowerCase() === 'success' || status === 'OK' ? 'OK' : 'NOK'
    
    const response = await fetch(`${apiBaseUrl}/donations/verify?Authority=${authority}&Status=${apiStatus}`)
    const data = await response.json()
    
    loading.value = false
    
    if ((status.toLowerCase() === 'success' || status === 'OK') || (response.ok && data.success)) {
      success.value = true
      message.value = data.message || 'پرداخت شما با موفقیت انجام شد. از حمایت شما سپاسگزاریم.'
      donation.value = data.donation
    } else {
      error.value = data.message || 'پرداخت ناموفق یا لغو شده. لطفاً مجدد تلاش کنید.'
    }
  } catch (err) {
    loading.value = false
    error.value = 'خطا در اتصال به سرور. لطفاً مجدد تلاش کنید.'
    console.error('Donation verification error:', err)
  }
  
  // Remove query parameters from URL without refreshing page
  // Only do this if there are parameters
  if (urlParams.toString()) {
    window.history.replaceState({}, document.title, '/donation/success')
  }
})
</script>

<style scoped>
.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  border-top-color: #10b981;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.ltr {
  direction: ltr;
}
</style> 