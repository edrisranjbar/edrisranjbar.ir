<template>
  <div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <!-- Posts stats -->
      <div class="rounded-lg bg-black/50 border border-white/10 p-6 flex items-center">
        <div class="bg-blue-500/10 rounded-lg w-14 h-14 flex items-center justify-center ml-4">
          <font-awesome-icon icon="newspaper" class="h-6 w-6 text-blue-500" />
        </div>
        <div>
          <div class="text-white/50 text-sm font-vazir mb-1">تعداد مطالب</div>
          <div class="text-white text-3xl font-vazir font-bold">
            <span v-if="loading">...</span>
            <span v-else>{{ stats.postsCount }}</span>
          </div>
        </div>
      </div>
      
      <!-- Categories stats -->
      <div class="rounded-lg bg-black/50 border border-white/10 p-6 flex items-center">
        <div class="bg-green-500/10 rounded-lg w-14 h-14 flex items-center justify-center ml-4">
          <font-awesome-icon icon="folder" class="h-6 w-6 text-green-500" />
        </div>
        <div>
          <div class="text-white/50 text-sm font-vazir mb-1">تعداد دسته‌بندی‌ها</div>
          <div class="text-white text-3xl font-vazir font-bold">
            <span v-if="loading">...</span>
            <span v-else>{{ stats.categoriesCount }}</span>
          </div>
        </div>
      </div>
      
      <!-- Published stats -->
      <div class="rounded-lg bg-black/50 border border-white/10 p-6 flex items-center">
        <div class="bg-purple-500/10 rounded-lg w-14 h-14 flex items-center justify-center ml-4">
          <font-awesome-icon icon="check-circle" class="h-6 w-6 text-purple-500" />
        </div>
        <div>
          <div class="text-white/50 text-sm font-vazir mb-1">مطالب منتشر شده</div>
          <div class="text-white text-3xl font-vazir font-bold">
            <span v-if="loading">...</span>
            <span v-else>{{ stats.publishedCount }}</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Recent Posts -->
    <div class="rounded-lg bg-black/50 border border-white/10 p-6 mb-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-vazir text-white">آخرین مطالب</h2>
        <router-link to="/admin/posts" class="text-primary text-sm hover:text-primary-light transition-colors duration-150 font-vazir">
          مشاهده همه
        </router-link>
      </div>
      
      <div v-if="loading" class="flex justify-center py-6">
        <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-primary"></div>
      </div>
      
      <div v-else-if="recentPosts.length === 0" class="text-center py-6 text-white/50 font-vazir">
        هنوز مطلبی ایجاد نشده است.
      </div>
      
      <div v-else class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-right border-b border-white/10">
              <th class="py-3 pr-3 text-sm font-vazir text-white/60 font-normal">عنوان</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">دسته‌بندی</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">تاریخ</th>
              <th class="py-3 pl-3 text-sm font-vazir text-white/60 font-normal">وضعیت</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in recentPosts" :key="post.id" class="text-right border-b border-white/5 hover:bg-white/5">
              <td class="py-4 pr-3">
                <div class="font-vazir text-white text-sm truncate max-w-xs">{{ post.title }}</div>
              </td>
              <td class="py-4 px-3">
                <span class="inline-flex px-2 py-1 bg-primary/10 text-primary text-xs rounded-full font-vazir">
                  {{ post.category?.name || 'بدون دسته‌بندی' }}
                </span>
              </td>
              <td class="py-4 px-3">
                <div class="font-vazir text-white/70 text-sm">{{ formatDate(post.published_at) }}</div>
              </td>
              <td class="py-4 pl-3">
                <span 
                  :class="post.published ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500'"
                  class="inline-flex px-2 py-1 text-xs rounded-full font-vazir"
                >
                  {{ post.published ? 'منتشر شده' : 'پیش‌نویس' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="rounded-lg bg-black/50 border border-white/10 p-6">
      <h2 class="text-lg font-vazir text-white mb-6">دسترسی سریع</h2>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <router-link to="/admin/posts/create" class="p-4 bg-primary/5 hover:bg-primary/10 border border-primary/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-primary/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="plus" class="h-4 w-4 text-primary" />
          </div>
          <span class="text-white font-vazir text-sm">ایجاد مطلب جدید</span>
        </router-link>
        
        <router-link to="/admin/categories/create" class="p-4 bg-green-500/5 hover:bg-green-500/10 border border-green-500/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-green-500/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="folder-plus" class="h-4 w-4 text-green-500" />
          </div>
          <span class="text-white font-vazir text-sm">ایجاد دسته‌بندی جدید</span>
        </router-link>
        
        <a href="/" target="_blank" class="p-4 bg-blue-500/5 hover:bg-blue-500/10 border border-blue-500/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-blue-500/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="globe" class="h-4 w-4 text-blue-500" />
          </div>
          <span class="text-white font-vazir text-sm">مشاهده سایت</span>
        </a>
        
        <a href="/blog" target="_blank" class="p-4 bg-purple-500/5 hover:bg-purple-500/10 border border-purple-500/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-purple-500/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="rss" class="h-4 w-4 text-purple-500" />
          </div>
          <span class="text-white font-vazir text-sm">مشاهده وبلاگ</span>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loading = ref(true);
const stats = ref({
  postsCount: 0,
  categoriesCount: 0,
  publishedCount: 0
});
const recentPosts = ref([]);

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Intl.DateTimeFormat('fa-IR', options).format(date);
};

const fetchDashboardData = async () => {
  try {
    loading.value = true;
    
    // In a real app, you'd have a specific endpoint for dashboard stats
    // For now, we'll make individual requests
    const [postsRes, categoriesRes] = await Promise.all([
      axios.get(`${import.meta.env.VITE_API_URL}/api/posts?limit=5`),
      axios.get(`${import.meta.env.VITE_API_URL}/api/categories`)
    ]);
    
    // Get recent posts
    if (postsRes.data && postsRes.data.data) {
      recentPosts.value = postsRes.data.data.slice(0, 5);
    }
    
    // Calculate stats
    stats.value = {
      postsCount: postsRes.data.meta?.total || recentPosts.value.length,
      categoriesCount: categoriesRes.data.data?.length || 0,
      publishedCount: recentPosts.value.filter(post => post.published).length
    };
  } catch (error) {
    console.error('Error fetching dashboard data:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchDashboardData();
});
</script> 