<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/route-data.php';

$todayDate = date('Y-m-d');
$selectedRoute = isset($selectedRoute) && is_array($selectedRoute) ? $selectedRoute : null;

$defaultBookingData = [
    'trip_type' => 'one-way',
    'name' => '',
    'mobile' => '',
    'email' => '',
    'trip_days' => '',
    'pickup' => $selectedRoute['pickup'] ?? '',
    'drop' => $selectedRoute['drop'] ?? '',
    'distance_km' => '',
    'date' => $todayDate,
    'time' => '10:00',
    'cabtype' => '',
];
$bookingStatus = false;
$bookingData = $defaultBookingData;
$bookingErrors = [];
$bookingSuccess = '';
$estimationResults = [];
$googleMapsApiKey = env_value('GOOGLE_MAPS_API_KEY');
$carRateTable = app_rate_table();
$rateTableJson = htmlspecialchars(json_encode($carRateTable, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');

function booking_value(array $data, string $key): string
{
    return htmlspecialchars((string) ($data[$key] ?? ''), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($bookingData as $key => $defaultValue) {
        if (isset($_POST[$key])) {
            $bookingData[$key] = trim((string) $_POST[$key]);
        }
    }

    if (!in_array($bookingData['trip_type'], ['one-way', 'two-way'], true)) {
        $bookingErrors['trip_type'] = 'Select a valid trip type.';
    }
    if ($bookingData['name'] === '') {
        $bookingErrors['name'] = 'Enter your name.';
    }
    if (!preg_match('/^[6-9][0-9]{9}$/', $bookingData['mobile'])) {
        $bookingErrors['mobile'] = 'Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.';
    }
    if ($bookingData['email'] !== '' && !filter_var($bookingData['email'], FILTER_VALIDATE_EMAIL)) {
        $bookingErrors['email'] = 'Enter a valid email address.';
    }
    if ($bookingData['trip_type'] === 'two-way') {
        if ($bookingData['trip_days'] === '') {
            $bookingErrors['trip_days'] = 'Enter the number of days for the round trip.';
        } elseif (filter_var($bookingData['trip_days'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 30]]) === false) {
            $bookingErrors['trip_days'] = 'Days must be between 1 and 30.';
        }
    }
    if ($bookingData['pickup'] === '') {
        $bookingErrors['pickup'] = 'Enter the pickup location.';
    }
    if ($bookingData['drop'] === '') {
        $bookingErrors['drop'] = 'Enter the drop location.';
    }
    if ($bookingData['distance_km'] === '') {
        $bookingErrors['distance_km'] = 'Enter the travel distance in kilometers.';
    } elseif (!is_numeric($bookingData['distance_km']) || (float) $bookingData['distance_km'] <= 0) {
        $bookingErrors['distance_km'] = 'Distance must be greater than 0 km.';
    }
    if ($bookingData['date'] === '') {
        $bookingErrors['date'] = 'Select a date.';
    } elseif ($bookingData['date'] < $todayDate) {
        $bookingErrors['date'] = 'Past dates are not allowed.';
    }
    if ($bookingData['time'] === '') {
        $bookingErrors['time'] = 'Select a time.';
    }
    if ($bookingData['cabtype'] === '') {
        $bookingErrors['cabtype'] = 'Select a cab type.';
    } elseif (!array_key_exists($bookingData['cabtype'], $carRateTable)) {
        $bookingErrors['cabtype'] = 'Select a valid cab type.';
    }

    if (!$bookingErrors) {
        $distanceKm = (float) $bookingData['distance_km'];
        $tripDays   = $bookingData['trip_type'] === 'two-way' ? max(1, (int) $bookingData['trip_days']) : 1;

        $vehiclesToEstimate = [
            $bookingData['cabtype'] => $carRateTable[$bookingData['cabtype']],
        ];

        foreach ($vehiclesToEstimate as $vehicleName => $rateInfo) {
            $travelDistance  = $bookingData['trip_type'] === 'two-way' ? $distanceKm * 2 : $distanceKm;
            $minBaseKm       = $bookingData['trip_type'] === 'two-way' ? 250 * $tripDays : 130;
            $perKmValue      = $bookingData['trip_type'] === 'two-way' ? $rateInfo['round_trip_per_km'] : $rateInfo['one_way_per_km'];
            $baseFareValue   = $minBaseKm * $perKmValue;
            $additionalDistance = max(0.0, $travelDistance - $minBaseKm);
            $distanceFare    = $additionalDistance * $perKmValue;
            if ($bookingData['trip_type'] === 'two-way') {
                $driverAllowance = $tripDays * $rateInfo['round_trip_driver_bata'];
            } else {
                $bataDays = max(1, (int) ceil($travelDistance / 400.0));
                $driverAllowance = $bataDays * $rateInfo['one_way_driver_bata'];
            }
            $estimatedFare   = $baseFareValue + $distanceFare + $driverAllowance;

            $estimationResults[] = [
                'vehicle'        => $vehicleName,
                'vehicle_name'   => $rateInfo['vehicle_name'],
                'base_fare'      => $baseFareValue,
                'per_km'         => $perKmValue,
                'driver_allowance' => $driverAllowance,
                'travel_distance'  => $travelDistance,
                'estimated_fare'   => $estimatedFare,
            ];
        }
        usort($estimationResults, static fn(array $l, array $r): int => $l['estimated_fare'] <=> $r['estimated_fare']);
        $bookingSuccess = 'Instant estimation generated for the selected cab type.';
        $bookingStatus  = true;
    }
}
$selectedEstimation = $estimationResults[0] ?? null;
$pageTitle = $selectedRoute['title'] ?? 'White Taxi | Book Outstation Cab in Tamil Nadu — Chennai, Bangalore, Madurai';
$pageDescription = $selectedRoute['description'] ?? 'Book White Call Taxi for safe airport transfers, city rides, outstation trips and corporate travel with transparent pricing and 24/7 support.';
$pagePath = '/' . (($selectedRoute['slug'] ?? 'index') . '.php');
$pageHeadline = $selectedRoute['headline'] ?? 'Taxi booking for airport, city, outstation and corporate travel';
$heroEyebrow = $selectedRoute['hero_eyebrow'] ?? 'Travel In Style, Arrive In Comfort';
$heroTitle = $selectedRoute['hero_title'] ?? 'Premium <span class="accent">Rides.</span><br>Every <span class="accent">Time.</span>';
$heroDescription = $selectedRoute['hero_description'] ?? 'White Call Taxi provides safe, reliable and luxurious rides anytime, anywhere with airport-ready pickups, city travel and corporate booking support.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  app_seo_render([
      'title' => $pageTitle,
      'description' => $pageDescription,
      'path' => $pagePath,
      'image' => 'images/hero-banner-image.png',
      'type' => 'website',
      'headline' => $pageHeadline,
      'schema_type' => 'Service',
      'service_name' => $selectedRoute
          ? ($selectedRoute['pickup'] . ' to ' . $selectedRoute['drop'] . ' taxi booking')
          : 'Airport, city, outstation and corporate taxi booking',
  ]);
  ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
 
