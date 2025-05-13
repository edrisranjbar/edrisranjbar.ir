<template>
  <div>
    <!-- Filter tabs -->
    <div class="bg-black/30 rounded-lg p-3 mb-6 border border-white/10">
      <div class="flex flex-wrap gap-2">
        <button 
          @click="changeFilter('pending')" 
          :class="[currentFilter === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border-yellow-500/50' : 'bg-black/20 text-white/70 border-white/10 hover:bg-white/5']"
          class="px-3 py-1.5 rounded-md text-sm font-vazir border transition duration-150"
        >
          در انتظار تایید
          <span v-if="pendingCount > 0" class="inline-flex items-center justify-center px-2 py-0.5 mr-1 text-xs rounded-full bg-yellow-500/30 text-yellow-300">
            {{ pendingCount }}
          </span>
        </button>
        
        <button 
          @click="changeFilter('approved')" 
          :class="[currentFilter === 'approved' ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/50' : 'bg-black/20 text-white/70 border-white/10 hover:bg-white/5']"
          class="px-3 py-1.5 rounded-md text-sm font-vazir border transition duration-150"
        >
          تایید شده
        </button>
        
        <button 
          @click="changeFilter('trashed')" 
          :class="[currentFilter === 'trashed' ? 'bg-red-500/20 text-red-400 border-red-500/50' : 'bg-black/20 text-white/70 border-white/10 hover:bg-white/5']"
          class="px-3 py-1.5 rounded-md text-sm font-vazir border transition duration-150"
        >
          حذف شده
        </button>
      </div>
    </div>
    
    <!-- Loading indicator -->
    <div v-if="loading" class="flex justify-center py-12">
      <div class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>
    
    <!-- Error message -->
    <div v-else-if="error" class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 text-center text-red-400 font-vazir">
      خطایی در بارگذاری دیدگاه‌ها رخ داده است. لطفا صفحه را مجددا بارگذاری کنید.
    </div>
    
    <!-- Empty state -->
    <div v-else-if="comments.length === 0" class="bg-black/20 rounded-lg border border-white/10 p-8 text-center">
      <font-awesome-icon icon="comment-slash" class="text-white/30 text-4xl mb-3" />
      <p class="text-white/70 font-vazir">
        در حال حاضر دیدگاهی 
        <span v-if="currentFilter === 'pending'">در انتظار تایید</span>
        <span v-else-if="currentFilter === 'approved'">تایید شده</span>
        <span v-else-if="currentFilter === 'trashed'">حذف شده</span>
        وجود ندارد.
      </p>
    </div>
    
    <!-- Comments list -->
    <div v-else class="space-y-4">
      <div 
        v-for="comment in comments" 
        :key="comment.id"
        class="bg-black/20 rounded-lg p-4 border border-white/10 transition-all hover:bg-black/30"
      >
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
          <div class="flex items-center mb-2 sm:mb-0">
            <div class="rounded-full w-10 h-10 bg-white/10 flex items-center justify-center ml-3">
              <font-awesome-icon icon="user" class="text-white/70" />
            </div>
            <div>
              <h3 class="font-vazir text-white text-sm">
                {{ comment.name }}
                <span v-if="comment.is_admin_reply" class="bg-primary/20 text-primary text-xs px-2 py-0.5 rounded-full mr-2">مدیر</span>
              </h3>
              <span class="text-white/50 text-xs font-vazir flex items-center">
                <span class="ml-2">{{ formatDate(comment.created_at) }}</span>
                <span v-if="comment.post" class="flex items-center mr-2">
                  <font-awesome-icon icon="newspaper" class="text-primary/70 ml-1 text-xs" />
                  {{ truncateText(comment.post.title, 30) }}
                </span>
              </span>
            </div>
          </div>
          
          <div class="flex gap-2">
            <router-link 
              :to="`/admin/comments/${comment.id}`" 
              class="bg-primary/10 text-primary hover:bg-primary/20 transition-colors duration-150 rounded-md px-3 py-1 text-xs font-vazir"
            >
              <font-awesome-icon icon="eye" class="ml-1" />
              مشاهده
            </router-link>
            
            <button 
              v-if="currentFilter === 'pending'"
              @click="updateStatus(comment.id, 'approved')"
              class="bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 transition-colors duration-150 rounded-md px-3 py-1 text-xs font-vazir"
            >
              <font-awesome-icon icon="check-circle" class="ml-1" />
              تایید
            </button>
            
            <button 
              v-if="currentFilter === 'approved'"
              @click="updateStatus(comment.id, 'trashed')"
              class="bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-colors duration-150 rounded-md px-3 py-1 text-xs font-vazir"
            >
              <font-awesome-icon icon="trash-alt" class="ml-1" />
              حذف
            </button>
            
            <button 
              v-if="currentFilter === 'trashed'"
              @click="updateStatus(comment.id, 'approved')"
              class="bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 transition-colors duration-150 rounded-md px-3 py-1 text-xs font-vazir"
            >
              <font-awesome-icon icon="redo" class="ml-1" />
              بازگرداندن
            </button>
          </div>
        </div>
        
        <div class="bg-black/30 rounded-md p-3 border border-white/10">
          <p class="text-white/90 text-sm font-vazir leading-relaxed">{{ truncateText(comment.content, 200) }}</p>
        </div>
        
        <div v-if="comment.parent_id" class="mt-3 bg-black/10 rounded-md p-3 border border-black/20">
          <p class="text-white/60 text-xs font-vazir mb-2">در پاسخ به:</p>
          <p class="text-white/80 text-xs font-vazir">{{ truncateText(comment.parent_content || '...', 100) }}</p>
        </div>
      </div>
    </div>
    
    <!-- Pagination controls -->
    <div v-if="pagination && pagination.last_page > 1" class="mt-6 flex justify-center">
      <div class="flex gap-1">
        <button
          v-for="page in getPageNumbers()"
          :key="page"
          @click="goToPage(page)"
          :class="[
            currentPage === page ? 'bg-primary text-white' : 'bg-black/20 text-white/70 hover:bg-black/40',
            'w-8 h-8 flex items-center justify-center rounded-md font-vazir text-sm transition-colors'
          ]"
        >
          {{ page }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { API_URL } from '@/config';

const comments = ref([]);
const loading = ref(true);
const error = ref(null);
const currentFilter = ref('pending');
const currentPage = ref(1);
const pagination = ref(null);
const pendingCount = ref(0);

// Fetch comments from the backend
const fetchComments = async () => {
  try {
    loading.value = true;
    
    const token = localStorage.getItem('admin_token');
    
    const response = await axios.get(`${API_URL}/api/admin/comments`, {
      params: {
        status: currentFilter.value,
        page: currentPage.value
      },
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    comments.value = response.data.data;
    
    // Extract pagination data
    pagination.value = {
      current_page: response.data.meta?.current_page || 1,
      last_page: response.data.meta?.last_page || 1,
      from: response.data.meta?.from,
      to: response.data.meta?.to,
      total: response.data.meta?.total
    };
    
    // Update pending count if we're not on the pending tab
    if (currentFilter.value !== 'pending') {
      await fetchPendingCount();
    } else {
      pendingCount.value = pagination.value.total;
    }
    
    error.value = null;
  } catch (err) {
    console.error('Error fetching comments:', err);
    error.value = 'خطایی در بارگذاری دیدگاه‌ها رخ داده است';
  } finally {
    loading.value = false;
  }
};

// Fetch pending comments count for notification badge
const fetchPendingCount = async () => {
  try {
    const token = localStorage.getItem('admin_token');
    
    const response = await axios.get(`${API_URL}/api/admin/comments`, {
      params: {
        status: 'pending',
        per_page: 1 // Request only 1 comment to minimize data transfer
      },
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    // Get the total from pagination
    pendingCount.value = response.data.meta?.total || 0;
  } catch (err) {
    console.error('Error fetching pending count:', err);
  }
};

// Update comment status
const updateStatus = async (commentId, status) => {
  try {
    const token = localStorage.getItem('admin_token');
    
    await axios.patch(`${API_URL}/api/admin/comments/${commentId}/status`, {
      status: status
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    // Refresh comments list
    await fetchComments();
  } catch (err) {
    console.error('Error updating comment status:', err);
    alert('خطایی در بروزرسانی وضعیت دیدگاه رخ داد. لطفا مجددا تلاش کنید.');
  }
};

// Change filter and reset to page 1
const changeFilter = (filter) => {
  currentFilter.value = filter;
  currentPage.value = 1;
};

// Go to a specific page
const goToPage = (page) => {
  currentPage.value = page;
};

// Generate array of page numbers to display
const getPageNumbers = () => {
  if (!pagination.value) return [];
  
  const totalPages = pagination.value.last_page;
  const currentPageNum = pagination.value.current_page;
  
  // If less than 5 pages, show all
  if (totalPages <= 5) {
    return Array.from({ length: totalPages }, (_, i) => i + 1);
  }
  
  // Otherwise, show current page and surrounding pages
  let startPage = Math.max(1, currentPageNum - 2);
  let endPage = Math.min(totalPages, startPage + 4);
  
  // Adjust if at the end
  if (endPage === totalPages) {
    startPage = Math.max(1, endPage - 4);
  }
  
  return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
};

// Format date to Jalali (Persian) format
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

// Truncate text for display
const truncateText = (text, maxLength) => {
  if (!text) return '';
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '...';
};

// Refetch comments when filter or page changes
watch([currentFilter, currentPage], () => {
  fetchComments();
});

onMounted(() => {
  fetchComments();
});
</script> 