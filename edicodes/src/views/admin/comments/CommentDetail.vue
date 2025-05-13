<template>
  <div>
    <!-- Loading indicator -->
    <div v-if="loading" class="flex justify-center py-12">
      <div class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>
    
    <!-- Error message -->
    <div v-else-if="error" class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 text-center text-red-400 font-vazir">
      خطایی در بارگذاری اطلاعات رخ داده است. لطفا صفحه را مجددا بارگذاری کنید.
      <div class="mt-4">
        <button 
          @click="fetchComment" 
          class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-md text-sm font-vazir transition-colors"
        >
          تلاش مجدد
        </button>
      </div>
    </div>
    
    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Comment details -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Comment information -->
        <div class="bg-black/20 rounded-lg p-5 border border-white/10">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
            <div class="flex items-center mb-3 sm:mb-0">
              <div class="rounded-full w-12 h-12 bg-white/10 flex items-center justify-center ml-3">
                <font-awesome-icon icon="user" class="text-white/70 text-xl" />
              </div>
              <div>
                <h3 class="font-vazir text-white text-base">
                  {{ comment.name }}
                  <span v-if="comment.is_admin_reply" class="bg-primary/20 text-primary text-xs px-2 py-0.5 rounded-full mr-2">مدیر</span>
                </h3>
                <div class="text-white/50 text-xs font-vazir flex items-center flex-wrap">
                  <span class="ml-3">{{ formatDate(comment.created_at) }}</span>
                  <span v-if="comment.post" class="flex items-center">
                    <font-awesome-icon icon="newspaper" class="text-primary/70 ml-1 text-xs" />
                    <router-link 
                      :to="`/admin/posts/edit/${comment.post.id}`" 
                      class="text-primary/80 hover:text-primary"
                    >
                      {{ comment.post.title }}
                    </router-link>
                  </span>
                </div>
              </div>
            </div>
            
            <div v-if="comment.email" class="text-white/60 text-xs bg-black/30 rounded-md px-3 py-1.5 font-vazir">
              <font-awesome-icon icon="envelope" class="ml-1" />
              {{ comment.email }}
            </div>
          </div>
          
          <div class="bg-black/30 rounded-md p-4 border border-white/10 mb-4">
            <p class="text-white/90 text-sm font-vazir leading-relaxed whitespace-pre-line">{{ comment.content }}</p>
          </div>
          
          <div class="flex flex-wrap gap-2 border-t border-white/10 pt-4">
            <div class="flex-1 flex flex-wrap gap-2">
              <button 
                v-if="comment.status === 'pending'"
                @click="updateStatus('approved')"
                class="bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
              >
                <font-awesome-icon icon="check-circle" class="ml-1" />
                تایید دیدگاه
              </button>
              
              <button 
                v-if="comment.status === 'approved'"
                @click="updateStatus('pending')"
                class="bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
              >
                <font-awesome-icon icon="clock" class="ml-1" />
                برگشت به انتظار
              </button>
              
              <button 
                v-if="comment.status !== 'trashed'"
                @click="updateStatus('trashed')"
                class="bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
              >
                <font-awesome-icon icon="trash-alt" class="ml-1" />
                حذف دیدگاه
              </button>
              
              <button 
                v-if="comment.status === 'trashed'"
                @click="updateStatus('approved')"
                class="bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
              >
                <font-awesome-icon icon="redo" class="ml-1" />
                بازگرداندن
              </button>
              
              <button 
                v-if="comment.status === 'trashed'"
                @click="confirmDelete"
                class="bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
              >
                <font-awesome-icon icon="trash-alt" class="ml-1" />
                حذف دائمی
              </button>
            </div>
            
            <router-link 
              to="/admin/comments" 
              class="bg-black/30 hover:bg-black/40 text-white/70 transition-colors duration-150 rounded-md px-3 py-1.5 text-sm font-vazir flex items-center"
            >
              <font-awesome-icon icon="arrow-left" class="ml-1" />
              بازگشت
            </router-link>
          </div>
        </div>
        
        <!-- Parent comment (if this is a reply) -->
        <div v-if="parentComment" class="bg-black/20 rounded-lg p-5 border border-white/10">
          <h3 class="text-white text-sm font-vazir mb-3 flex items-center">
            <font-awesome-icon icon="reply" class="text-primary/70 ml-2 rotate-180" />
            دیدگاه اصلی
          </h3>
          
          <div class="bg-black/30 rounded-md p-4 border border-white/10 mb-4">
            <div class="flex items-center mb-2">
              <div class="rounded-full w-8 h-8 bg-white/10 flex items-center justify-center ml-2">
                <font-awesome-icon icon="user" class="text-white/70 text-sm" />
              </div>
              <div>
                <div class="font-vazir text-white text-xs">{{ parentComment.name }}</div>
                <div class="text-white/50 text-xs font-vazir">{{ formatDate(parentComment.created_at) }}</div>
              </div>
            </div>
            <p class="text-white/90 text-sm font-vazir leading-relaxed pr-10">{{ parentComment.content }}</p>
          </div>
          
          <div>
            <router-link 
              :to="`/admin/comments/${parentComment.id}`" 
              class="bg-primary/10 text-primary hover:bg-primary/20 transition-colors duration-150 rounded-md px-3 py-1 text-xs font-vazir inline-flex items-center"
            >
              <font-awesome-icon icon="eye" class="ml-1" />
              مشاهده دیدگاه اصلی
            </router-link>
          </div>
        </div>
        
        <!-- Replies to this comment -->
        <div v-if="replies.length > 0" class="bg-black/20 rounded-lg p-5 border border-white/10">
          <h3 class="text-white text-sm font-vazir mb-3 flex items-center">
            <font-awesome-icon icon="reply" class="text-primary/70 ml-2" />
            پاسخ‌ها ({{ replies.length }})
          </h3>
          
          <div class="space-y-4">
            <div 
              v-for="reply in replies" 
              :key="reply.id"
              class="bg-black/30 rounded-md p-4 border border-white/10"
            >
              <div class="flex items-center mb-2">
                <div :class="[reply.is_admin_reply ? 'bg-primary/20' : 'bg-white/10', 'rounded-full w-8 h-8 flex items-center justify-center ml-2']">
                  <font-awesome-icon icon="user" :class="[reply.is_admin_reply ? 'text-primary' : 'text-white/70', 'text-sm']" />
                </div>
                <div>
                  <div class="font-vazir text-white text-xs flex items-center">
                    {{ reply.name }}
                    <span v-if="reply.is_admin_reply" class="bg-primary/20 text-primary text-xs px-1.5 py-0.5 rounded-full mr-1.5 text-[10px]">مدیر</span>
                  </div>
                  <div class="text-white/50 text-[10px] font-vazir">{{ formatDate(reply.created_at) }}</div>
                </div>
                
                <div class="mr-auto">
                  <router-link 
                    :to="`/admin/comments/${reply.id}`" 
                    class="bg-primary/10 text-primary hover:bg-primary/20 transition-colors duration-150 rounded-md px-2 py-0.5 text-[10px] font-vazir inline-flex items-center"
                  >
                    <font-awesome-icon icon="eye" class="ml-1 text-[8px]" />
                    مشاهده
                  </router-link>
                </div>
              </div>
              <p class="text-white/90 text-xs font-vazir leading-relaxed">{{ reply.content }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Admin reply form -->
      <div class="lg:col-span-1">
        <div class="bg-black/20 rounded-lg p-5 border border-white/10 sticky top-24">
          <h3 class="text-white text-sm font-vazir mb-3 flex items-center">
            <font-awesome-icon icon="paper-plane" class="text-primary/70 ml-2" />
            ارسال پاسخ
          </h3>
          
          <form @submit.prevent="submitReply">
            <div class="mb-4">
              <textarea
                v-model="replyContent"
                rows="6"
                placeholder="متن پاسخ شما..."
                class="w-full bg-black/30 border border-white/10 rounded-md py-2 px-3 font-vazir text-white focus:outline-none focus:border-primary/50 text-sm"
                :disabled="submitting"
              ></textarea>
            </div>
            
            <button
              type="submit"
              :disabled="submitting || !replyContent.trim()"
              class="w-full bg-primary hover:bg-primary-dark text-white rounded-md py-2 px-4 font-vazir text-sm flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="submitting" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin ml-2"></span>
              <font-awesome-icon v-else icon="paper-plane" class="ml-2" />
              ارسال پاسخ
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { API_URL } from '@/config';

const props = defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});

