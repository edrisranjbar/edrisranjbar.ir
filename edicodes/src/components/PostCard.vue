<template>
  <div class="overflow-hidden rounded-lg border border-white/10 bg-black/30 transition-all duration-300 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/10">
    <router-link :to="`/blog/${post.slug}`" class="block">
      <div class="relative pb-[56.25%] bg-black/50 overflow-hidden group">
        <div v-if="!post.image || imageError" class="absolute inset-0 flex items-center justify-center bg-black/50">
          <font-awesome-icon icon="book" class="text-4xl text-primary/30" />
        </div>
        <img 
          v-else
          :src="post.image" 
          :alt="post.title" 
          class="absolute h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" 
          @error="handleImageError"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
          <span class="text-sm text-white font-vazir">مشاهده مطلب</span>
        </div>
      </div>
    </router-link>
    <div class="p-4">
      <div class="mb-2 flex items-center flex-wrap gap-2">
        <span class="rounded-full bg-primary/20 px-3 py-1 text-xs text-primary">
          {{ post.category?.name || 'عمومی' }}
        </span>
        <span class="text-xs text-white/50">{{ formatDate(post.published_at) }}</span>
      </div>
      <router-link :to="`/blog/${post.slug}`" class="block group">
        <h3 class="mb-2 text-xl font-bold font-vazir line-clamp-2 group-hover:text-primary transition-colors duration-300">{{ post.title }}</h3>
      </router-link>
      <p class="mb-4 text-sm text-white/70 font-vazir line-clamp-3">{{ post.summary }}</p>
      <router-link
        :to="`/blog/${post.slug}`"
        class="inline-flex items-center text-primary hover:text-primary-dark transition-colors"
      >
        <span>ادامه مطلب</span>
        <font-awesome-icon icon="arrow-left" class="mr-1" />
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  post: {
    type: Object,
    required: true
  }
});

const imageError = ref(false);

const handleImageError = () => {
  imageError.value = true;
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  // Convert to Persian date format
  return new Intl.DateTimeFormat('fa-IR', options).format(date);
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>