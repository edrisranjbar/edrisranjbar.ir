<template>
  <div class="min-h-screen bg-dark text-white font-vazir">
    <Navbar />
    <router-view v-slot="{ Component }">
      <transition
        name="page"
        mode="out-in"
        @before-leave="beforeLeave"
        @enter="enter"
        @after-enter="afterEnter"
      >
        <component :is="Component" />
      </transition>
    </router-view>
    <Footer />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const beforeLeave = (el) => {
  el.style.opacity = 0
  el.style.transform = 'translateX(20px)'
}

const enter = (el) => {
  el.style.opacity = 0
  el.style.transform = 'translateX(-20px)'
}

const afterEnter = (el) => {
  el.style.opacity = 1
  el.style.transform = 'translateX(0)'
}

onMounted(() => {
  document.documentElement.setAttribute('dir', 'rtl')
})
</script>

<style>
:root {
  --primary: #3B82F6;
  --primary-dark: #2563EB;
  --primary-light: #60A5FA;
  --dark: #111827;
}

body {
  background-color: var(--dark);
  direction: rtl;
}

.page-enter-active,
.page-leave-active {
  transition: all 0.3s ease;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
