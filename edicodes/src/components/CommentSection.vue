<template>
  <div class="comments-section my-12">
    <h3 class="text-2xl font-bold text-white mb-6 font-vazir flex items-center">
      <font-awesome-icon icon="comments" class="ml-2 text-primary" />
      دیدگاه‌ها
      <span v-if="comments.length > 0" class="text-white/60 text-sm mr-2">({{ comments.length }})</span>
    </h3>

    <!-- Comment Form -->
    <div class="mb-8">
      <CommentForm 
        :post-id="postId" 
        @comment-submitted="handleNewComment" 
      />
      <p class="text-white/60 text-xs mt-2 font-vazir">
        دیدگاه شما پس از تایید مدیر نمایش داده خواهد شد.
      </p>
    </div>

    <!-- Comments List -->
    <div v-if="loading" class="flex justify-center py-8">
      <div class="w-8 h-8 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
    </div>

    <div v-else-if="comments.length === 0" class="text-center py-8 text-white/60 font-vazir">
      <font-awesome-icon icon="comment-slash" class="text-3xl mb-4 opacity-30" />
      <p>هنوز دیدگاهی برای این مطلب ثبت نشده است.</p>
      <p class="text-sm mt-2">اولین نفری باشید که دیدگاه خود را ثبت می‌کند!</p>
    </div>

    <div v-else class="space-y-6">
      <CommentItem 
        v-for="comment in parentComments" 
        :key="comment.id" 
        :comment="comment"
        :child-comments="getChildComments(comment.id)"
        :post-id="postId"
        @comment-submitted="handleNewComment"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import CommentForm from './CommentForm.vue';
import CommentItem from './CommentItem.vue';

const props = defineProps({
  postId: {
    type: [Number, String],
    required: true
  }
});

const comments = ref([]);
const loading = ref(true);

// Filter comments to get parent comments (no parent_id)
const parentComments = computed(() => {
  return comments.value.filter(comment => !comment.parent_id);
});

// Get child comments for a given parent
const getChildComments = (parentId) => {
  return comments.value.filter(comment => comment.parent_id === parentId);
};

// Fetch comments for the post
const fetchComments = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/api/posts/${props.postId}/comments`);
    comments.value = response.data.data || [];
  } catch (error) {
    console.error('Error fetching comments:', error);
  } finally {
    loading.value = false;
  }
};

// Handle new comment submission
const handleNewComment = (comment) => {
  if (comment && comment.data) {
    // Add new comment to the list if it's approved immediately
    // In most cases, this won't happen as comments need approval
    if (comment.data.is_approved) {
      comments.value.push(comment.data);
    }
  }
  
  // Show success message
  alert('دیدگاه شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
};

onMounted(() => {
  fetchComments();
});
</script> 