<template>
  <div>
    <!-- Dashboard widgets (3-widget stats) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-primary/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="newspaper" class="text-xl text-primary" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">تعداد مطالب</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ stats.posts || 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-emerald-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="folder" class="text-xl text-emerald-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">تعداد دسته‌بندی‌ها</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ stats.categories || 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-yellow-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="comments" class="text-xl text-yellow-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">دیدگاه‌های در انتظار</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ stats.pendingComments || 0 }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Posts -->
    <div class="rounded-lg bg-black/50 border border-white/10 p-6 mb-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-vazir text-white">آخرین مطالب</h2>
        <router-link to="/admin/posts"
          class="text-primary text-sm hover:text-primary-light transition-colors duration-150 font-vazir">
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
                <span :class="post.published ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500'"
                  class="inline-flex px-2 py-1 text-xs rounded-full font-vazir">
                  {{ post.published ? 'منتشر شده' : 'پیش‌نویس' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent comments widget -->
    <div class="bg-black/30 rounded-lg border border-white/10 overflow-hidden mb-8">
      <div class="bg-black/50 p-4 border-b border-white/10 flex items-center justify-between">
        <h3 class="text-white font-vazir text-lg flex items-center">
          <font-awesome-icon icon="comments" class="text-primary ml-2" />
          آخرین دیدگاه‌ها
        </h3>
        <router-link to="/admin/comments"
          class="bg-primary/10 hover:bg-primary/20 text-primary text-xs px-3 py-1 rounded-md font-vazir transition-colors">
          مشاهده همه
        </router-link>
      </div>

      <div class="divide-y divide-black/50">
        <div v-if="recentComments.loading" class="p-6 flex justify-center">
          <div class="w-8 h-8 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
        </div>

        <div v-else-if="recentComments.error" class="p-6 text-center text-red-400 font-vazir text-sm">
          خطایی در بارگذاری دیدگاه‌ها رخ داده است.
        </div>

        <div v-else-if="recentComments.data.length === 0" class="p-6 text-center text-white/50 font-vazir text-sm">
          در حال حاضر دیدگاهی ثبت نشده است.
        </div>

        <template v-else>
          <div v-for="comment in recentComments.data" :key="comment.id" class="p-4 hover:bg-black/10 transition-colors">
            <div class="flex items-start">
              <div class="rounded-full w-10 h-10 bg-white/10 flex items-center justify-center ml-3">
                <font-awesome-icon icon="user" class="text-white/70" />
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <div class="flex items-center">
                    <h4 class="font-vazir text-white text-sm">
                      {{ comment.name }}
                    </h4>
                    <span :class="[
                      comment.status === 'pending' ? 'bg-yellow-500/20 text-yellow-500' :
                        comment.status === 'approved' ? 'bg-emerald-500/20 text-emerald-500' :
                          'bg-red-500/20 text-red-500'
                    ]" class="text-xs px-2 py-0.5 rounded-full mr-2 font-vazir">
                      {{
                        comment.status === 'pending' ? 'در انتظار' :
                          comment.status === 'approved' ? 'تایید شده' :
                            'حذف شده'
                      }}
                    </span>
                  </div>
                  <span class="text-white/50 text-xs font-vazir">{{ formatDate(comment.created_at) }}</span>
                </div>
                <p class="text-white/70 text-sm font-vazir">
                  {{ truncateText(comment.content, 80) }}
                </p>
                <div class="mt-2 flex items-center justify-between">
                  <span v-if="comment.post" class="text-white/50 text-xs font-vazir flex items-center">
                    <font-awesome-icon icon="newspaper" class="text-primary/70 ml-1 text-xs" />
                    {{ truncateText(comment.post.title, 30) }}
                  </span>
                  <router-link :to="`/admin/comments/${comment.id}`"
                    class="bg-primary/10 text-primary hover:bg-primary/20 transition-colors duration-150 rounded-md px-2 py-0.5 text-xs font-vazir flex items-center">
                    <font-awesome-icon icon="eye" class="ml-1" />
                    مشاهده
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-lg bg-black/50 border border-white/10 p-6 mb-8">
      <h2 class="text-lg font-vazir text-white mb-6">دسترسی سریع</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <router-link to="/admin/posts/create"
          class="p-4 bg-primary/5 hover:bg-primary/10 border border-primary/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-primary/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="plus" class="h-4 w-4 text-primary" />
          </div>
          <span class="text-white font-vazir text-sm">ایجاد مطلب جدید</span>
        </router-link>

        <router-link to="/admin/categories/create"
          class="p-4 bg-green-500/5 hover:bg-green-500/10 border border-green-500/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-green-500/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="folder-plus" class="h-4 w-4 text-green-500" />
          </div>
          <span class="text-white font-vazir text-sm">ایجاد دسته‌بندی جدید</span>
        </router-link>

        <a href="/" target="_blank"
          class="p-4 bg-blue-500/5 hover:bg-blue-500/10 border border-blue-500/20 rounded-lg transition-colors duration-200 flex items-center">
          <div class="bg-blue-500/10 rounded-lg w-10 h-10 flex items-center justify-center ml-3">
            <font-awesome-icon icon="globe" class="h-4 w-4 text-blue-500" />
          </div>
          <span class="text-white font-vazir text-sm">مشاهده سایت</span>
        </a>

        <a href="/blog" target="_blank"
          class="p-4 bg-purple-500/5 hover:bg-purple-500/10 border border-purple-500/20 rounded-lg transition-colors duration-200 flex items-center">
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
import { API_URL } from '@/config';

const loading = ref(true);
const stats = ref({
  postsCount: 0,
  categoriesCount: 0,
  publishedCount: 0,
  posts: 0,
  categories: 0,
  pendingComments: 0,
  views: 0
});
const recentPosts = ref([]);
const recentComments = ref({
  loading: true,
  error: null,
  data: []
});

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };

  // Get the formatted date parts from Intl.DateTimeFormat
  const formatter = new Intl.DateTimeFormat('fa-IR', options);
  const parts = formatter.formatToParts(date);

  // Extract the individual parts
  let day = '';
  let month = '';
  let year = '';

  parts.forEach(part => {
    if (part.type === 'day') day = part.value;
    if (part.type === 'month') month = part.value;
    if (part.type === 'year') year = part.value;
  });

  // Format according to the required pattern: ۲۳ اردیبهشت ۱۴۰۴
  return `${day} ${month} ${year}`;
};

