<?php
// app/Config/modules.php

return [
    'modules' => [
        'logs' => true,          // Sistema de logs
        'notificacoes' => true,  // Sistema de notificações
        'backup' => true,        // Sistema de backup
        'api' => false,          // API REST
        'export' => true,        // Exportação (PDF/Excel)
        'uploads' => true,       // Sistema de upload
        'auditoria' => true,     // Auditoria de ações
        'acessibilidade' => true, // Menu: tema escuro, tamanho do texto, cores p/ daltônicos, contraste
        'vlibras' => true,       // Tradutor de Libras do Governo Federal (vlibras.gov.br)
        'login_google' => true,  // Botão "Entrar com Google" (configure GOOGLE_CLIENT_ID/SECRET no .env)
    ],
    'custom_modules' => [
        // Adicione seus módulos personalizados aqui
        // Ex: 'clientes' => true,
    ],
];