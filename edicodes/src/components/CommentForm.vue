<template>
  <form @submit.prevent="submitComment" class="space-y-4">
    <div v-if="!isReply" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="name" class="block text-white/70 text-sm font-vazir mb-1">نام شما <span class="text-red-500">*</span></label>
        <input 
          type="text" 
          id="name" 
          v-model="formData.name" 
          class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
          :class="{'border-red-500': errors.name}"
          required
        >
        <div v-if="errors.name" class="text-red-500 text-xs mt-1 font-vazir">{{ errors.name }}</div>
      </div>
      
      <div>
        <label for="email" class="block text-white/70 text-sm font-vazir mb-1">ایمیل شما <span class="text-red-500">*</span></label>
        <input 
          type="email" 
          id="email" 
          v-model="formData.email" 
          class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
          :class="{'border-red-500': errors.email}"
          required
        >
        <div v-if="errors.email" class="text-red-500 text-xs mt-1 font-vazir">{{ errors.email }}</div>
      </div>
    </div>
    
    <div>
      <label for="content" class="block text-white/70 text-sm font-vazir mb-1">دیدگاه شما <span class="text-red-500">*</span></label>
      <textarea 
        id="content" 
        v-model="formData.content" 
        rows="4" 
        class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
        :class="{'border-red-500': errors.content}"
        required
      ></textarea>
      <div v-if="errors.content" class="text-red-500 text-xs mt-1 font-vazir">{{ errors.content }}</div>
    </div>
    
    <div class="flex justify-end space-x-3 space-x-reverse">
      <button 
        v-if="isReply" 
        type="button" 
        @click="$emit('cancel')" 
        class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white/70 rounded-lg transition-colors duration-150 text-sm font-vazir"
      >
        انصراف
      </button>
      
      <button 
        type="submit" 
        :disabled="submitting" 
        class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-150 text-sm font-vazir flex items-center"
      >
        <span v-if="submitting" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin ml-2"></span>
        <font-awesome-icon v-else icon="paper-plane" class="ml-2" />
        {{ isReply ? 'ارسال پاسخ' : 'ارسال دیدگاه' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  postId: {
    type: [Number, String],
    required: true
  },
  parentId: {
    type: [Number, String],
    default: null
  },
  isReply: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['comment-submitted', 'cancel']);

const formData = ref({
  name: '',
  email: '',
  content: '',
  post_id: props.postId,
  parent_id: props.parentId
});

const submitting = ref(false);
const errors = ref({});

const submitComment = async () => {
  // Reset errors
  errors.value = {};
  
  // Basic validation
  if (!formData.value.content.trim()) {
    errors.value.content = 'لطفا دیدگاه خود را وارد کنید';
    return;
  }
  
  if (!props.isReply) {
    if (!formData.value.name.trim()) {
      errors.value.name = 'لطفا نام خود را وارد کنید';
      return;
    }
    
    if (!formData.value.email.trim() || !validateEmail(formData.value.email)) {
      errors.value.email = 'لطفا ایمیل معتبر وارد کنید';
      return;
    }
  }
  
  try {
    submitting.value = true;
    
    const response = await axios.post(`${import.meta.env.VITE_API_BASE_URL}/api/comments`, {
      post_id: props.postId,
      parent_id: props.parentId,
      name: formData.value.name,
      email: formData.value.email,
      content: formData.value.content
    });
    
    // Clear form
    formData.value.content = '';
    if (!props.isReply) {
      formData.value.name = '';
      formData.value.email = '';
    }
    
    // Emit event to parent
    emit('comment-submitted', response.data);
  } catch (error) {
    console.error('Error submitting comment:', error);
    
    // Handle validation errors from the server
    if (error.response && error.response.status === 422 && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      alert('خطایی در ثبت دیدگاه رخ داد. لطفا دوباره تلاش کنید.');
    }
  } finally {
    submitting.value = false;
  }
};

const validateEmail = (email) => {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};
</script> 