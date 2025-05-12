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

        <div class="bg-black/40 rounded-2xl p-8 border border-white/5">
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
          </div>

          <!-- Payment Button -->
          <button
            @click="handleDonate"
            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-4 px-8 rounded-lg transition-colors duration-200 flex items-center justify-center gap-3 text-lg disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="!isValidAmount"
          >
            <font-awesome-icon icon="credit-card" />
            پرداخت از طریق درگاه زرین‌پال
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const amount = ref(250000)

const isValidAmount = computed(() => {
  return Number(amount.value) >= 10000
})

const selectAmount = (value) => {
  amount.value = value
}

const validateAmount = () => {
  if (Number(amount.value) < 10000) {
    amount.value = 10000
  }
}

const handleDonate = () => {
  // TODO: Implement Zarinpal payment
  console.log('Donating amount:', amount.value)
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