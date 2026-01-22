<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in API responses.
    |
    */

    'validation_error' => 'Validation failed',

    'auth' => [
        'login_success' => 'Successfully logged in',
        'logout_success' => 'Successfully logged out',
        'register_success' => 'User registered successfully!',
        'token_refresh_success' => 'Token refreshed successfully!',
        'invalid_credentials' => 'The provided credentials are incorrect',
        'invalid_token' => 'Invalid refresh token',
        'email_already_verified' => 'Email already verified',
        'verification_sent' => 'Verification link sent',
        'email_verified' => 'Email successfully verified',
        'invalid_verification' => 'Invalid verification link',
        'user_not_found' => 'User not found',
        'reset_link_sent' => 'Password reset link sent',
        'password_reset_success' => 'Password has been reset successfully',
        'password_reset_error' => 'Could not reset the password. Please try again.',
    ],

    'notifications' => [
        'device_token_registered' => 'Device token registered successfully',
        'device_token_updated' => 'Device token updated successfully',
        'device_token_removed' => 'Device token removed successfully',
        'token_not_found' => 'Token not found',
        'unauthorized' => 'Unauthorized',
        'validation_error' => 'The provided data is invalid',
        'notification_sent' => 'Notification sent to :count devices with :failures failures',
        'no_active_tokens' => 'No active device tokens found for this user',
        'error_sending_notification' => 'Error sending notification'
    ],

    // Profile
    'profile' => [
        'get_success' => 'Profile data retrieved successfully',
        'update_success' => 'Profile updated successfully',
        'update_error' => 'Failed to update profile',
        'verification_code_sent' => 'Verification code sent',
        'verification_success' => 'Phone verified successfully',
        'invalid_code' => 'Invalid verification code'
    ],

    'leads' => [
        'created_successfully' => 'Lead created successfully',
        'failed_to_create' => 'Failed to create lead',
        'not_found' => 'Lead not found',
        'updated_successfully' => 'Lead updated successfully',
        'failed_to_update' => 'Failed to update lead',
        'deleted_successfully' => 'Lead deleted successfully',
        'failed_to_delete' => 'Failed to delete lead'
    ]
]; 