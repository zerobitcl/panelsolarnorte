<?php
declare(strict_types=1);
/** @var array $page */
if (!isset($page) || !is_array($page)) {
    http_response_code(500);
    exit;
}
$robots = (string) ($page['robots'] ?? 'index, follow');
$noindex = stripos($robots, 'noindex') !== false;
$canonical = absolute_url((string) ($page['path'] ?? '/'));
$title = (string) $page['title'];
$description = (string) $page['description'];
$ogImage = absolute_url((string) ($page['og_image'] ?? '/assets/img/casa-paneles.jpg'));
?>
<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0F172A">
  <meta name="format-detection" content="telephone=no">
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>">
  <meta name="robots" content="<?= e($robots) ?>">
  <?php if (!$noindex): ?>
  <link rel="canonical" href="<?= e($canonical) ?>">
  <link rel="alternate" hreflang="es-CL" href="<?= e($canonical) ?>">
  <?php endif; ?>
  <meta property="og:locale" content="es_CL">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Panel Solar Norte">
  <meta property="og:title" content="<?= e($title) ?>">
  <meta property="og:description" content="<?= e($description) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e($ogImage) ?>">
  <meta property="og:image:alt" content="Panel Solar Norte — Energía del Norte Chico">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($title) ?>">
  <meta name="twitter:description" content="<?= e($description) ?>">
  <meta name="twitter:image" content="<?= e($ogImage) ?>">
  <link rel="icon" href="/assets/img/logo-icon.jpg" type="image/jpeg">
  <link rel="apple-touch-icon" href="/assets/img/logo-icon.jpg">
  <link rel="stylesheet" href="/assets/css/styles.css?v=11">
  <?php if (!empty($page['schema']) && is_array($page['schema'])): ?>
    <?= json_ld($page['schema']) ?>
  <?php endif; ?>
</head>
<?php
$bodyClass = [];
if (!empty($page['dock'])) {
    $bodyClass[] = 'has-dock';
}
$pageTipo = (string) ($page['page_tipo'] ?? 'web');
?>
<body<?= $bodyClass !== [] ? ' class="' . e(implode(' ', $bodyClass)) . '"' : '' ?> data-page-tipo="<?= e($pageTipo) ?>">
