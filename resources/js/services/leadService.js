/**
 * Lead Service - Manages all lead-related operations
 */
import ApiService from './api';

const BASE_URL = '/api/leads';

/**
 * Service for lead management
 */
const LeadService = {
    /**
     * Creates a new lead
     * @param {Object} leadData - Lead data
     * @returns {Promise} - Promise with the operation result
     */
    createLead: async (leadData) => {
        try {
            const response = await ApiService.post(BASE_URL, leadData);
            return response.data;
        } catch (error) {
            console.error('Error creating lead:', error);
            throw error;
        }
    },
    
    /**
     * Gets the list of leads (requires authentication)
     * @param {Object} filters - Search filters (status, source, search, etc)
     * @param {number} page - Page number for pagination
     * @returns {Promise} - Promise with the list of leads
     */
    getLeads: async (filters = {}, page = 1) => {
        try {
            let queryParams = `page=${page}`;
            
            // Add filters to query string
            Object.keys(filters).forEach(key => {
                if (filters[key]) {
                    queryParams += `&${key}=${encodeURIComponent(filters[key])}`;
                }
            });
            
            const response = await ApiService.get(`${BASE_URL}?${queryParams}`);
            return response.data.data;
        } catch (error) {
            console.error('Error fetching leads:', error);
            throw error;
        }
    },
    
    /**
     * Gets a specific lead by ID (requires authentication)
     * @param {number} id - Lead ID
     * @returns {Promise} - Promise with the lead data
     */
    getLeadById: async (id) => {
        try {
            const response = await ApiService.get(`${BASE_URL}/${id}`);
            return response.data.data;
        } catch (error) {
            console.error(`Error fetching lead #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Updates a lead's status (requires authentication)
     * @param {number} id - Lead ID
     * @param {string} status - New status ('new', 'contacted', 'qualified', 'converted', 'closed')
     * @returns {Promise} - Promise with the operation result
     */
    updateLeadStatus: async (id, status) => {
        try {
            const response = await ApiService.put(`${BASE_URL}/${id}`, { status });
            return response.data.data;
        } catch (error) {
            console.error(`Error updating lead #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Removes a lead (requires authentication)
     * @param {number} id - Lead ID
     * @returns {Promise} - Promise with the operation result
     */
    deleteLead: async (id) => {
        try {
            const response = await ApiService.delete(`${BASE_URL}/${id}`);
            return response.data;
        } catch (error) {
            console.error(`Error deleting lead #${id}:`, error);
            throw error;
        }
    },
    
    /**
     * Gets lead statistics (requires authentication)
     * @returns {Promise} - Promise with lead statistics
     */
    getLeadStats: async () => {
        try {
            const response = await ApiService.get('/api/leads-stats');
            return response.data.data;
        } catch (error) {
            console.error('Error fetching lead statistics:', error);
            throw error;
        }
    }
};

export default LeadService; 