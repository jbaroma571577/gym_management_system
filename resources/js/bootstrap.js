import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Prefer JSON responses for SPA API calls
window.axios.defaults.headers.common['Accept'] = 'application/json';
// Ensure Laravel session cookies are sent with requests
window.axios.defaults.withCredentials = true;

// Pull CSRF token from meta tag if available
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
