/**
 * Service Service - Manages all service-related operations
 */
import ApiService from './api';

const BASE_URL = '/api/services';

/**
 * Service for services management
 */
const ServiceService = {
    /**
     * Gets all services
     * @param {Object} params - Parameters to filter results (status, featured, etc)
     * @returns {Promise} - Promise with the list of services
     */
    getServices: async (params = {}) => {
        try {
            let url = BASE_URL;
            
            // Add query parameters, if any
            if (Object.keys(params).length > 0) {
                const queryParams = new URLSearchParams();
                
                for (const key in params) {
                    if (params[key]) {
                        queryParams.append(key, params[key]);
                    }
                }
                
                url += `?${queryParams.toString()}`;
            }
            
            return await ApiService.get(url);
        } catch (error) {
            console.error('Error fetching services:', error);
            throw error;
        }
    },
    
    /**
     * Gets a specific service by ID
     * @param {number} id - Service ID
     * @returns {Promise} - Promise with the service data
     */
    getServiceById: async (id) => {
        try {
            return await ApiService.get(`${BASE_URL}/${id}`);
        } catch (error) {
            console.error(`Error fetching service #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Gets featured services
     * @returns {Promise} - Promise with the list of featured services
     */
    getFeaturedServices: async () => {
        try {
            return await ApiService.get(`${BASE_URL}/featured`);
        } catch (error) {
            console.error('Error fetching featured services:', error);
            throw error;
        }
    },
    
    /**
     * Creates a new service (requires authentication)
     * @param {Object} serviceData - Service data
     * @returns {Promise} - Promise with the operation result
     */
    createService: async (serviceData) => {
        try {
            // As this endpoint requires file upload, we'll use FormData
            const formData = new FormData();
            
            // Add text fields
            for (const key in serviceData) {
                if (key !== 'image' && serviceData[key] !== undefined) {
                    // If it's an array, iterate and add multiple values with the same name
                    if (Array.isArray(serviceData[key])) {
                        serviceData[key].forEach(item => {
                            if (item) formData.append(`${key}[]`, item);
                        });
                    } else {
                        formData.append(key, serviceData[key]);
                    }
                }
            }
            
            // Add image if provided
            if (serviceData.image instanceof File) {
                formData.append('image', serviceData.image);
            }
            
            // Configure options for file upload
            const options = {
                headers: {
                    // Remove Content-Type so browser sets correct boundary for multipart/form-data
                    'Content-Type': undefined
                }
            };
            
            return await ApiService.post(BASE_URL, formData, options);
        } catch (error) {
            console.error('Error creating service:', error);
            throw error;
        }
    },
    
    /**
     * Updates an existing service (requires authentication)
     * @param {number} id - Service ID
     * @param {Object} serviceData - Updated service data
     * @returns {Promise} - Promise with the operation result
     */
    updateService: async (id, serviceData) => {
        try {
            // As this endpoint requires file upload, we'll use FormData
            const formData = new FormData();
            
            // Add PUT method for update
            formData.append('_method', 'PUT');
            
            // Add text fields
            for (const key in serviceData) {
                if (key !== 'image' && serviceData[key] !== undefined) {
                    // If it's an array, iterate and add multiple values with the same name
                    if (Array.isArray(serviceData[key])) {
                        serviceData[key].forEach(item => {
                            if (item) formData.append(`${key}[]`, item);
                        });
                    } else {
                        formData.append(key, serviceData[key]);
                    }
                }
            }
            
            // Add image if provided
            if (serviceData.image instanceof File) {
                formData.append('image', serviceData.image);
            }
            
            // Configure options for file upload
            const options = {
                headers: {
                    // Remove Content-Type so browser sets correct boundary for multipart/form-data
                    'Content-Type': undefined
                }
            };
            
            return await ApiService.post(`${BASE_URL}/${id}`, formData, options);
        } catch (error) {
            console.error(`Error updating service #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Removes a service (requires authentication)
     * @param {number} id - Service ID
     * @returns {Promise} - Promise with the operation result
     */
    deleteService: async (id) => {
        try {
            return await ApiService.delete(`${BASE_URL}/${id}`);
        } catch (error) {
            console.error(`Error deleting service #${id}:`, error);
            throw error;
        }
    }
};

export default ServiceService;

 