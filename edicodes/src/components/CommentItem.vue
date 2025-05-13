<template>
  <div class="comment-item">
    <!-- Parent Comment -->
    <div :id="`comment-${comment.id}`" class="bg-black/20 rounded-lg p-4 border border-white/10">
      <div class="flex items-start mb-2">
        <div :class="[comment.is_admin ? 'bg-primary/20' : 'bg-white/10', 'w-10 h-10 rounded-full flex items-center justify-center ml-3']">
          <font-awesome-icon icon="user" :class="[comment.is_admin ? 'text-primary' : 'text-white/70']" />
        </div>
        <div>
          <div class="flex items-center">
            <h4 class="font-vazir text-white text-sm font-medium">
              {{ comment.name }}
              <span v-if="comment.is_admin" class="bg-primary/20 text-primary text-xs px-2 py-0.5 rounded-full mr-2">مدیر</span>
            </h4>
          </div>
          <span class="text-white/50 text-xs font-vazir">{{ formatDate(comment.created_at) }}</span>
        </div>
      </div>
      
      <div class="pr-13 mt-2">
        <p class="text-white/90 text-sm leading-relaxed font-vazir whitespace-pre-line">{{ comment.content }}</p>
      </div>
      
      <!-- Reply button -->
      <div class="mt-3 text-right">
        <button 
          v-if="!replyActive" 
          @click="replyActive = true" 
          class="text-xs text-primary hover:text-primary-light transition-colors duration-150 font-vazir flex items-center justify-end"
        >
          <font-awesome-icon icon="reply" class="ml-1" />
          پاسخ
        </button>
      </div>
      
      <!-- Reply form -->
      <div v-if="replyActive" class="mt-4 pt-4 border-t border-white/10">
        <CommentForm 
          :post-id="postId" 
          :parent-id="comment.id"
          :is-reply="true"
          @comment-submitted="handleReplySubmitted"
          @cancel="replyActive = false"
        />
      </div>
    </div>
    
    <!-- Child Comments (Replies) -->
    <div v-if="childComments.length > 0" class="mt-3 pr-6 space-y-3">
      <div 
        v-for="reply in childComments" 
        :key="reply.id" 
        :id="`comment-${reply.id}`" 
        class="bg-black/20 rounded-lg p-4 border border-white/10"
      >
        <div class="flex items-start mb-2">
          <div :class="[reply.is_admin ? 'bg-primary/20' : 'bg-white/10', 'w-8 h-8 rounded-full flex items-center justify-center ml-3']">
            <font-awesome-icon icon="user" :class="[reply.is_admin ? 'text-primary' : 'text-white/70']" />
          </div>
          <div>
            <div class="flex items-center">
              <h4 class="font-vazir text-white text-sm">
                {{ reply.name }}
                <span v-if="reply.is_admin" class="bg-primary/20 text-primary text-xs px-2 py-0.5 rounded-full mr-2">مدیر</span>
              </h4>
            </div>
            <span class="text-white/50 text-xs font-vazir">{{ formatDate(reply.created_at) }}</span>
          </div>
        </div>
        
        <div class="pr-11 mt-2">
          <p class="text-white/90 text-sm leading-relaxed font-vazir whitespace-pre-line">{{ reply.content }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import CommentForm from './CommentForm.vue';

const props = defineProps({
  comment: {
    type: Object,
    required: true
  },
  childComments: {
    type: Array,
    default: () => []
  },
  postId: {
    type: [Number, String],
    required: true
  }
});

const emit = defineEmits(['comment-submitted']);
const replyActive = ref(false);

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

const handleReplySubmitted = (comment) => {
  replyActive.value = false;
  emit('comment-submitted', comment);
};
</script> 