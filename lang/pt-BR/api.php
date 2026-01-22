<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Linhas de Linguagem para API
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de linguagem são utilizadas nas respostas da API.
    |
    */

    'validation_error' => 'Erro de validação',
    
    'auth' => [
        'login_success' => 'Login realizado com sucesso',
        'logout_success' => 'Logout realizado com sucesso',
        'register_success' => 'Usuário registrado com sucesso',
        'token_refresh_success' => 'Token atualizado com sucesso',
        'invalid_credentials' => 'As credenciais fornecidas não correspondem aos nossos registros',
        'invalid_token' => 'Token de atualização inválido',
        'email_already_verified' => 'E-mail já verificado',
        'verification_sent' => 'Link de verificação enviado',
        'email_verified' => 'E-mail verificado com sucesso',
        'invalid_verification' => 'Link de verificação inválido',
        'user_not_found' => 'Usuário não encontrado',
        'reset_link_sent' => 'Link de recuperação de senha enviado',
        'password_reset_success' => 'Senha redefinida com sucesso',
        'password_reset_error' => 'Não foi possível redefinir a senha. Tente novamente',
    ],

    'profile' => [
        'get_success' => 'Dados do perfil recuperados com sucesso',
        'update_success' => 'Perfil atualizado com sucesso',
        'update_error' => 'Falha ao atualizar perfil',
        'verification_code_sent' => 'Código de verificação enviado',
        'verification_success' => 'Telefone verificado com sucesso',
        'invalid_code' => 'Código de verificação inválido'
    ],
    
    'leads' => [
        'created_successfully' => 'Lead criado com sucesso',
        'failed_to_create' => 'Falha ao criar lead',
        'not_found' => 'Lead não encontrado',
        'updated_successfully' => 'Lead atualizado com sucesso',
        'failed_to_update' => 'Falha ao atualizar lead',
        'deleted_successfully' => 'Lead excluído com sucesso',
        'failed_to_delete' => 'Falha ao excluir lead'
    ],
    
    'notifications' => [
        'device_token_registered' => 'Token do dispositivo registrado com sucesso',
        'device_token_updated' => 'Token do dispositivo atualizado com sucesso',
        'device_token_removed' => 'Token do dispositivo removido com sucesso',
        'token_not_found' => 'Token não encontrado',
        'unauthorized' => 'Não autorizado',
        'validation_error' => 'Os dados fornecidos são inválidos',
        'notification_sent' => 'Notificação enviada para :count dispositivos com :failures falhas',
        'no_active_tokens' => 'Nenhum token de dispositivo ativo encontrado para este usuário',
        'error_sending_notification' => 'Erro ao enviar notificação'
    ]
]; 