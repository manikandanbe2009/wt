<?php
header("Content-Type: application/xml; charset=utf-8");
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/route-data.php';

$baseUrl = app_base_url();

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/', ENT_XML1) ?></loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/services.php', ENT_XML1) ?></loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/fleet.php', ENT_XML1) ?></loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/about.php', ENT_XML1) ?></loc>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/pricing.php', ENT_XML1) ?></loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/contact.php', ENT_XML1) ?></loc>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <?php
  $routes = array_merge(
      app_route_pages(),
      app_route_chennai_pages(),
      app_route_airport_pages()
  );
  foreach ($routes as $slug => $route):
      $path = $slug . '.php';
  ?>
  <url>
    <loc><?= htmlspecialchars($baseUrl . '/' . $path, ENT_XML1) ?></loc>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  <?php endforeach; ?>
</urlset>
