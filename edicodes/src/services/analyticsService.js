import axios from 'axios';

/**
 * Service for handling analytics-related API calls
 */
const analyticsService = {
  /**
   * Record a page view for a post
   * @param {number} postId - The ID of the post
   * @returns {Promise} - API response
   */
  recordPostView(postId) {
    return axios.post(`${import.meta.env.VITE_API_BASE_URL}/posts/${postId}/view`);
  },

  /**
   * Record a page view for a generic page (e.g., homepage, blog)
   * @param {string} path - The path of the page (e.g., '/', '/blog')
   * @returns {Promise} - API response
   */
  recordGenericPageView(path) {
    return axios.post(`${import.meta.env.VITE_API_BASE_URL}/page-view`, { path });
  }
};

export default analyticsService; 