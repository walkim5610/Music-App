import { makeRequest } from './utils.js';

export const setupFormHandlers = () => {
  // Login/Register Form Validation
  document.querySelectorAll('.auth-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const formData = new FormData(form);
      const response = await makeRequest('api/auth.php', 'POST', Object.fromEntries(formData));

      if (response.success) {
        window.location.href = 'index.php';
      } else {
        alert(response.error || 'Authentication failed');
      }
    });
  });

  // Song Upload Form
  const uploadForm = document.querySelector('#uploadForm');
  if (uploadForm) {
    uploadForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const formData = new FormData(uploadForm);
      const response = await fetch('api/upload.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        window.location.reload();
      } else {
        alert(result.error || 'Upload failed');
      }
    });
  }
};