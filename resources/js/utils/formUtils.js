/**
 * Utilities for form handling
 */

/**
 * Validates a form
 * @param {HTMLFormElement} form - The form element
 * @param {Object} rules - Validation rules
 * @returns {boolean} - Returns true if the form is valid
 */
export const validateForm = (form, rules = {}) => {
    let isValid = true;
    const errors = {};
    
    // Clear previous error messages
    clearFormErrors(form);
    
    // Get all form fields
    const formData = new FormData(form);
    const formFields = Object.fromEntries(formData.entries());
    
    // Validate each field with provided rules
    for (const field in rules) {
        const value = formFields[field] || '';
        const fieldRules = rules[field];
        
        // Check required rule
        if (fieldRules.includes('required') && !value.trim()) {
            errors[field] = 'This field is required';
            isValid = false;
        }
        
        // Check email rule
        if (value.trim() && fieldRules.includes('email') && !validateEmail(value)) {
            errors[field] = 'Please enter a valid email';
            isValid = false;
        }
        
        // Check minLength rule
        const minLengthRule = fieldRules.find(rule => rule.startsWith('minLength:'));
        if (value.trim() && minLengthRule) {
            const minLength = parseInt(minLengthRule.split(':')[1]);
            if (value.length < minLength) {
                errors[field] = `This field must have at least ${minLength} characters`;
                isValid = false;
            }
        }
        
        // Check maxLength rule
        const maxLengthRule = fieldRules.find(rule => rule.startsWith('maxLength:'));
        if (value.trim() && maxLengthRule) {
            const maxLength = parseInt(maxLengthRule.split(':')[1]);
            if (value.length > maxLength) {
                errors[field] = `This field must have at most ${maxLength} characters`;
                isValid = false;
            }
        }
        
        // Check url rule
        if (value.trim() && fieldRules.includes('url') && !validateUrl(value)) {
            errors[field] = 'Please enter a valid URL';
            isValid = false;
        }
        
        // Check phone rule
        if (value.trim() && fieldRules.includes('phone') && !validatePhone(value)) {
            errors[field] = 'Please enter a valid phone number';
            isValid = false;
        }
    }
    
    // Display error messages
    displayFormErrors(form, errors);
    
    return isValid;
};

/**
 * Clears form error messages
 * @param {HTMLFormElement} form - The form element
 */
export const clearFormErrors = (form) => {
    // Remove error classes
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Clear error messages
    form.querySelectorAll('.invalid-feedback').forEach(el => {
        el.textContent = '';
    });
};

/**
 * Displays error messages in the form
 * @param {HTMLFormElement} form - The form element
 * @param {Object} errors - Object containing errors by field
 */
export const displayFormErrors = (form, errors) => {
    for (const field in errors) {
        const inputElement = form.querySelector(`[name="${field}"]`);
        const errorElement = form.querySelector(`#${field}-error`);
        
        if (inputElement && errorElement) {
            inputElement.classList.add('is-invalid');
            errorElement.textContent = errors[field];
        }
    }
};

/**
 * Handles form states during submission
 * @param {HTMLFormElement} form - The form element
 * @param {boolean} isLoading - Loading state
 * @param {string} defaultButtonText - Default submit button text
 * @param {string} loadingButtonText - Text displayed during loading
 */
export const handleFormState = (form, isLoading, defaultButtonText = 'Submit', loadingButtonText = 'Sending...') => {
    const submitButton = form.querySelector('button[type="submit"]');
    
    if (!submitButton) return;
    
    if (isLoading) {
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            ${loadingButtonText}
        `;
    } else {
        submitButton.disabled = false;
        submitButton.innerHTML = defaultButtonText;
    }
};

/**
 * Displays a form feedback message
 * @param {HTMLElement} messageElement - Element to display the message
 * @param {string} message - Message to be displayed
 * @param {string} type - Message type ('success' or 'error')
 * @param {number} duration - Duration in milliseconds to hide the message (0 to not hide)
 */
export const showFormMessage = (messageElement, message, type = 'success', duration = 5000) => {
    messageElement.textContent = message;
    messageElement.classList.remove('d-none', 'alert-success', 'alert-danger');
    messageElement.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
    
    if (duration > 0) {
        setTimeout(() => {
            messageElement.classList.add('d-none');
        }, duration);
    }
};

/**
 * Validates an email address
 * @param {string} email - Email to be validated
 * @returns {boolean} - Returns true if the email is valid
 */
export const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
};

/**
 * Validates a URL
 * @param {string} url - URL to be validated
 * @returns {boolean} - Returns true if the URL is valid
 */
export const validateUrl = (url) => {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
};

/**
 * Validates a phone number
 * @param {string} phone - Phone number to be validated
 * @returns {boolean} - Returns true if the phone is valid
 */
export const validatePhone = (phone) => {
    // Remove non-numeric characters
    const cleanPhone = phone.replace(/\D/g, '');
    // Check if it has at least 8 digits
    return cleanPhone.length >= 8;
};

/**
 * Converts a form to a JavaScript object
 * @param {HTMLFormElement} form - The form element
 * @returns {Object} - Object with form data
 */
export const formToObject = (form) => {
    const formData = new FormData(form);
    return Object.fromEntries(formData.entries());
}; 