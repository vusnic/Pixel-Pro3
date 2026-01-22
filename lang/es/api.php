<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Líneas de Lenguaje para API
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de lenguaje se utilizan en las respuestas de la API.
    |
    */

    'auth' => [
        'login_success' => '¡Inicio de sesión exitoso!',
        'logout_success' => '¡Cierre de sesión exitoso!',
        'register_success' => '¡Usuario registrado con éxito!',
        'token_refresh_success' => '¡Token actualizado con éxito!',
        'invalid_credentials' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        'invalid_token' => 'Token de actualización inválido',
        'email_already_verified' => 'El correo electrónico ya está verificado',
        'verification_sent' => '¡Enlace de verificación enviado!',
        'email_verified' => 'El correo electrónico ha sido verificado con éxito',
        'invalid_verification' => 'Enlace de verificación inválido',
        'user_not_found' => 'Usuario no encontrado',
        'reset_link_sent' => '¡Enlace de restablecimiento de contraseña enviado con éxito!',
        'password_reset_success' => '¡La contraseña ha sido restablecida con éxito!',
        'password_reset_error' => 'No se pudo restablecer la contraseña. Por favor, inténtelo de nuevo.',
    ],

    'notifications' => [
        'device_token_registered' => 'Token del dispositivo registrado con éxito',
        'device_token_updated' => 'Token del dispositivo actualizado con éxito',
        'device_token_removed' => 'Token del dispositivo eliminado con éxito',
        'token_not_found' => 'Token no encontrado',
        'unauthorized' => 'No autorizado',
        'validation_error' => 'Los datos proporcionados son inválidos',
        'notification_sent' => 'Notificación enviada a :count dispositivos con :failures fallos',
        'no_active_tokens' => 'No se encontraron tokens de dispositivo activos para este usuario',
        'error_sending_notification' => 'Error al enviar notificación'
    ],

    // Profile
    'profile_updated' => 'Perfil actualizado con éxito',
    'validation_error' => 'Error de validación',
    'verification_code_sent' => 'Código de verificación enviado',
    'invalid_verification_code' => 'Código de verificación inválido',
    'verification_code_expired' => 'Código de verificación expirado',
    'phone_verified' => 'Número de teléfono verificado con éxito',
]; 