<?php
declare(strict_types=1);

/**
 * Configuración central de Panel Solar Norte.
 *
 * Credenciales de prueba del /panel (cámbialas antes de producción):
 *   admin  / PsnAdmin2026!     → todas las comunas, KPIs y CSV
 *   elqui  / InstElqui2026!    → La Serena, Coquimbo, Ovalle (+ satélites)
 *   huasco / InstHuasco2026!   → Copiapó, Vallenar (+ satélites)
 *
 * Plazas Rank & Rent: un solo arrendatario por zona. Si estado = vacante,
 * WhatsApp y alertas caen al número/email de administración.
 */
if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'config.php') {
    http_response_code(403);
    exit;
}

return [
    'site_name' => 'Panel Solar Norte',
    'base_url' => 'https://panelsolarnorte.cl',
    // Por ahora un solo destino: alertas del formulario.
    'alert_email' => 'zerobit@outlook.com',
    'from_email' => 'no-reply@panelsolarnorte.cl',
    // Fallback global (plaza vacante o comuna sin mapear). Solo dígitos con código de país.
    'whatsapp' => '56911111111',
    'ip_salt' => '7c1f9a4e2b80d6a13f55c0e8b4d27a91e6c3f08b5d1a7e42',
    /**
     * Plazas exclusivas. Cada comuna madre (y sus satélites) cae en una plaza.
     * estado: activa | vacante
     */
    'plazas' => [
        'elqui' => [
            'nombre' => 'Elqui y Costa (La Serena / Coquimbo)',
            'comunas_madre' => ['la-serena', 'coquimbo'],
            'estado' => 'activa',
            'arrendatario_nombre' => 'Instalador Elqui',
            'whatsapp' => '56911111111',
            'email' => '',
            'user' => 'elqui',
        ],
        'limari' => [
            'nombre' => 'Limarí (Ovalle)',
            'comunas_madre' => ['ovalle'],
            'estado' => 'vacante',
            'arrendatario_nombre' => '',
            'whatsapp' => '',
            'email' => '',
            'user' => '',
        ],
        'atacama' => [
            'nombre' => 'Atacama (Copiapó / Vallenar)',
            'comunas_madre' => ['copiapo', 'vallenar'],
            'estado' => 'activa',
            'arrendatario_nombre' => 'Instalador Huasco',
            'whatsapp' => '56911111111',
            'email' => '',
            'user' => 'huasco',
        ],
    ],
    'users' => [
        'admin' => [
            'password_hash' => '$2y$12$hVSliwJes.KT8ij5odVPlO.2c3NwID9HPjMJh/W95hNUm6amCijrW',
            'role' => 'admin',
            'name' => 'Administración',
            'email' => 'zerobit@outlook.com',
            'zonas' => ['la-serena', 'coquimbo', 'ovalle', 'copiapo', 'vallenar'],
        ],
        'elqui' => [
            'password_hash' => '$2y$12$ozj5sWy0pju4V7dwQh7OX.6xAFQi.KREarLXl5eEXGRzyUQYYKujK',
            'role' => 'instalador',
            'name' => 'Instalador Elqui',
            'email' => '',
            'zonas' => ['la-serena', 'coquimbo'],
            'plaza' => 'elqui',
        ],
        'huasco' => [
            'password_hash' => '$2y$12$PZ.BZFj8d6ysCBhBH52GneXwbgkbrgfYxINgDEelVRbgvAkFt0iSO',
            'role' => 'instalador',
            'name' => 'Instalador Huasco',
            'email' => '',
            'zonas' => ['copiapo', 'vallenar'],
            'plaza' => 'atacama',
        ],
    ],
];
