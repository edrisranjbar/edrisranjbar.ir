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
              @click="selectPresetAmount(50000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium',
                amount === 50000 && !isCustomAmount
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۵۰,۰۰۰ تومان
            </button>
            <button
              @click="selectPresetAmount(250000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium relative',
                amount === 250000 && !isCustomAmount
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۲۵۰,۰۰۰ تومان
              <span class="absolute -top-2 right-2 text-xs bg-primary text-white px-2 py-0.5 rounded-full">پیشنهادی</span>
            </button>
            <button
              @click="selectPresetAmount(1000000)"
              :class="[
                'p-4 rounded-lg border transition-all duration-200 text-lg font-medium',
                amount === 1000000 && !isCustomAmount
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              ۱,۰۰۰,۰۰۰ تومان
            </button>
          </div>

          <!-- Custom Amount Toggle -->
          <div class="mb-8">
            <button 
              @click="toggleCustomAmount"
              :class="[
                'w-full p-4 rounded-lg border transition-all duration-200 text-base font-medium flex items-center justify-center gap-2',
                isCustomAmount
                  ? 'bg-primary/10 border-primary text-primary'
                  : 'border-white/5 text-white/70 hover:border-primary/50'
              ]"
            >
              <font-awesome-icon :icon="isCustomAmount ? 'times' : 'plus'" />
              {{ isCustomAmount ? 'بازگشت به مبالغ پیشنهادی' : 'وارد کردن مبلغ دلخواه' }}
            </button>
          </div>

          <!-- Custom Amount Input -->
          <div class="mb-8" v-if="isCustomAmount">
            <div class="relative">
              <input
                type="number"
                v-model="customAmount"
                placeholder="مبلغ دلخواه (تومان)"
                class="w-full bg-black/40 border border-white/5 rounded-lg px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary/50 transition-colors text-left"
                min="10000"
                step="10000"
                @input="updateAmount"
              />
            </div>
          </div>
          <div class="mb-8" v-else>
            <div class="relative">
              <input
                type="text"
                :value="formatAmount(amount)"
                disabled
                class="w-full bg-black/20 border border-white/5 rounded-lg px-4 py-3 text-white/50 focus:outline-none transition-colors text-center"
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
const customAmount = ref('')
const isCustomAmount = ref(false)

const isValidAmount = computed(() => {
  if (isCustomAmount.value) {
    return Number(customAmount.value) >= 10000
  }
  return amount.value >= 10000
})

const selectPresetAmount = (value) => {
  amount.value = value
  customAmount.value = ''
  isCustomAmount.value = false
}

const toggleCustomAmount = () => {
  isCustomAmount.value = !isCustomAmount.value
  if (isCustomAmount.value) {
    customAmount.value = amount.value.toString()
  } else {
    amount.value = 250000
    customAmount.value = ''
  }
}

const updateAmount = () => {
  amount.value = Number(customAmount.value)
}

const formatAmount = (value) => {
  return new Intl.NumberFormat('fa-IR').format(value) + ' تومان'
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