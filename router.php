<?php
declare(strict_types=1);

/**
 * Router solo para el servidor embebido de PHP (`php -S localhost:8891 router.php`).
 * Apache en Hostinger usa .htaccess. Este archivo responde 404 si se abre por el sitio.
 */
if (PHP_SAPI !== 'cli-server') {
    http_response_code(404);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = is_string($uri) ? $uri : '/';
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    $blocked = preg_match('#^/(?:data|includes)(?:/|$)#', $uri) === 1
        || preg_match('#/(?:config\.php|router\.php)$#', $uri) === 1
        || preg_match('#\.(?:sqlite|sqlite-journal|sqlite-wal|sqlite-shm|log)$#', $uri) === 1;
    if ($blocked) {
        http_response_code(403);
        echo 'Forbidden';
        return true;
    }
    return false;
}

if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    return true;
}

if ($uri === '/sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    return true;
}

if (preg_match('#^/(servicios|guias)/?$#', $uri, $m) === 1) {
    $_GET['tipo'] = $m[1];
    require __DIR__ . '/hub.php';
    return true;
}

if ($uri === '/instaladores' || $uri === '/instaladores/') {
    require __DIR__ . '/instaladores.php';
    return true;
}

if (preg_match('#^/(net-billing-chile|kit-solar-off-grid-parcelas|bombeo-solar-agricola|paneles-solares-empresas)/?$#', $uri, $m) === 1) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/silo.php';
    return true;
}

if (preg_match('#^/guias/([a-z0-9-]+)/?$#', $uri, $m) === 1) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/guia.php';
    return true;
}

if (preg_match('#^/paneles-solares-([a-z0-9-]+)/?$#', $uri, $m) === 1) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/comuna.php';
    return true;
}

if ($uri === '/panel' || $uri === '/panel/') {
    require __DIR__ . '/panel/index.php';
    return true;
}

http_response_code(404);
require __DIR__ . '/404.php';
return true;
