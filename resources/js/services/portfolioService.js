/**
 * Portfolio Service - Manages all portfolio-related operations
 */
import ApiService from './api';

const BASE_URL = '/api/portfolios';

/**
 * Service for portfolio management
 */
const PortfolioService = {
    /**
     * Gets all portfolio projects
     * @param {Object} params - Parameters to filter results (category, etc)
     * @returns {Promise} - Promise with the list of projects
     */
    getPortfolios: async (params = {}) => {
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
            console.error('Error fetching portfolio projects:', error);
            throw error;
        }
    },
    
    /**
     * Gets a specific portfolio project by ID
     * @param {number} id - Project ID
     * @returns {Promise} - Promise with the project data
     */
    getPortfolioById: async (id) => {
        try {
            return await ApiService.get(`${BASE_URL}/${id}`);
        } catch (error) {
            console.error(`Error fetching project #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Gets all available portfolio categories
     * @returns {Promise} - Promise with the list of categories
     */
    getCategories: async () => {
        try {
            return await ApiService.get(`${BASE_URL}/categories`);
        } catch (error) {
            console.error('Error fetching portfolio categories:', error);
            throw error;
        }
    },
    
    /**
     * Creates a new portfolio project (requires authentication)
     * @param {Object} portfolioData - Project data
     * @returns {Promise} - Promise with the operation result
     */
    createPortfolio: async (portfolioData) => {
        try {
            // As this endpoint requires file upload, we'll use FormData
            const formData = new FormData();
            
            // Add text fields
            for (const key in portfolioData) {
                if (key !== 'image' && portfolioData[key] !== undefined) {
                    formData.append(key, portfolioData[key]);
                }
            }
            
            // Add image if provided
            if (portfolioData.image instanceof File) {
                formData.append('image', portfolioData.image);
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
            console.error('Error creating portfolio project:', error);
            throw error;
        }
    },
    
    /**
     * Updates a portfolio project (requires authentication)
     * @param {number} id - Project ID
     * @param {Object} portfolioData - Updated project data
     * @returns {Promise} - Promise with the operation result
     */
    updatePortfolio: async (id, portfolioData) => {
        try {
            // As this endpoint requires file upload, we'll use FormData
            const formData = new FormData();
            
            // Add PUT method for update
            formData.append('_method', 'PUT');
            
            // Add text fields
            for (const key in portfolioData) {
                if (key !== 'image' && portfolioData[key] !== undefined) {
                    formData.append(key, portfolioData[key]);
                }
            }
            
            // Add image if provided
            if (portfolioData.image instanceof File) {
                formData.append('image', portfolioData.image);
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
            console.error(`Error updating project #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Removes a portfolio project (requires authentication)
     * @param {number} id - Project ID
     * @returns {Promise} - Promise with the operation result
     */
    deletePortfolio: async (id) => {
        try {
            return await ApiService.delete(`${BASE_URL}/${id}`);
        } catch (error) {
            console.error(`Error deleting project #${id}:`, error);
            throw error;
        }
    }
};

export default PortfolioService; 