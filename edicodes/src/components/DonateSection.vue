<template>
  <section id="donate" class="py-16 px-4 md:px-8 bg-black/40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4 font-vazir">
          <span class="text-primary">حمایت</span> مالی
        </h2>
        <p class="text-white/70 mb-8">
          با حمایت مالی از من، به توسعه پروژه‌های متن‌باز و تولید محتوای آموزشی کمک کنید.
        </p>

        <!-- Success message -->
        <div v-if="showSuccess" class="bg-primary/10 border border-primary/30 text-primary p-4 rounded-lg mb-6">
          <p class="flex items-center justify-center gap-2">
            <font-awesome-icon icon="check-circle" />
            {{ successMessage }}
          </p>
        </div>

        <!-- Error message -->
        <div v-if="error" class="bg-red-500/10 border border-red-500/30 text-red-500 p-4 rounded-lg mb-6">
          <p class="flex items-center justify-center gap-2">
            <font-awesome-icon icon="exclamation-circle" />
            {{ error }}
          </p>
        </div>

        <div class="bg-black/40 rounded-2xl p-8 border border-white/5">
          <!-- Form inputs -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <input
                type="text"
                v-model="name"
                placeholder="نام شما (اختیاری)"
                class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary transition-colors"
              />
            </div>
            <div>
              <input
                type="email"
                v-model="email"
                placeholder="ایمیل شما (اختیاری)"
                class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary transition-colors"
                dir="ltr"
              />
            </div>
          </div>
          
          <div class="mb-6">
            <textarea
              v-model="message"
              placeholder="پیام شما (اختیاری)"
              rows="2"
              class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary transition-colors"
            ></textarea>
          </div>

          <!-- Amount Selection -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <button
              @click="selectAmount(50000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium',
                amount === 50000
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۵۰,۰۰۰ تومان
            </button>
            <button
              @click="selectAmount(250000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium relative',
                amount === 250000
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۲۵۰,۰۰۰ تومان
              <span class="absolute -top-2 right-2 text-xs bg-primary text-white px-2 py-0.5 rounded-full">پیشنهادی</span>
            </button>
            <button
              @click="selectAmount(1000000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium',
                amount === 1000000
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۱,۰۰۰,۰۰۰ تومان
            </button>
          </div>

          <!-- Amount Input -->
          <div class="mb-8">
            <div class="relative">
              <input
                type="number"
                v-model="amount"
                placeholder="مبلغ دلخواه (تومان)"
                class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary transition-colors text-center"
                min="10000"
                step="10000"
                @input="validateAmount"
              />
            </div>
            <p v-if="amountError" class="text-red-500 text-sm mt-1">{{ amountError }}</p>
          </div>

          <!-- Payment Button -->
          <button
            @click="handleDonate"
            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-4 px-8 rounded-lg transition-colors duration-200 flex items-center justify-center gap-3 text-lg disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="!isValidAmount || isLoading"
          >
            <font-awesome-icon v-if="isLoading" icon="circle-notch" class="animate-spin" />
            <font-awesome-icon v-else icon="credit-card" />
            {{ isLoading ? 'در حال اتصال به درگاه...' : 'حمایت کنید' }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const amount = ref(250000)
const name = ref('')
const email = ref('')
const message = ref('')
const isLoading = ref(false)
const error = ref('')
const amountError = ref('')
const showSuccess = ref(false)
const successMessage = ref('')

const isValidAmount = computed(() => {
  return Number(amount.value) >= 10000 && !amountError.value
})

const selectAmount = (value) => {
  amount.value = value
  amountError.value = ''
}

const validateAmount = () => {
  amountError.value = ''
  
  if (!amount.value) {
    amountError.value = 'لطفاً مبلغ را وارد کنید'
    return
  }
  
  if (Number(amount.value) < 10000) {
    amountError.value = 'حداقل مبلغ ۱۰,۰۰۰ تومان است'
    amount.value = 10000
    return
  }
}

const handleDonate = async () => {
  if (!isValidAmount.value || isLoading.value) return
  
  error.value = ''
  showSuccess.value = false
  isLoading.value = true
  
  try {
    const apiBaseUrl = import.meta.env.VITE_API_BASE_URL || 'https://api.edrisranjbar.ir';
    const response = await fetch(`${apiBaseUrl}/donations/pay`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        amount: amount.value,
        name: name.value,
        email: email.value, 
        message: message.value
      })
    });
    
    const data = await response.json();
    
    if (response.ok && data.success) {
      // Store donation ID in localStorage for future reference if needed
      if (data.donation_id) {
        localStorage.setItem('current_donation_id', data.donation_id);
      }
      
      // Redirect to payment gateway
      window.location.href = data.payment_url;
    } else {
      error.value = data.message || 'خطا در اتصال به درگاه پرداخت. لطفاً مجدد تلاش کنید.';
      
      if (data.errors && data.errors.amount) {
        amountError.value = data.errors.amount[0];
      }
    }
  } catch (err) {
    error.value = 'خطا در اتصال به سرور. لطفاً مجدد تلاش کنید.';
    console.error('Donation error:', err);
  } finally {
    isLoading.value = false;
  }
}
</script>

<style scoped>
.donate-card {
  @apply bg-white/5 rounded-lg border border-white/10 hover:border-primary/30 transition-all duration-200;
}

.btn-primary {
  @apply inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium;
}
</style> 