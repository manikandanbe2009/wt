<?php
require_once __DIR__ . '/config.php';

function app_base_url(): string
{
    $host = trim((string) ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    $https = $_SERVER['HTTPS'] ?? '';
    $scheme = ($https !== '' && $https !== 'off') ? 'https' : 'http';

    return $scheme . '://' . $host;
}

function app_canonical_url(string $path = ''): string
{
    $normalizedPath = '/' . ltrim($path, '/');

    return app_base_url() . $normalizedPath;
}

function app_seo_render(array $page): void
{
    $title = (string) ($page['title'] ?? 'White Call Taxi');
    $description = (string) ($page['description'] ?? 'White Call Taxi offers safe, reliable taxi service for airport, city, outstation and corporate rides.');
    $path = (string) ($page['path'] ?? '/');
    $robots = (string) ($page['robots'] ?? 'index, follow');
    $image = (string) ($page['image'] ?? 'images/logo.png');
    $type = (string) ($page['type'] ?? 'website');
    $headline = (string) ($page['headline'] ?? $title);
    $schemaType = (string) ($page['schema_type'] ?? 'WebPage');
    $serviceName = (string) ($page['service_name'] ?? 'Taxi Service');
    $canonical = app_canonical_url($path);
    $imageUrl = str_starts_with($image, 'http') ? $image : app_canonical_url($image);
    $phone = env_value('BUSINESS_PHONE', '+91 12345 67890');
    $email = env_value('BUSINESS_EMAIL', 'info@whitecalltaxi.com');

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'TaxiService',
                '@id' => app_canonical_url('/#organization'),
                'name' => 'White Call Taxi',
                'url' => app_base_url() . '/',
                'image' => $imageUrl,
                'telephone' => $phone,
                'email' => $email,
                'priceRange' => '$$',
                'areaServed' => [
                    '@type' => 'Place',
                    'name' => 'India',
                ],
                'serviceType' => [
                    'Airport Taxi',
                    'Outstation Taxi',
                    'City Taxi',
                    'Corporate Taxi',
                ],
            ],
            [
                '@type' => $schemaType,
                '@id' => $canonical . '#webpage',
                'url' => $canonical,
                'name' => $title,
                'headline' => $headline,
                'description' => $description,
                'isPartOf' => [
                    '@id' => app_base_url() . '/#website',
                ],
                'about' => [
                    '@id' => app_canonical_url('/#organization'),
                ],
                'primaryImageOfPage' => $imageUrl,
            ],
            [
                '@type' => 'WebSite',
                '@id' => app_base_url() . '/#website',
                'url' => app_base_url() . '/',
                'name' => 'White Call Taxi',
                'publisher' => [
                    '@id' => app_canonical_url('/#organization'),
                ],
            ],
        ],
    ];

    if ($schemaType === 'Service') {
        $schema['@graph'][] = [
            '@type' => 'Service',
            'name' => $serviceName,
            'provider' => [
                '@id' => app_canonical_url('/#organization'),
            ],
            'areaServed' => 'India',
            'description' => $description,
            'url' => $canonical,
        ];
    }
    ?>
  <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="robots" content="<?= htmlspecialchars($robots, ENT_QUOTES, 'UTF-8') ?>">
  <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:site_name" content="White Call Taxi">
  <meta property="og:type" content="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>">
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <?php
}
