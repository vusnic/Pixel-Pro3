/**
 * API Service - Centralizes all API calls
 */

// Gets the CSRF token from meta tag
const getCSRFToken = () => {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
};

// Default settings for fetch
const defaultOptions = {
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCSRFToken(),
        'Accept': 'application/json'
    }
};

/**
 * API Service for making HTTP calls
 */
const ApiService = {
    /**
     * Makes a GET request
     * @param {string} url - URL for the request
     * @param {Object} options - Additional options for fetch
     * @returns {Promise} - Promise with the request result
     */
    get: async (url, options = {}) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                ...defaultOptions,
                ...options
            });
            
            return await handleResponse(response);
        } catch (error) {
            console.error('Error in GET request:', error);
            throw error;
        }
    },
    
    /**
     * Makes a POST request
     * @param {string} url - URL for the request
     * @param {Object} data - Data to send in the request body
     * @param {Object} options - Additional options for fetch
     * @returns {Promise} - Promise with the request result
     */
    post: async (url, data, options = {}) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                ...defaultOptions,
                ...options,
                body: JSON.stringify(data)
            });
            
            return await handleResponse(response);
        } catch (error) {
            console.error('Error in POST request:', error);
            throw error;
        }
    },
    
    /**
     * Makes a PUT request
     * @param {string} url - URL for the request
     * @param {Object} data - Data to send in the request body
     * @param {Object} options - Additional options for fetch
     * @returns {Promise} - Promise with the request result
     */
    put: async (url, data, options = {}) => {
        try {
            const response = await fetch(url, {
                method: 'PUT',
                ...defaultOptions,
                ...options,
                body: JSON.stringify(data)
            });
            
            return await handleResponse(response);
        } catch (error) {
            console.error('Error in PUT request:', error);
            throw error;
        }
    },
    
    /**
     * Makes a DELETE request
     * @param {string} url - URL for the request
     * @param {Object} options - Additional options for fetch
     * @returns {Promise} - Promise with the request result
     */
    delete: async (url, options = {}) => {
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                ...defaultOptions,
                ...options
            });
            
            return await handleResponse(response);
        } catch (error) {
            console.error('Error in DELETE request:', error);
            throw error;
        }
    }
};

/**
 * Handles the request response
 * @param {Response} response - Fetch response object
 * @returns {Promise} - Promise with the response data
 */
const handleResponse = async (response) => {
    const data = await response.json();
    
    if (!response.ok) {
        const error = {
            status: response.status,
            message: data.message || 'An error occurred in the request',
            errors: data.errors || {}
        };
        
        throw error;
    }
    
    return data;
};

export default ApiService; 