</head>
<body>
  <header class="topbar">
    <div class="container">
      <div class="nav-shell">
        <a class="brand" href="#home" aria-label="White Call Taxi home">
          <img class="brand-mark brand-mark-photo" src="images/logo.png" alt="White Call Taxi logo">
          <div class="brand-copy">
            <strong>WHITE CALL TAXI</strong>
            <span>Premium Reliable Safe</span>
          </div>
        </a>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <nav class="nav-links" id="primary-nav" aria-label="Primary">
          <a class="active" href="index.php">Home</a>
          <a href="services.php">Services</a>
          <a href="fleet.php">Fleet</a>
          <a href="about.php">About Us</a>
          <a href="pricing.php">Pricing</a>
          <a href="contact.php">Contact</a>
        </nav>

        <div class="nav-cta">
          <div class="support">
            <span>
              <small>24/7 Support</small>
              <?= env_value('BUSINESS_PHONE', '+91 70090 05354') ?>
            </span>
          </div>
          <a class="button button-secondary" href="#booking">Book Now <span aria-hidden="true">&rarr;</span></a>
        </div>
      </div>
    </div>
  </header>

  <main class="home-page">
    <section class="hero" id="home">
      <div class="container">
        <div class="hero-shell">
          <div class="hero-left">
            <p class="eyebrow"><?= htmlspecialchars($heroEyebrow, ENT_QUOTES, 'UTF-8') ?></p>
            <h1><?= $heroTitle ?></h1>
            <p><?= htmlspecialchars($heroDescription, ENT_QUOTES, 'UTF-8') ?></p>
            <div class="hero-benefits">
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-shield-check"></i></div>
                <div>
                  <strong>Safe &amp; Secure</strong>
                  <span>Your safety is our top priority on every route.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-person-check"></i></div>
                <div>
                  <strong>Verified Drivers</strong>
                  <span>Professional and background-checked.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-tags"></i></div>
                <div>
                  <strong>Transparent Pricing</strong>
                  <span>No hidden charges. What you see is what you pay.</span>
                </div>
              </div>
            </div>

         
          </div>

          <aside class="booking-card glass" id="booking">
           
            <div class="estimation-results<?= $estimationResults ? '' : ' is-hidden' ?>" id="estimation-results">
              <div class="estimation-grid" id="estimation-grid" style="display: none;">
                <?php foreach ($estimationResults as $estimation): ?>
                  <article
                    class="estimate-card"
                    data-vehicle="<?= htmlspecialchars($estimation['vehicle'], ENT_QUOTES, 'UTF-8') ?>"
                    data-vehicle-name="<?= htmlspecialchars($estimation['vehicle_name'], ENT_QUOTES, 'UTF-8') ?>"
                    data-base-fare="<?= htmlspecialchars((string) $estimation['base_fare'], ENT_QUOTES, 'UTF-8') ?>"
                    data-per-km="<?= htmlspecialchars((string) $estimation['per_km'], ENT_QUOTES, 'UTF-8') ?>"
                    data-driver-allowance="<?= htmlspecialchars((string) $estimation['driver_allowance'], ENT_QUOTES, 'UTF-8') ?>"
                    data-travel-distance="<?= htmlspecialchars((string) $estimation['travel_distance'], ENT_QUOTES, 'UTF-8') ?>"
                    data-estimated-fare="<?= htmlspecialchars((string) $estimation['estimated_fare'], ENT_QUOTES, 'UTF-8') ?>"
                  >
                    <div class="estimate-top"><h4><?= htmlspecialchars($estimation['vehicle_name'], ENT_QUOTES, 'UTF-8') ?></h4></div>
                    <p class="estimate-price">Rs. <?= number_format($estimation['estimated_fare'], 0) ?></p>
                    <p class="estimate-meta">Base Rs. <?= number_format($estimation['base_fare'], 0) ?> + <?= number_format($estimation['travel_distance'], 1) ?> km x Rs. <?= number_format($estimation['per_km'], 0) ?></p>
                    <p class="estimate-meta">Driver Bata: Rs. <?= number_format($estimation['driver_allowance'], 0) ?></p>
                    <button class="estimate-select-btn" type="button">Confirm Cab &rarr;</button>
                  </article>
                <?php endforeach; ?>
              </div>
              <div class="booking-summary-panel is-hidden" id="booking-summary-panel">
                <div class="booking-summary-card">
                  <div class="booking-summary-header">
                    <h3>Booking Summary</h3>
                  </div>
                  <div class="booking-summary-body">
                    <div class="booking-summary-row-item">
                      <span class="summary-row-label">Book Type</span>
                      <strong class="summary-row-value" id="summary-book-type">-</strong>
                    </div>
                    <div class="booking-summary-row-item">
                      <span class="summary-row-label">Car Type</span>
                      <div class="summary-row-value-group">
                        <strong class="summary-row-value" id="summary-vehicle-name">-</strong>
                        <span class="summary-row-subvalue" id="summary-vehicle-desc">-</span>
                      </div>
                    </div>
                    <div class="booking-summary-row-item">
                      <span class="summary-row-label">Pickup</span>
                      <strong class="summary-row-value" id="summary-pickup">-</strong>
                    </div>
                    <div class="booking-summary-row-item">
                      <span class="summary-row-label">Drop</span>
                      <strong class="summary-row-value" id="summary-drop">-</strong>
                    </div>
                    <div class="booking-summary-row-item">
                      <span class="summary-row-label">Booked At</span>
                      <strong class="summary-row-value" id="summary-booked-at">-</strong>
                    </div>
                  </div>

                  <div class="payment-details-section">
                    <h3>Payment Details</h3>
                    <div class="payment-row">
                      <span class="payment-label" id="summary-base-fare-label">Base Fare [130 Km]</span>
                      <strong class="payment-value" id="summary-base-fare-val">-</strong>
                    </div>
                    <div class="payment-row">
                      <span class="payment-label" id="summary-additional-fare-label">Additional Fare [0 Km]</span>
                      <strong class="payment-value" id="summary-additional-val">-</strong>
                    </div>
                    <div class="payment-row" id="payment-driver-bata-row">
                      <span class="payment-label" id="summary-driver-bata-label">Driver Bata [upto 400 Km]</span>
                      <strong class="payment-value" id="summary-driver-bata-val">-</strong>
                    </div>
                    <div class="payment-total-row">
                      <span class="total-label">Total Amount</span>
                      <strong class="total-value" id="summary-total-amount-val">-</strong>
                    </div>
                  </div>

                  <div class="booking-summary-footer">
                    <button class="button button-primary summary-confirm-btn" id="summary-confirm-btn" type="button">
                      <span id="summary-confirm-label">Book Cab Now</span>
                      <span id="summary-confirm-spinner" hidden>Saving...</span>
                    </button>
                  </div>

                  <div class="payment-note-box">
                    <p><strong>Note:</strong> The actual bill amount might differ based on actual KMs travelled, Waiting time (for Oneway only), Hill-station charges, Inter-state Permits, Toll Charges etc.</p>
                  </div>
                </div>
                <p class="summary-status summary-status-success is-hidden" id="summary-success-msg"></p>
                <p class="summary-status summary-status-error is-hidden" id="summary-error-msg"></p>
                <div class="booking-confirmation-box is-hidden" id="booking-confirmation-box">
                  <div class="confirmation-grid">
                    <div class="confirmation-item"><span>Booking ID</span><strong id="summary-booking-id">-</strong></div>
                    <div class="confirmation-item"><span>Customer</span><strong id="summary-confirm-name">-</strong></div>
                    <div class="confirmation-item"><span>Vehicle</span><strong id="summary-confirm-vehicle">-</strong></div>
                    <div class="confirmation-item"><span>Total Fare</span><strong id="summary-confirm-fare">-</strong></div>
                  </div>
                </div>
                <div class="summary-actions">
                  <button class="button button-secondary summary-whatsapp-btn is-hidden" id="summary-whatsapp-btn" type="button">Share on WhatsApp</button>
                </div>
              </div>
              <button class="button button-secondary" id="back-to-form-button" type="button">Modify Search</button>
            </div>

            <div id="booking-form-container" class="booking-form-container<?= $estimationResults ? ' is-hidden' : '' ?>">
              <div class="card-title">
                <div class="square-icon">C</div>
                <h2>Book Your Ride</h2>
              </div>
              <p class="form-message form-message-success<?= $bookingSuccess === '' ? ' is-hidden' : '' ?>" id="booking-success-message"><?= htmlspecialchars($bookingSuccess, ENT_QUOTES, 'UTF-8') ?></p>
              <p class="form-message form-message-error<?= isset($bookingErrors['form']) ? '' : ' is-hidden' ?>" id="booking-error-message"><?= isset($bookingErrors['form']) ? htmlspecialchars($bookingErrors['form'], ENT_QUOTES, 'UTF-8') : '' ?></p>

              <form class="booking-grid" id="booking-form" method="post" action="#booking" novalidate data-rate-table="<?= $rateTableJson ?>">
                <div class="trip-type" role="radiogroup" aria-label="Trip type">
                  <label class="trip-option">
                    <input type="radio" name="trip_type" value="one-way" <?= $bookingData['trip_type'] === 'one-way' ? 'checked' : '' ?>>
                    <span>One Way Trip</span>
                  </label>
                  <label class="trip-option">
                    <input type="radio" name="trip_type" value="two-way" <?= $bookingData['trip_type'] === 'two-way' ? 'checked' : '' ?>>
                    <span>Round Trip</span>
                  </label>
                </div>
                <?php if (isset($bookingErrors['trip_type'])): ?>
                  <p class="field-error form-field-error"><?= htmlspecialchars($bookingErrors['trip_type'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <div class="field-row field-row-compact">
                  <div class="field">
                    <label class="sr-only" for="name">Name</label>
                    <input id="name" name="name" type="text" placeholder="Enter your name" value="<?= booking_value($bookingData, 'name') ?>" required>
                    <?php if (isset($bookingErrors['name'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['name'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                  <div class="field">
                    <label class="sr-only" for="mobile">Mobile Number</label>
                    <input id="mobile" name="mobile" type="tel" inputmode="numeric" maxlength="10" placeholder="Enter 10-digit mobile number" pattern="[6-9][0-9]{9}" value="<?= booking_value($bookingData, 'mobile') ?>" required>
                    <?php if (isset($bookingErrors['mobile'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['mobile'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                </div>

                <div class="field">
                  <label class="sr-only" for="email">Email</label>
                  <input id="email" name="email" type="email" placeholder="Enter your email address (optional)" value="<?= booking_value($bookingData, 'email') ?>">
                  <?php if (isset($bookingErrors['email'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['email'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                </div>

                

                <div class="field-row field-row-compact">
                  <div class="field">
                    <label class="sr-only" for="pickup">Pickup Location</label>
                    <input id="pickup" name="pickup" type="text" placeholder="Enter pickup location" value="<?= booking_value($bookingData, 'pickup') ?>" autocomplete="off" required>
                    <input id="pickup-lat" type="hidden">
                    <input id="pickup-lng" type="hidden">
                    <?php if (isset($bookingErrors['pickup'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['pickup'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                  <div class="field">
                    <label class="sr-only" for="drop">Drop Location</label>
                    <input id="drop" name="drop" type="text" placeholder="Enter drop location" value="<?= booking_value($bookingData, 'drop') ?>" autocomplete="off" required>
                    <input id="drop-lat" type="hidden">
                    <input id="drop-lng" type="hidden">
                    <?php if (isset($bookingErrors['drop'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['drop'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                </div>

                <input id="distance-km" name="distance_km" type="hidden" value="<?= booking_value($bookingData, 'distance_km') ?>">
                <?php if (isset($bookingErrors['distance_km'])): ?>
                  <p class="field-error form-field-error"><?= htmlspecialchars($bookingErrors['distance_km'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <div class="field-row field-row-compact">
                  <div class="field">
                    <label class="sr-only" for="date">Date</label>
                    <input id="date" name="date" type="date" min="<?= htmlspecialchars($todayDate, ENT_QUOTES, 'UTF-8') ?>" value="<?= booking_value($bookingData, 'date') ?>" required>
                    <?php if (isset($bookingErrors['date'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['date'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                  <div class="field">
                    <label class="sr-only" for="time">Time</label>
                    <input id="time" name="time" type="time" value="<?= booking_value($bookingData, 'time') ?>" required>
                    <?php if (isset($bookingErrors['time'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['time'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                  </div>
                </div>
              
                <div class="field-row field-row-compact">
                    <div class="field trip-days-field" id="trip-days-field" <?= $bookingData['trip_type'] !== 'two-way' ? 'hidden' : '' ?>>
                  <label class="sr-only" for="trip-days">Trip Days</label>
                  <input id="trip-days" name="trip_days" type="number" min="1" max="30" placeholder="Enter number of days" value="<?= booking_value($bookingData, 'trip_days') ?>">
                  <?php if (isset($bookingErrors['trip_days'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['trip_days'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                </div>
                <div class="field">
                  <label class="sr-only" for="cabtype">Select Cab Type</label>
                  <select id="cabtype" name="cabtype" required>
                    <option value="">-- Select vehicle type --</option>
                    <?php foreach ($carRateTable as $vehicleCode => $rateInfo): ?>
                      <option value="<?= htmlspecialchars($vehicleCode, ENT_QUOTES, 'UTF-8') ?>" <?= booking_value($bookingData, 'cabtype') === $vehicleCode ? 'selected' : '' ?>><?= htmlspecialchars($rateInfo['vehicle_name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?php if (isset($bookingErrors['cabtype'])): ?><span class="field-error"><?= htmlspecialchars($bookingErrors['cabtype'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
                </div>
                </div>


                <button class="button button-primary" id="get-estimation-button" type="submit">Get Estimation <span aria-hidden="true">&rarr;</span></button>
              </form>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <section class="stats">
      <div class="container">
        <div class="stats-shell glass">
          <div class="stat">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div><strong>25K+</strong><span>Happy Customers</span></div>
          </div>
          <div class="stat">
            <div class="stat-icon"><i class="bi bi-car-front-fill"></i></div>
            <div><strong>15K+</strong><span>Rides Completed</span></div>
          </div>
          <div class="stat">
            <div class="stat-icon"><i class="bi bi-geo-fill"></i></div>
            <div><strong>50+</strong><span>Cities Covered</span></div>
          </div>
          <div class="stat">
            <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
            <div><strong>4.9</strong><span>Customer Rating</span></div>
          </div>
          <div class="stat">
            <div class="stat-icon"><i class="bi bi-headset"></i></div>
            <div><strong>24/7</strong><span>Customer Support</span></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section services" id="services">
      <div class="container">
        <div class="section-heading"><span>Our Premium Services</span></div>

        <div class="services-grid">
          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge">
                <i class="bi bi-airplane-engines-fill"></i>
              </div>
              <h3>Airport Transfers</h3>
              <p>On-time airport pickup and drop with live coordination for arrivals and departures.</p>
            </div>
            <div class="service-image">
              <img src="images/City-taxi.png" alt="Airport transfer service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge">
                <i class="bi bi-buildings-fill"></i>
              </div>
              <h3>City Rides</h3>
              <p>Quick and comfortable rides within the city for daily travel, meetings and events.</p>
            </div>
            <div class="service-image">
              <img src="images/city-call-taxi.png" alt="City rides service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge">
                <i class="bi bi-taxi-front"></i>
              </div>
              <h3>One-way Outstation</h3>
              <p>Safe long-distance travel with premium sedans and professional chauffeurs.</p>
            </div>
            <div class="service-image">
              <img src="images/one-way-outstation-call-taxi.png" alt="Outstation service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <h3>Round trip Outstation</h3>
              <p>Book by the hour for shopping, business travel or flexible day plans.</p>
            </div>
            <div class="service-image">
              <img src="images/roundtrip-white-call-taxi.png" alt="Hourly rental service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <!-- <article class="service-card">
            <div class="service-body">
              <div class="icon-badge">
                <i class="bi bi-building-check"></i>
              </div>
              <h3>Corporate Travel</h3>
              <p>Premium business transport solutions with polished service & support.</p>
            </div>
            <div class="service-image">
              <img src="images/corporate-white-call-taxi.png" alt="Corporate travel service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article> -->
        </div>
      </div>
    </section>
    <hr class="section-divider"></hr>               
    <section class="section fleet" id="fleet">
      <div class="container">
        <div class="section-heading"><span>Our Fleet</span></div>
        <div class="fleet-grid">
          <article class="fleet-card">
            <div class="icon-badge"><i class="bi bi-car-front"></i></div>
            <h3>Executive Sedan</h3>
            <p>Ideal for premium city travel with refined interiors, quiet comfort and professional chauffeur service.</p>
            <div class="icon-badge-fleet">
            <a href="#">Book this cab on WhatsApp <div class="service-arrow">&rarr;</div></a>
            </div>
          </article>

          <article class="fleet-card">
            <div class="icon-badge"><i class="bi bi-car-front"></i></div>
            <h3>Luxury SUV</h3>
            <p>Spacious and dependable for family trips, airport transfers and long-distance comfort.</p>
            <div class="icon-badge-fleet">
            <a href="#">Book this cab on WhatsApp <div class="service-arrow">&rarr;</div></a>
            </div>
          </article>

          <article class="fleet-card">
            <div class="icon-badge"><i class="bi bi-car-front"></i></div>
            <h3>Business Class</h3>
            <p>Designed for corporate travel with premium finish, punctual scheduling and elevated service quality.</p>
            <div class="icon-badge-fleet">
            <a href="#">Book this cab on WhatsApp <div class="service-arrow">&rarr;</div></a>
            </div>
          </article>
        </div>
      </div>
    </section>
    <hr class="section-divider"></hr>                  
    <section class="fare-section">
  <div class="container">

    <div class="fare-header">
      <div>
        <h2>Transparent fare rates for every trip.</h2>
        <p>Fares may vary slightly based on route, traffic and peak dates. Exact fare will be shared on WhatsApp before you confirm.</p>
      </div>
    </div>

    <div class="fare-grid">

      <div class="fare-card">
        <h5>ONE-WAY DROP</h5>
        <h3>Outstation · One-way</h3>
        <p>Ideal when you don't want to pay for return.</p>

        <div class="fare-row">
          <span>Sedan</span>
          <strong>from ₹14/km</strong>
        </div>
        <div class="fare-row">
          <span>SUV</span>
          <strong>from ₹19/km</strong>
        </div>
        <div class="fare-row">
          <span>Premium</span>
          <strong>from ₹24/km</strong>
        </div>

        <div class="fare-line"></div>
        <small>• Minimum 130–150 km billing per day varies by route.</small>
        <small>• Driver bata from ₹400–₹600/day depending on route.</small>
      </div>

      <div class="fare-card">
        <h5>ROUND TRIP</h5>
        <h3>Outstation · Round trip</h3>
        <p>Best value for weekend trips and returns.</p>

        <div class="fare-row">
          <span>Sedan</span>
          <strong>from ₹13/km</strong>
        </div>
        <div class="fare-row">
          <span>SUV</span>
          <strong>from ₹18/km</strong>
        </div>
        <div class="fare-row">
          <span>Premium</span>
          <strong>from ₹21/km</strong>
        </div>

        <div class="fare-line"></div>
        <small>• Minimum 250–300 km per day round trip billing.</small>
        <small>• Night halt charges may apply for multi-day trips.</small>
      </div>

      <div class="fare-card">
        <h5>LOCAL & AIRPORT</h5>
        <h3>In-city & airport rides</h3>
        <p>Perfect for errands, meetings and airport pickups.</p>

        <div class="fare-row">
          <span>4 hrs / 40 km</span>
          <strong>from ₹1,199</strong>
        </div>
        <div class="fare-row">
          <span>8 hrs / 80 km</span>
          <strong>from ₹2,200</strong>
        </div>
        <div class="fare-row">
          <span>Airport pickup / drop</span>
          <strong>from ₹799</strong>
        </div>

        <div class="fare-line"></div>
        <small>• Extra km & hours charged at standard slab rates.</small>
        <small>• Parking & tolls as per actuals if applicable.</small>
      </div>

    </div>

    <div class="fare-bottom">
      <p>Need an exact fare for your trip? Share your route and we’ll send a detailed quote on WhatsApp in a few minutes.</p>
      <div class="fare-buttons">
        <a href="#" class="btn-dark">Get exact fare for my trip →</a>
        <a href="https://wa.me/<?= env_value('WHATSAPP_NUMBER', '917009005354') ?>" class="btn-light">Ask on WhatsApp</a>
      </div>
    </div>

  </div>
</section>
<hr class="section-divider"></hr>  

    <section class="section" id="app">
      <div class="container">
        <div class="app-card glass">
          <div class="phones">
            <img src="images/booking-taxi.png" class="img-fluid" alt="Online taxi booking illustration" loading="lazy" decoding="async" >
          </div>

          <div class="app-copy">
            <p class="eyebrow">Easy To Book</p>
            <h2><span class="accent">Simple, Transparent</span><br>Booking Experience.</h2>
            <p>No apps, no confusion. Just tell us where you're going and we handle the rest.</p>
            <!-- <div class="store-row">
              <a class="store-badge" href="#"><span>GP</span>Google Play</a>
              <a class="store-badge" href="#"><span>AS</span>App Store</a>
            </div> -->
          </div>

          <div class="app-points">
            <div class="point">
              <div class="square-icon"><i class="bi bi-geo-fill"></i></div>
              <div>
                <strong>Share Your Route</strong>
                <span>Enter trip or airport details in the form or send us your trip details on WhatsApp.</span>
              </div>
            </div>
            <div class="point">
              <div class="square-icon"><i class="bi bi-tags-fill"></i></div>
              <div>
                <strong>Get Fixed Quote</strong>
                <span>We share an all-inclusive fare with no hidden charges or last-minute surprises.</span>
              </div>
            </div>
            <div class="point">
              <div class="square-icon"><i class="bi bi-emoji-smile-fill"></i></div>
              <div>
                <strong>Ride With Peace</strong>
                <span>Verified chauffeurs, clean cars and support throughout your journey.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="section-divider"></hr>                  
    <section class="section" id="about">
      <div class="container">
        <div class="section-heading"><span>What Our Customers Say</span></div>
        <div class="testimonials">
          <article class="testimonial glass">
            <!-- <img class="avatar" src="images/avatar-rahul.svg" alt="Rahul Sharma"> -->
            <div>
              <p>Excellent service. Driver was on time, very professional and the ride was extremely comfortable.</p>
              <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
              <strong>Rahul Sharma</strong>
            </div>
          </article>

          <article class="testimonial glass">
            <!-- <img class="avatar" src="images/avatar-priya.svg" alt="Priya Mehta"> -->
            <div>
              <p>I always prefer White Call Taxi for airport transfers. Always reliable and safe.</p>
              <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
              <strong>Priya Mehta</strong>
            </div>
          </article>

          <article class="testimonial glass">
            <!-- <img class="avatar" src="images/avatar-amit.svg" alt="Amit Verma"> -->
            <div>
              <p>Best cab service in the city. Clean cars, polite drivers and fair pricing every time.</p>
              <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
              <strong>Amit Verma</strong>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/site-footer.php'; ?>

  <script>
    // ── CONFIG ─────────────────────────────────────────────────────────────
    const WHATSAPP_NUMBER = '<?= env_value('WHATSAPP_NUMBER', '917009005354') ?>';

    // ── Helpers ────────────────────────────────────────────────────────────
    const inr = (n) => Number(n) > 0 ? '₹ ' + Math.round(Number(n)).toLocaleString('en-IN') + '.00' : 'TBC';

    // Predefined coordinates for common locations to avoid blocking bookings
    const PREDEFINED_LOCATIONS = {
      "chennai": { lat: 13.0827, lng: 80.2707 },
      "bangalore": { lat: 12.9716, lng: 77.5946 },
      "coimbatore": { lat: 11.0168, lng: 76.9558 },
      "madurai": { lat: 9.9252, lng: 78.1198 },
      "pondicherry": { lat: 11.9416, lng: 79.8083 },
      "salem": { lat: 11.6643, lng: 78.1460 },
      "trichy": { lat: 10.7905, lng: 78.7047 },
      "tirupati": { lat: 13.6288, lng: 79.4192 },
      "kanyakumari": { lat: 8.0883, lng: 77.5385 },
      "vellore": { lat: 12.9165, lng: 79.1325 },
      "chennai airport": { lat: 12.9941, lng: 80.1709 },
      "bangalore airport": { lat: 13.1986, lng: 77.7066 },
      "tirupati airport": { lat: 13.6325, lng: 79.5433 },
      "hyderabad airport": { lat: 17.2403, lng: 78.4294 },
      "coimbatore airport": { lat: 11.0300, lng: 77.0434 },
      "trichy airport": { lat: 10.7651, lng: 78.7139 },
      "madurai airport": { lat: 9.8344, lng: 78.0934 },
      "tuticorin airport": { lat: 8.7231, lng: 78.0267 }
    };

    // Predefined distances between popular locations for offline fallback
    const PREDEFINED_DISTANCES = {
      "chennai-bangalore": 346,
      "chennai-coimbatore": 510,
      "chennai-madurai": 460,
      "chennai-pondicherry": 170,
      "chennai-trichy": 330,
      "coimbatore-chennai": 510,
      "madurai-chennai": 460,
      "trichy-chennai": 330,
      "chennai-salem": 345,
      "chennai-tirupati": 135,
      "chennai-kanyakumari": 700,
      "chennai-vellore": 140,
      "bangalore-chennai": 346,
      "salem-chennai": 345,
      "tirupati-chennai": 135,
      "kanyakumari-chennai": 700,
      "vellore-chennai": 140
    };

    // Auto-populates coordinate fields if the text matches a predefined location
    const autoFillCoordinates = (prefix) => {
      const input = document.getElementById(prefix);
      const latInput = document.getElementById(`${prefix}-lat`);
      const lngInput = document.getElementById(`${prefix}-lng`);
      if (!input || !latInput || !lngInput) return;

      const val = input.value.trim().toLowerCase();
      if (PREDEFINED_LOCATIONS[val]) {
        latInput.value = PREDEFINED_LOCATIONS[val].lat;
        lngInput.value = PREDEFINED_LOCATIONS[val].lng;
      }
    };

    // Shared booking payload
    let currentBookingPayload = null;
    let selectedEstimateCard = null;

    // ── WhatsApp message builder ───────────────────────────────────────
    const openWhatsApp = (p) => {
      const tripLabel = p.trip_type === 'two-way'
        ? `Round Trip (${p.trip_days} day${p.trip_days !== '1' ? 's' : ''})`
        : 'One Way';
      const allowanceLine = Number(p.driver_allowance) > 0
        ? `\nDriver Bata : ${inr(p.driver_allowance)}` : '';
      const totalFareLabel = Number(p.total_fare) > 0 ? inr(p.total_fare) : 'To be confirmed on call';
      const distanceLabel = Number(p.distance_km) > 0 ? `${p.distance_km} km` : 'TBC';
      const fareBreakdown = Number(p.total_fare) > 0 
        ? `Base Fare       : ${inr(p.base_fare)}\nDistance Charge : ${inr(p.dist_charge)}  (${p.distance_km} km × Rs.${p.per_km}/km)${allowanceLine}\n*TOTAL          : ${totalFareLabel}*`
        : `*Fare will be manually quoted by support shortly.*`;

      const msg = `🚖 *New Booking – White Call Taxi*\n\n*Vehicle :* ${p.vehicle_name || p.vehicle}\n*Trip    :* ${tripLabel}\n\n👤 *Passenger*\nName   : ${p.name}\nMobile : ${p.mobile}\nEmail  : ${p.email || 'N/A'}\n\n📍 *Journey*\nPickup   : ${p.pickup}\nDrop     : ${p.drop}\nDistance : ${distanceLabel}\nDate     : ${p.date}  |  Time : ${p.time}\n\n💰 *Fare Breakdown*\n${fareBreakdown}`;
      window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`, '_blank', 'noopener,noreferrer');
    };

    // ── Google Places ──────────────────────────────────────────────────
    let pickupAutocomplete, dropAutocomplete;

    function setPlaceCoordinates(prefix, place) {
      const latInput = document.getElementById(`${prefix}-lat`);
      const lngInput = document.getElementById(`${prefix}-lng`);
      if (!latInput || !lngInput) return;
      const location = place?.geometry?.location;
      if (!location) { latInput.value = ''; lngInput.value = ''; return; }
      latInput.value = location.lat();
      lngInput.value = location.lng();
    }

    function initGooglePlaces() {
      if (!window.google || !google.maps || !google.maps.places) return;
      const pickupInput = document.getElementById('pickup');
      const dropInput   = document.getElementById('drop');
      if (pickupInput) {
        pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
          fields: ['formatted_address', 'geometry', 'name'],
          componentRestrictions: { country: 'in' },
        });
        pickupAutocomplete.addListener('place_changed', () => setPlaceCoordinates('pickup', pickupAutocomplete.getPlace()));
      }
      if (dropInput) {
        dropAutocomplete = new google.maps.places.Autocomplete(dropInput, {
          fields: ['formatted_address', 'geometry', 'name'],
          componentRestrictions: { country: 'in' },
        });
        dropAutocomplete.addListener('place_changed', () => setPlaceCoordinates('drop', dropAutocomplete.getPlace()));
      }
    }

    // ── Booking form logic ─────────────────────────────────────────────
    const bookingForm = document.getElementById('booking-form');
    const menuToggle  = document.querySelector('.menu-toggle');
    const primaryNav  = document.getElementById('primary-nav');
    const navShell    = document.querySelector('.nav-shell');

    if (bookingForm) {
      const mobileInput    = document.getElementById('mobile');
      const emailInput     = document.getElementById('email');
      const tripTypeInputs = bookingForm.querySelectorAll('input[name="trip_type"]');
      const tripDaysField  = document.getElementById('trip-days-field');
      const tripDaysInput  = document.getElementById('trip-days');
      const cabTypeInput   = document.getElementById('cabtype');
      const pickupInput    = document.getElementById('pickup');
      const dropInput      = document.getElementById('drop');
      const distanceInput  = document.getElementById('distance-km');
      const pickupLatInput = document.getElementById('pickup-lat');
      const pickupLngInput = document.getElementById('pickup-lng');
      const dropLatInput   = document.getElementById('drop-lat');
      const dropLngInput   = document.getElementById('drop-lng');
      const resultsWrapper = document.getElementById('estimation-results');
      const resultsGrid    = document.getElementById('estimation-grid');
      const successMessage = document.getElementById('booking-success-message');
      const errorMessage   = document.getElementById('booking-error-message');
      const formContainer  = document.getElementById('booking-form-container');
      const backToFormBtn  = document.getElementById('back-to-form-button');
      const rateTable      = JSON.parse(bookingForm.dataset.rateTable || '{}');
      const summaryPanel   = document.getElementById('booking-summary-panel');
      const summaryConfirmBtn = document.getElementById('summary-confirm-btn');
      const summaryConfirmLabel = document.getElementById('summary-confirm-label');
      const summaryConfirmSpinner = document.getElementById('summary-confirm-spinner');
      const summaryWhatsappBtn = document.getElementById('summary-whatsapp-btn');
      const summarySuccessMsg = document.getElementById('summary-success-msg');
      const summaryErrorMsg = document.getElementById('summary-error-msg');
      const confirmationBox = document.getElementById('booking-confirmation-box');

      const formatTimeAMPM = (timeStr) => {
        if (!timeStr || timeStr === '-') return '-';
        const parts = timeStr.split(':');
        if (parts.length < 2) return timeStr;
        let hours = parseInt(parts[0], 10);
        const minutes = parts[1];
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        return `${hours}:${minutes} ${ampm}`;
      };

      const populateBookingSummary = (item, details) => {
        const minBaseKm = details.tripType === 'two-way' ? 250 * details.tripDays : 130;
        const additionalKm = Math.max(0, item.travelDistance - minBaseKm);
        const baseFareVal = minBaseKm * item.perKm;
        const additionalFareVal = additionalKm * item.perKm;

        currentBookingPayload = {
          name: details.name,
          email: details.email,
          mobile: details.mobile,
          pickup: details.pickup,
          drop: details.drop,
          date: details.date,
          time: details.time,
          vehicle: item.vehicleCode,
          vehicle_name: item.vehicleName,
          trip_type: details.tripType,
          trip_days: String(details.tripDays),
          distance_km: item.travelDistance.toFixed(1),
          base_fare: String(Math.round(baseFareVal)),
          per_km: String(Math.round(item.perKm)),
          dist_charge: String(Math.round(additionalFareVal)),
          driver_allowance: String(Math.round(item.driverAllowance)),
          total_fare: String(Math.round(item.estimatedFare)),
        };

        const descriptions = {
          'SEDAN': '2 Luggages | Etios, Dzire or Similar',
          'ETIOS': '2 Luggages | Etios, Dzire or Similar',
          'SUV': '3 Luggages | Ertiga or Similar',
          'INNOVA': '4 Luggages | Innova, Crysta or Similar'
        };
        const vehicleDesc = descriptions[item.vehicleCode.toUpperCase()] || 'Comfortable AC Cab';

        document.getElementById('summary-book-type').textContent = details.tripType === 'two-way' ? 'Round Trip' : 'One way';
        document.getElementById('summary-vehicle-name').textContent = item.vehicleName;
        const descEl = document.getElementById('summary-vehicle-desc');
        if (descEl) descEl.textContent = vehicleDesc;
        document.getElementById('summary-pickup').textContent = details.pickup;
        document.getElementById('summary-drop').textContent = details.drop;
        
        const formattedBookedAt = `${details.date} ${formatTimeAMPM(details.time)}`;
        document.getElementById('summary-booked-at').textContent = formattedBookedAt;

        // Payment details fields
        document.getElementById('summary-base-fare-label').textContent = `Base Fare [${minBaseKm} Km]`;
        document.getElementById('summary-base-fare-val').textContent = inr(baseFareVal);
        
        document.getElementById('summary-additional-fare-label').textContent = `Additional Fare [${additionalKm.toFixed(1)} Km]`;
        document.getElementById('summary-additional-val').textContent = inr(additionalFareVal);

        const bataDays = details.tripType === 'two-way' ? details.tripDays : Math.max(1, Math.ceil(item.travelDistance / 400));
        const bataLabel = details.tripType === 'two-way' ? `Driver Bata [${bataDays} Day${bataDays > 1 ? 's' : ''}]` : `Driver Bata [upto 400 Km]`;
        document.getElementById('summary-driver-bata-label').textContent = bataLabel;
        document.getElementById('summary-driver-bata-val').textContent = inr(item.driverAllowance);

        document.getElementById('summary-total-amount-val').textContent = inr(item.estimatedFare);

        renderSummaryStatus(summarySuccessMsg, '');
        renderSummaryStatus(summaryErrorMsg, '');
        confirmationBox?.classList.add('is-hidden');
        summaryWhatsappBtn?.classList.add('is-hidden');
        summaryConfirmBtn.hidden = false;
        summaryConfirmBtn.disabled = false;
        summaryConfirmLabel.hidden = false;
        summaryConfirmSpinner.hidden = true;
        summaryPanel?.classList.remove('is-hidden');
      };

      const showForm = () => {
        formContainer?.classList.remove('is-hidden');
        resultsWrapper?.classList.add('is-hidden');
        summaryPanel?.classList.add('is-hidden');
        confirmationBox?.classList.add('is-hidden');
        summaryWhatsappBtn?.classList.add('is-hidden');
        summarySuccessMsg?.classList.add('is-hidden');
        summaryErrorMsg?.classList.add('is-hidden');
        currentBookingPayload = null;
        if (selectedEstimateCard) {
          selectedEstimateCard.classList.remove('selected');
          selectedEstimateCard = null;
        }
      };
      const hideForm = () => { formContainer?.classList.add('is-hidden');    resultsWrapper?.classList.remove('is-hidden'); };

      const renderMessage = (el, msg) => {
        if (!el) return;
        el.textContent = msg;
        el.classList.toggle('is-hidden', msg === '');
      };

      const renderSummaryStatus = (el, msg) => {
        if (!el) return;
        el.textContent = msg;
        el.classList.toggle('is-hidden', msg === '');
      };

      const clearPlaceCoordinates = (prefix) => {
        const lat = document.getElementById(`${prefix}-lat`);
        const lng = document.getElementById(`${prefix}-lng`);
        if (lat) lat.value = '';
        if (lng) lng.value = '';
      };

      // ── renderEstimationResults — builds cards with Select button ──
      const renderEstimationResults = (results, distanceKm, tripType, tripDays) => {
        if (!resultsWrapper  || !resultsGrid ) return;
        resultsGrid.innerHTML = '';
        summaryPanel?.classList.add('is-hidden');
        confirmationBox?.classList.add('is-hidden');
        summaryWhatsappBtn?.classList.add('is-hidden');
        renderSummaryStatus(summarySuccessMsg, '');
        renderSummaryStatus(summaryErrorMsg, '');
        if (selectedEstimateCard) {
          selectedEstimateCard.classList.remove('selected');
          selectedEstimateCard = null;
        }

        const nameVal   = document.getElementById('name')?.value  || '-';
        const emailVal  = document.getElementById('email')?.value || '-';
        const mobileVal = mobileInput.value  || '-';
        const pickupVal = pickupInput.value  || '-';
        const dropVal   = dropInput.value    || '-';
        const dateVal   = document.getElementById('date')?.value  || '-';
        const timeVal   = document.getElementById('time')?.value  || '-';

        results.forEach((item) => {
          const minBaseKm = tripType === 'two-way' ? 250 * tripDays : 130;
          const additionalKm = Math.max(0, item.travelDistance - minBaseKm);
          const additionalFare = additionalKm * item.perKm;

          const card = document.createElement('article');
          card.className = 'estimate-card';
          card.innerHTML = `
            <div class="estimate-top"><h4>${item.vehicleName}</h4></div>
            <p class="estimate-price">${inr(item.estimatedFare)}</p>
            <p class="estimate-meta">Base Fare [${minBaseKm} Km]: ${inr(item.baseFare)}</p>
            ${additionalKm > 0 ? `<p class="estimate-meta">Additional [${additionalKm.toFixed(1)} Km]: ${inr(additionalFare)}</p>` : ''}
            <p class="estimate-meta">Driver Bata: ${inr(item.driverAllowance)}</p>
            <button class="estimate-select-btn" type="button">Confirm Cab &rarr;</button>
          `;

          card.querySelector('.estimate-select-btn').addEventListener('click', () => {
            if (selectedEstimateCard) selectedEstimateCard.classList.remove('selected');
            selectedEstimateCard = card;
            selectedEstimateCard.classList.add('selected');
            populateBookingSummary(item, {
              name: nameVal,
              email: emailVal,
              mobile: mobileVal,
              pickup: pickupVal,
              drop: dropVal,
              date: dateVal,
              time: timeVal,
              tripType,
              tripDays,
            });
          });

          resultsGrid.appendChild(card);

          if (results.length === 1) {
            card.querySelector('.estimate-select-btn')?.click();
          }
        });

       

        // Populate summary panel
        const fields = { 'est-name': nameVal, 'est-mobile': mobileVal, 'est-pickup': pickupVal,
                         'est-drop': dropVal,  'est-date':   dateVal,   'est-time':   timeVal };
        Object.entries(fields).forEach(([id, val]) => {
          const el = document.getElementById(id);
          if (el) el.textContent = val;
        });

        hideForm();
        renderMessage(successMessage, '');
        renderMessage(errorMessage, '');
      };

      const calculateEstimates = (distanceKm) => {
        const tripType = bookingForm.querySelector('input[name="trip_type"]:checked')?.value || 'one-way';
        const tripDays = tripType === 'two-way' ? Math.max(1, Number(tripDaysInput.value || 1)) : 1;
        const selectedCabType = cabTypeInput?.value || '';
        const rows = Object.entries(rateTable).filter(([vehicle]) => {
          return selectedCabType === '' || vehicle === selectedCabType;
        }).map(([vehicle, r]) => {
          const travelDistance  = tripType === 'two-way' ? distanceKm * 2 : distanceKm;
          const minBaseKm = tripType === 'two-way' ? 250 * tripDays : 130;
          const perKm = tripType === 'two-way' ? Number(r.round_trip_per_km || 0) : Number(r.one_way_per_km || 0);
          const baseFare = minBaseKm * perKm;
          const additionalDistance = Math.max(0, travelDistance - minBaseKm);
          const distanceFare = additionalDistance * perKm;
          let driverAllowance = 0;
          if (tripType === 'two-way') {
            driverAllowance = tripDays * Number(r.round_trip_driver_bata || 0);
          } else {
            const bataDays = Math.max(1, Math.ceil(travelDistance / 400));
            driverAllowance = bataDays * Number(r.one_way_driver_bata || 0);
          }
          const estimatedFare   = baseFare + distanceFare + driverAllowance;
          return { vehicleCode: vehicle, vehicleName: r.vehicle_name || vehicle, baseFare, perKm, driverAllowance, travelDistance, estimatedFare };
        }).sort((a, b) => a.estimatedFare - b.estimatedFare);
        renderEstimationResults(rows, distanceKm, tripType, tripDays);
      };

      const showFallbackEstimate = () => {
        if (!resultsWrapper || !resultsGrid) return;
        resultsGrid.innerHTML = '';
        summaryPanel?.classList.add('is-hidden');
        confirmationBox?.classList.add('is-hidden');
        summaryWhatsappBtn?.classList.add('is-hidden');
        renderSummaryStatus(summarySuccessMsg, '');
        renderSummaryStatus(summaryErrorMsg, '');

        const selectedCabType = cabTypeInput?.value || 'SEDAN';
        const cabName = cabTypeInput?.options[cabTypeInput.selectedIndex]?.text || 'Cab';

        const card = document.createElement('article');
        card.className = 'estimate-card estimate-card-fallback';
        card.innerHTML = `
          <div class="estimate-top"><h4>${cabName} (Custom Route)</h4></div>
          <p class="estimate-price">Fare: To be confirmed</p>
          <p class="estimate-meta">Distance-based pricing applies.</p>
          <p class="estimate-meta">We will contact you with the exact quote.</p>
          <button class="estimate-select-btn" type="button">Confirm Booking &rarr;</button>
        `;

        card.querySelector('.estimate-select-btn').addEventListener('click', () => {
          if (selectedEstimateCard) selectedEstimateCard.classList.remove('selected');
          selectedEstimateCard = card;
          selectedEstimateCard.classList.add('selected');

          const details = {
            name: document.getElementById('name')?.value || '-',
            email: document.getElementById('email')?.value || '-',
            mobile: mobileInput.value || '-',
            pickup: pickupInput.value || '-',
            drop: dropInput.value || '-',
            date: document.getElementById('date')?.value || '-',
            time: document.getElementById('time')?.value || '-',
            tripType: bookingForm.querySelector('input[name="trip_type"]:checked')?.value || 'one-way',
            tripDays: tripDaysField.hidden ? 1 : Math.max(1, Number(tripDaysInput.value || 1)),
          };

          currentBookingPayload = {
            name: details.name,
            email: details.email,
            mobile: details.mobile,
            pickup: details.pickup,
            drop: details.drop,
            date: details.date,
            time: details.time,
            vehicle: selectedCabType,
            vehicle_name: cabName,
            trip_type: details.tripType,
            trip_days: String(details.tripDays),
            distance_km: '0',
            base_fare: '0',
            per_km: '0',
            dist_charge: '0',
            driver_allowance: '0',
            total_fare: '0',
          };

          const descriptions = {
            'SEDAN': '2 Luggages | Etios, Dzire or Similar',
            'ETIOS': '2 Luggages | Etios, Dzire or Similar',
            'SUV': '3 Luggages | Ertiga or Similar',
            'INNOVA': '4 Luggages | Innova, Crysta or Similar'
          };
          const vehicleDesc = descriptions[selectedCabType.toUpperCase()] || 'Comfortable AC Cab';

          document.getElementById('summary-book-type').textContent = details.tripType === 'two-way' ? 'Round Trip' : 'One way';
          document.getElementById('summary-vehicle-name').textContent = cabName;
          const descEl = document.getElementById('summary-vehicle-desc');
          if (descEl) descEl.textContent = vehicleDesc;
          document.getElementById('summary-pickup').textContent = details.pickup;
          document.getElementById('summary-drop').textContent = details.drop;
          
          const formattedBookedAt = `${details.date} ${formatTimeAMPM(details.time)}`;
          document.getElementById('summary-booked-at').textContent = formattedBookedAt;

          // Payment details fields
          document.getElementById('summary-base-fare-label').textContent = `Base Fare`;
          document.getElementById('summary-base-fare-val').textContent = `TBC`;
          
          document.getElementById('summary-additional-fare-label').textContent = `Additional Fare`;
          document.getElementById('summary-additional-val').textContent = `TBC`;

          document.getElementById('summary-driver-bata-label').textContent = `Driver Bata`;
          document.getElementById('summary-driver-bata-val').textContent = `TBC`;

          document.getElementById('summary-total-amount-val').textContent = `TBC`;

          renderSummaryStatus(summarySuccessMsg, '');
          renderSummaryStatus(summaryErrorMsg, '');
          confirmationBox?.classList.add('is-hidden');
          summaryWhatsappBtn?.classList.add('is-hidden');
          summaryConfirmBtn.hidden = false;
          summaryConfirmBtn.disabled = false;
          summaryConfirmLabel.hidden = false;
          summaryConfirmSpinner.hidden = true;
          summaryPanel?.classList.remove('is-hidden');
        });

        resultsGrid.appendChild(card);
        hideForm();
        card.querySelector('.estimate-select-btn')?.click();
      };

      const fetchDistanceAndEstimate = async () => {
        const pLat = pickupLatInput.value;
        const pLng = pickupLngInput.value;
        const dLat = dropLatInput.value;
        const dLng = dropLngInput.value;

        // Try using Google distance matrix if we have coordinates
        if (pLat && pLng && dLat && dLng) {
          try {
            const params = new URLSearchParams({ p_lat: pLat, p_lng: pLng, d_lat: dLat, d_lng: dLng });
            const response = await fetch(`distance.php?${params}`, { headers: { Accept: 'application/json' } });
            const payload  = await response.json();
            if (response.ok && payload.distance_km) {
              distanceInput.value = payload.distance_km;
              calculateEstimates(Number(payload.distance_km));
              return;
            }
          } catch (err) {
            console.warn('Distance Matrix call failed, trying fallback...', err);
          }
        }

        // Fallback: Check predefined distances
        const pName = pickupInput.value.trim().toLowerCase();
        const dName = dropInput.value.trim().toLowerCase();
        const routeKey = `${pName}-${dName}`;

        if (PREDEFINED_DISTANCES[routeKey]) {
          const dist = PREDEFINED_DISTANCES[routeKey];
          distanceInput.value = dist;
          calculateEstimates(dist);
          return;
        }

        throw new Error('Distance calculation offline.');
      };

      const syncTripTypeFields = () => {
        const isRoundTrip = bookingForm.querySelector('input[name="trip_type"]:checked')?.value === 'two-way';
        tripDaysField.hidden    = !isRoundTrip;
        tripDaysInput.required  = isRoundTrip;
        if (!isRoundTrip) { tripDaysInput.value = ''; tripDaysInput.setCustomValidity(''); }
      };

      syncTripTypeFields();

      // Auto-fill coordinates on page load for PHP pre-filled fields
      autoFillCoordinates('pickup');
      autoFillCoordinates('drop');

      mobileInput.addEventListener('input', () => { mobileInput.value = mobileInput.value.replace(/\D/g, '').slice(0, 10); mobileInput.setCustomValidity(''); });
      pickupInput.addEventListener('input', () => { clearPlaceCoordinates('pickup'); autoFillCoordinates('pickup'); });
      dropInput.addEventListener('input',   () => { clearPlaceCoordinates('drop'); autoFillCoordinates('drop'); });
      emailInput.addEventListener('input',  () => emailInput.setCustomValidity(''));
      tripDaysInput.addEventListener('input',() => tripDaysInput.setCustomValidity(''));
      tripTypeInputs.forEach((i) => i.addEventListener('change', syncTripTypeFields));
      if (backToFormBtn) backToFormBtn.addEventListener('click', showForm);
      if (summaryWhatsappBtn) {
        summaryWhatsappBtn.addEventListener('click', () => {
          if (currentBookingPayload) openWhatsApp(currentBookingPayload);
        });
      }
      if (summaryConfirmBtn) {
        summaryConfirmBtn.addEventListener('click', async () => {
          if (!currentBookingPayload) return;

          summaryConfirmLabel.hidden = true;
          summaryConfirmSpinner.hidden = false;
          summaryConfirmBtn.disabled = true;
          renderSummaryStatus(summarySuccessMsg, '');
          renderSummaryStatus(summaryErrorMsg, '');

          try {
            const res = await fetch('send_booking.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
              body: JSON.stringify(currentBookingPayload),
            });
            const json = await res.json();
            if (!res.ok || !json.success) throw new Error(json.error || 'Could not save the booking.');

            currentBookingPayload.booking_id = json.booking_id || '';
            document.getElementById('summary-booking-id').textContent = json.booking_id || '-';
            document.getElementById('summary-confirm-name').textContent = currentBookingPayload.name || '-';
            document.getElementById('summary-confirm-vehicle').textContent = currentBookingPayload.vehicle_name || currentBookingPayload.vehicle || '-';
            document.getElementById('summary-confirm-fare').textContent = inr(currentBookingPayload.total_fare || 0);

            confirmationBox?.classList.remove('is-hidden');
            summaryWhatsappBtn?.classList.remove('is-hidden');
            summaryConfirmBtn.hidden = true;

            const successParts = ['Booking saved successfully.'];
            if (json.booking_id) successParts.push(`Booking ID: ${json.booking_id}`);
            if (!json.customer_sent || !json.business_sent) successParts.push('Email delivery is pending, but the booking is stored.');
            renderSummaryStatus(summarySuccessMsg, successParts.join(' '));

            if (json.success_url) {
              window.location.href = json.success_url;
            }
          } catch (err) {
            renderSummaryStatus(summaryErrorMsg, err.message || 'Could not save the booking. Please try again.');
            summaryConfirmLabel.hidden = false;
            summaryConfirmSpinner.hidden = true;
            summaryConfirmBtn.disabled = false;
          }
        });
      }

      const initialTripType = bookingForm.querySelector('input[name="trip_type"]:checked')?.value || 'one-way';
      const initialTripDays = initialTripType === 'two-way' ? Math.max(1, Number(tripDaysInput.value || 1)) : 1;
      resultsGrid?.querySelectorAll('.estimate-card').forEach((card) => {
        const button = card.querySelector('.estimate-select-btn');
        if (!button) return;
        const item = {
          vehicleCode: card.dataset.vehicle || '',
          vehicleName: card.dataset.vehicleName || card.querySelector('h4')?.textContent || '',
          baseFare: Number(card.dataset.baseFare || 0),
          perKm: Number(card.dataset.perKm || 0),
          driverAllowance: Number(card.dataset.driverAllowance || 0),
          travelDistance: Number(card.dataset.travelDistance || 0),
          estimatedFare: Number(card.dataset.estimatedFare || 0),
        };
        button.addEventListener('click', () => {
          if (selectedEstimateCard) selectedEstimateCard.classList.remove('selected');
          selectedEstimateCard = card;
          selectedEstimateCard.classList.add('selected');

          const nameVal = document.getElementById('name')?.value || '-';
          const emailVal = document.getElementById('email')?.value || '-';
          const mobileVal = mobileInput.value || '-';
          const pickupVal = pickupInput.value || '-';
          const dropVal = dropInput.value || '-';
          const dateVal = document.getElementById('date')?.value || '-';
          const timeVal = document.getElementById('time')?.value || '-';
          populateBookingSummary(item, {
            name: nameVal,
            email: emailVal,
            mobile: mobileVal,
            pickup: pickupVal,
            drop: dropVal,
            date: dateVal,
            time: timeVal,
            tripType: initialTripType,
            tripDays: initialTripDays,
          });
        });
      });

      if (resultsGrid?.querySelectorAll('.estimate-card').length === 1) {
        resultsGrid.querySelector('.estimate-card .estimate-select-btn')?.click();
      }

      bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        mobileInput.setCustomValidity('');
        emailInput.setCustomValidity('');
        tripDaysInput.setCustomValidity('');
        pickupInput.setCustomValidity('');
        dropInput.setCustomValidity('');
        distanceInput.setCustomValidity('');

        if (!/^[6-9][0-9]{9}$/.test(mobileInput.value)) mobileInput.setCustomValidity('Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.');
        if (emailInput.value.trim() !== '') {
          if (emailInput.validity.typeMismatch) {
            emailInput.setCustomValidity('Enter a valid email address.');
          } else {
            emailInput.setCustomValidity('');
          }
        } else {
          emailInput.setCustomValidity('');
        }
        if (!tripDaysField.hidden) {
          if (tripDaysInput.validity.valueMissing) tripDaysInput.setCustomValidity('Enter the number of days for the round trip.');
          else if (Number(tripDaysInput.value) < 1) tripDaysInput.setCustomValidity('Days must be at least 1.');
        }
        if (!pickupInput.value.trim()) pickupInput.setCustomValidity('Enter the pickup location.');
        else pickupInput.setCustomValidity('');

        if (!dropInput.value.trim()) dropInput.setCustomValidity('Enter the drop location.');
        else dropInput.setCustomValidity('');

        if (!bookingForm.checkValidity()) { bookingForm.reportValidity(); renderMessage(errorMessage, 'Please correct the highlighted form fields.'); renderMessage(successMessage, ''); return; }

        try {
          renderMessage(errorMessage, '');
          renderMessage(successMessage, '');
          await fetchDistanceAndEstimate();
        } catch (err) {
          console.warn(err);
          showFallbackEstimate();
        }
      });
    }

    if (menuToggle && primaryNav && navShell) {
      const navLinks = primaryNav.querySelectorAll('a');
      menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
        menuToggle.setAttribute('aria-expanded', String(!isOpen));
        navShell.classList.toggle('menu-open', !isOpen);
      });
      navLinks.forEach((link) => link.addEventListener('click', () => {
        menuToggle.setAttribute('aria-expanded', 'false');
        navShell.classList.remove('menu-open');
      }));
    }
  </script>

  <?php if ($googleMapsApiKey !== ''): ?>
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?= htmlspecialchars($googleMapsApiKey, ENT_QUOTES, 'UTF-8') ?>&libraries=places&callback=initGooglePlaces"></script>
  <?php endif; ?>
</body>
</html>
