<template>
  <div class="pt-16" dir="rtl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl font-bold mb-6 font-vazir">
          <span class="text-primary">حمایت</span> از من
        </h1>
        <p class="text-white/70 mb-12 font-vazir">
          اگر از محتوای من لذت می‌برید و می‌خواهید از کار من حمایت کنید، می‌توانید از طریق یکی از روش‌های زیر این کار را انجام دهید.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <!-- Crypto -->
        <div class="donate-card">
          <div class="text-center p-6">
            <img src="https://edrisranjbar.ir/images/donate/crypto.svg" alt="ارز دیجیتال" class="w-16 h-16 mx-auto mb-4" />
            <h3 class="text-xl font-semibold mb-3 font-vazir">ارز دیجیتال</h3>
            <p class="text-white/70 mb-4 font-vazir">حمایت با بیت‌کوین، اتریوم و سایر ارزهای دیجیتال</p>
            <button @click="showCryptoModal = true" class="btn-primary font-vazir">
              مشاهده آدرس‌ها
            </button>
          </div>
        </div>

        <!-- Bank Transfer -->
        <div class="donate-card">
          <div class="text-center p-6">
            <img src="https://edrisranjbar.ir/images/donate/bank.svg" alt="انتقال بانکی" class="w-16 h-16 mx-auto mb-4" />
            <h3 class="text-xl font-semibold mb-3 font-vazir">انتقال بانکی</h3>
            <p class="text-white/70 mb-4 font-vazir">حمایت از طریق کارت به کارت یا شماره حساب</p>
            <button @click="showBankModal = true" class="btn-primary font-vazir">
              مشاهده اطلاعات
            </button>
          </div>
        </div>

        <!-- Buy Me a Coffee -->
        <div class="donate-card">
          <div class="text-center p-6">
            <img src="https://edrisranjbar.ir/images/donate/coffee.svg" alt="قهوه مهمان کنید" class="w-16 h-16 mx-auto mb-4" />
            <h3 class="text-xl font-semibold mb-3 font-vazir">قهوه مهمان کنید</h3>
            <p class="text-white/70 mb-4 font-vazir">حمایت از طریق پلتفرم Buy Me a Coffee</p>
            <a href="https://www.buymeacoffee.com/edrisranjbar" target="_blank" class="btn-primary font-vazir">
              حمایت
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showCryptoModal = ref(false)
const showBankModal = ref(false)
</script>

<style scoped>
.donate-card {
  @apply bg-white/5 rounded-lg border border-white/10 hover:border-primary/30 transition-all duration-200;
}

.btn-primary {
  @apply inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium;
}
</style> 