const truncateText = (text, maxLength) => {
  if (!text) return '';
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '...';
};

const fetchDashboardData = async () => {
  try {
    loading.value = true;

    const token = localStorage.getItem('admin_token');

    const response = await axios.get(`${API_URL}/api/admin/dashboard`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    // Update stats
    stats.value = response.data.stats;
  } catch (err) {
    console.error('Error fetching dashboard data:', err);
  } finally {
    loading.value = false;
  }
};

const fetchRecentPosts = async () => {
  try {
    const token = localStorage.getItem('admin_token');

    const response = await axios.get(`${API_URL}/api/admin/posts`, {
      params: {
        per_page: 5,
        sort: '-created_at'
      },
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    recentPosts.value = response.data.data || [];
  } catch (err) {
    console.error('Error fetching recent posts:', err);
    recentPosts.value = [];
  }
};

const fetchRecentComments = async () => {
  try {
    recentComments.value.loading = true;
    recentComments.value.error = null;

    const token = localStorage.getItem('admin_token');

    const response = await axios.get(`${API_URL}/api/admin/comments`, {
      params: {
        per_page: 5,
        sort: '-created_at',
        status: 'all'
      },
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    recentComments.value.data = response.data.data || [];
  } catch (err) {
    console.error('Error fetching recent comments:', err);
    recentComments.value.error = 'خطایی در بارگذاری دیدگاه‌ها رخ داده است';
    recentComments.value.data = [];
  } finally {
    recentComments.value.loading = false;
  }
};

onMounted(() => {
  fetchDashboardData();
  fetchRecentPosts();
  fetchRecentComments();
});
</script>