const route = useRoute();
const router = useRouter();

const comment = ref({});
const parentComment = ref(null);
const replies = ref([]);
const loading = ref(true);
const error = ref(null);
const replyContent = ref('');
const submitting = ref(false);

// Fetch comment details
const fetchComment = async () => {
  try {
    loading.value = true;
    
    const token = localStorage.getItem('admin_token');
    
    const response = await axios.get(`${API_URL}/api/admin/comments/${props.id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    comment.value = response.data.data;
    
    // If this comment has a parent, fetch it
    if (comment.value.parent_id) {
      await fetchParentComment(comment.value.parent_id);
    }
    
    // Fetch replies to this comment
    await fetchReplies();
    
    error.value = null;
  } catch (err) {
    console.error('Error fetching comment:', err);
    error.value = 'Failed to fetch comment details';
  } finally {
    loading.value = false;
  }
};

// Fetch parent comment if this is a reply
const fetchParentComment = async (parentId) => {
  try {
    const token = localStorage.getItem('admin_token');
    
    const response = await axios.get(`${API_URL}/api/admin/comments/${parentId}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    parentComment.value = response.data.data;
  } catch (err) {
    console.error('Error fetching parent comment:', err);
  }
};

// Fetch replies to this comment
const fetchReplies = async () => {
  try {
    const token = localStorage.getItem('admin_token');
    
    // Assuming there's an endpoint to get replies to a comment
    const response = await axios.get(`${API_URL}/api/admin/comments/${props.id}/replies`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    replies.value = response.data.data || [];
  } catch (err) {
    console.error('Error fetching replies:', err);
    // Don't show error for this, it's not critical
  }
};

// Update comment status
const updateStatus = async (status) => {
  try {
    const token = localStorage.getItem('admin_token');
    
    await axios.patch(`${API_URL}/api/admin/comments/${props.id}/status`, {
      status: status
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    // Update local comment status
    comment.value.status = status;
    
    // Show success message
    alert(getStatusUpdateMessage(status));
  } catch (err) {
    console.error('Error updating comment status:', err);
    alert('خطایی در بروزرسانی وضعیت دیدگاه رخ داد. لطفا مجددا تلاش کنید.');
  }
};

// Get appropriate message for status update
const getStatusUpdateMessage = (status) => {
  switch (status) {
    case 'approved': return 'دیدگاه با موفقیت تایید شد.';
    case 'pending': return 'دیدگاه به حالت در انتظار بررسی برگشت.';
    case 'trashed': return 'دیدگاه به سطل زباله منتقل شد.';
    default: return 'وضعیت دیدگاه با موفقیت بروزرسانی شد.';
  }
};

// Confirm permanent deletion
const confirmDelete = () => {
  if (confirm('آیا از حذف دائمی این دیدگاه اطمینان دارید؟ این عملیات غیرقابل بازگشت است.')) {
    deleteComment();
  }
};

// Delete comment permanently
const deleteComment = async () => {
  try {
    const token = localStorage.getItem('admin_token');
    
    await axios.delete(`${API_URL}/api/admin/comments/${props.id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    // Show success message
    alert('دیدگاه با موفقیت حذف شد.');
    
    // Redirect back to comments list
    router.push('/admin/comments');
  } catch (err) {
    console.error('Error deleting comment:', err);
    alert('خطایی در حذف دیدگاه رخ داد. لطفا مجددا تلاش کنید.');
  }
};

// Submit admin reply
const submitReply = async () => {
  if (!replyContent.value.trim()) return;
  
  try {
    submitting.value = true;
    
    const token = localStorage.getItem('admin_token');
    
    const response = await axios.post(`${API_URL}/api/admin/comments/${props.id}/reply`, {
      content: replyContent.value
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    
    // Add the new reply to the list
    if (response.data && response.data.reply) {
      replies.value.unshift(response.data.reply);
    }
    
    // Clear input
    replyContent.value = '';
    
    // Show success message
    alert('پاسخ شما با موفقیت ارسال شد.');
  } catch (err) {
    console.error('Error submitting reply:', err);
    alert('خطایی در ارسال پاسخ رخ داد. لطفا مجددا تلاش کنید.');
  } finally {
    submitting.value = false;
  }
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

onMounted(() => {
  fetchComment();
});
</script> 