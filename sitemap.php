<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');
header('Cache-Control: public, max-age=3600');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (sitemap_entries() as $entry) {
    $loc = absolute_url((string) $entry['loc']);
    $lastmod = e((string) $entry['lastmod']);
    $priority = e((string) $entry['priority']);
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
    echo "    <lastmod>{$lastmod}</lastmod>\n";
    echo "    <changefreq>monthly</changefreq>\n";
    echo "    <priority>{$priority}</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>';
