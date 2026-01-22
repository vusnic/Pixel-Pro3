/**
 * LeadForm Component - Manages lead capture forms
 */
import LeadService from '../services/leadService';
import { validateForm, handleFormState, showFormMessage, formToObject } from '../utils/formUtils';

/**
 * Class to manage lead forms
 */
class LeadForm {
    /**
     * Initializes the lead form
     * @param {string} formId - Form element ID
     * @param {Object} options - Configuration options
     */
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        
        if (!this.form) {
            console.error(`Form #${formId} not found`);
            return;
        }
        
        this.options = {
            successMessage: 'Thank you for your interest! We will contact you soon.',
            errorMessage: 'An error occurred while submitting the form. Please try again.',
            validationRules: {
                name: ['required'],
                email: ['required', 'email'],
                phone: ['phone']
            },
            submitButtonDefaultText: 'Submit',
            submitButtonLoadingText: 'Sending...',
            ...options
        };
        
        this.submitButton = this.form.querySelector('button[type="submit"]');
        this.messageElement = document.getElementById(`${formId}-success`) || document.getElementById('form-success');
        
        this.setupEventListeners();
    }
    
    /**
     * Sets up event listeners
     */
    setupEventListeners() {
        // Add submit event to the form
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }
    
    /**
     * Handles form submission
     * @param {Event} e - Submission event
     */
    async handleSubmit(e) {
        e.preventDefault();
        
        // Validate the form
        const isValid = validateForm(this.form, this.options.validationRules);
        
        if (!isValid) {
            return;
        }
        
        // Show loading state
        handleFormState(
            this.form, 
            true, 
            this.options.submitButtonDefaultText, 
            this.options.submitButtonLoadingText
        );
        
        try {
            // Convert form to object
            const data = formToObject(this.form);
            
            // Send data to server
            const response = await LeadService.createLead(data);
            
            // Clear form
            this.form.reset();
            
            // Show success message
            showFormMessage(
                this.messageElement,
                this.options.successMessage,
                'success',
                5000
            );
            
            // Dispatch custom success event
            this.form.dispatchEvent(new CustomEvent('leadFormSuccess', { 
                detail: { response, data } 
            }));
            
            // Add tracking
            this.trackFormSubmission(data);
            
        } catch (error) {
            console.error('Error submitting form:', error);
            
            // Show validation errors
            if (error.errors) {
                for (const field in error.errors) {
                    const errorElement = document.getElementById(`${field}-error`);
                    if (errorElement) {
                        // Force English error messages
                        let errorMsg = error.errors[field][0] || error.errors[field];
                        
                        // Override Portuguese error messages with English ones
                        if (errorMsg.includes('obrigatório')) {
                            errorMsg = 'This field is required';
                        } else if (errorMsg.includes('endereço de e-mail válido')) {
                            errorMsg = 'Please enter a valid email address';
                        } else if (errorMsg.includes('número de telefone válido')) {
                            errorMsg = 'Please enter a valid phone number';
                        }
                        
                        errorElement.textContent = errorMsg;
                        const inputElement = this.form.querySelector(`[name="${field}"]`);
                        if (inputElement) {
                            inputElement.classList.add('is-invalid');
                        }
                    }
                }
            } else {
                // Show general error message
                showFormMessage(
                    this.messageElement,
                    this.options.errorMessage,
                    'error',
                    5000
                );
            }
            
            // Dispatch custom error event
            this.form.dispatchEvent(new CustomEvent('leadFormError', { 
                detail: { error } 
            }));
        } finally {
            // Restore button state
            handleFormState(
                this.form, 
                false, 
                this.options.submitButtonDefaultText
            );
        }
    }
    
    /**
     * Adds tracking for analytics
     * @param {Object} data - Form data
     */
    trackFormSubmission(data) {
        // Google Analytics (if available)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'lead_submission', {
                'event_category': 'Leads',
                'event_label': data.source || 'website'
            });
        }
        
        // Facebook Pixel (if available)
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Lead', {
                source: data.source || 'website'
            });
        }
    }
}

export default LeadForm; 