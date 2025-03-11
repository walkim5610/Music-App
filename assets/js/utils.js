// Helper for AJAX requests
export const makeRequest = async (url, method = 'GET', data = null) => {
    try {
      const options = {
        method,
        headers: {
          'Content-Type': 'application/json',
        },
      };
  
      if (data) options.body = JSON.stringify(data);
  
      const response = await fetch(url, options);
      return await response.json();
    } catch (error) {
      console.error('Request failed:', error);
      return { success: false, error: error.message };
    }
  };
  
  // Session storage helpers
  export const storeInSession = (key, value) => {
    sessionStorage.setItem(key, JSON.stringify(value));
  };
  
  export const getFromSession = (key) => {
    return JSON.parse(sessionStorage.getItem(key));
  };