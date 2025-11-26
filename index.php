<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

// ✅ Featured Packages (6)
$featured = $mysqli->query("
    SELECT id, title, price, duration, image 
    FROM packages 
    ORDER BY id DESC LIMIT 6
");

// ✅ Hill Packages (6 only)
$hills = $mysqli->query("
    SELECT id, title, price, duration, image, state
    FROM packages
    WHERE package_type='hill_station'
    ORDER BY id DESC LIMIT 6
");

// ✅ Beach Packages (6 only)
$beaches = $mysqli->query("
    SELECT id, title, price, duration, image, state
    FROM packages
    WHERE package_type='beach'
    ORDER BY id DESC LIMIT 6
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HillSagar - Explore India's Majestic Hills & Serene Beaches</title>
<meta name="description" content="Discover India's most beautiful hill stations and pristine beaches with HillSagar. Book your travel packages now.">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="main.css">
</head>

<body>

<!-- ✅ NAVBAR -->
<header class="main-header">
  <div class="navbar container">

    <div class="slogan">
      <p style="font-size: xx-large;color:black;text-decoration: underline overline;"><strong>Hill Sagar</strong></p>
      Where Mountains Meet the Sea
    </div>

    <nav class="nav-links">
      <ul>
        <li><a href="#hills">Hill Stations</a></li>
        <li><a href="#beaches">Beaches</a></li>
        <li><a href="#featured">Destinations</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="contact.php">Contact</a></li>

        <?php if (!isUserLoggedIn()): ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php else: ?>
          <li><a href="user_home.php">My Page</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>

<main>

<!-- ✅ HERO SECTION WITH VIDEO -->
<section id="hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="images/backgrounds.mp4" type="video/mp4">
  </video>

  <div class="hero-content">
    <h2>Discover India's Natural Wonders</h2>
    <p>From the Himalayas to Golden Sandy Beaches — Explore the Beauty of India.</p>
    <a href="#featured" class="cta-button">Explore Destinations</a>
  </div>
</section>

<!-- ✅ FEATURED PACKAGES -->
<section id="featured">
  <div class="container">
    <div class="section-header">
      <h2>Featured Travel Packages</h2>
      <p>Top recommended destinations curated for you</p>
    </div>

    <div class="destination-grid">
      <?php while($row = $featured->fetch_assoc()): ?>
      <article class="destination-card">
        <div class="card-image">
         <img src="<?= !empty($row['image']) ? 'images/'.$row['image'] : 'images/default.jpg' ?>" 
     alt="<?= htmlspecialchars($row['title']); ?>">

        </div>

        <div class="card-content">
          <h3><?= htmlspecialchars($row['title']); ?></h3>
          <p>Duration: <?= htmlspecialchars($row['duration']); ?></p>
          <div class="card-meta">
            <span class="rating">₹<?= htmlspecialchars($row['price']); ?></span>
            <a href="<?= isUserLoggedIn() ? 'book_package.php?id='.$row['id'] : 'login.php' ?>" class="cta-button">
              Book Now
            </a>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- ✅ HILL STATION SECTION -->
<section id="hills">
  <div class="container">
    <div class="section-header">
      <h2>India's Enchanting Hill Stations</h2>
      <p>Breathtaking mountain retreats perfect for relaxation & adventure</p>
    </div>

    <!-- ✅ Search Hills -->
  

    <div class="destination-grid">
      <?php while($row = $hills->fetch_assoc()): ?>
      <article class="destination-card hill-card">
        <div class="card-image">
          <img src="<?= !empty($row['image']) ? 'uploads/'.$row['image'] : 'images/shimla.jpg' ?>" 
               alt="<?= htmlspecialchars($row['title']); ?>">
        </div>

        <div class="card-content">
          <h3><?= htmlspecialchars($row['title']); ?></h3>
          <p><?= htmlspecialchars($row['state']); ?></p>
          <div class="card-actions">
            <a href="<?= isUserLoggedIn() ? 'book_package.php?id='.$row['id'] : 'login.php' ?>" class="book-now-btn">
              <i class="fas fa-calendar-plus"></i> Book Now
            </a>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

    <a href="hills.php" class="see-more">View All Hill Stations <i class="fas fa-arrow-right"></i></a>
  </div>
</section>

<!-- ✅ BEACHES SECTION -->
<section id="beaches">
  <div class="container">
    <div class="section-header">
      <h2>India's Pristine Beaches</h2>
      <p>Sunny coastlines, turquoise waters, unforgettable memories</p>
    </div>

    <!-- ✅ Search Beaches -->

    <div class="destination-grid">
      <?php while($row = $beaches->fetch_assoc()): ?>
      <article class="destination-card beach-card">
        <div class="card-image">
          <img src="<?= !empty($row['image']) ? 'uploads/'.$row['image'] : 'images/beach.jpg' ?>" 
               alt="<?= htmlspecialchars($row['title']); ?>">
        </div>

        <div class="card-content">
          <h3><?= htmlspecialchars($row['title']); ?></h3>
          <p><?= htmlspecialchars($row['state']); ?></p>
          <div class="card-actions">
            <a href="<?= isUserLoggedIn() ? 'book_package.php?id='.$row['id'] : 'login.php' ?>" class="book-now-btn">
              <i class="fas fa-calendar-plus"></i> Book Now
            </a>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

    <a href="beaches.php" class="see-more">View All Beaches <i class="fas fa-arrow-right"></i></a>
  </div>
</section>

<section id="featured" aria-label="Featured destinations">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Destinations</h2>
                    <p>Discover these unique destinations that offer both mountain and coastal experiences</p>
                </div>
                <div class="featured-grid">
                    <div class="featured-item">
                        <img src="images/croog" alt="Coffee plantations in Coorg">
                        <div class="featured-caption">Coorg - Scotland of India</div>
                    </div>
                    <div class="featured-item">
                        <img src="images/pondychery.jpeg" alt="French quarter in Pondicherry">
                        <div class="featured-caption">Pondicherry - French Riviera of the East</div>
                    </div>
                    <div class="featured-item">
                        <img src="images/alleppy" alt="Houseboats in Alleppey">
                        <div class="featured-caption">Alleppey - Venice of the East</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" aria-label="Traveler testimonials">
            <div class="container">
                <div class="section-header">
                    <h2>What Our Travelers Say</h2>
                    <p>Hear from travelers who have explored India's diverse landscapes with us</p>
                </div>
                <div class="testimonial-grid">
                    <div class="testimonial">
                        <p>"HillSagar helped me discover hidden gems in the Himalayas I never knew existed! The recommendations were spot on and made my trip unforgettable."</p>
                        <footer>- vladimir putin, Russia</footer>
                    </div>
                    <div class="testimonial">
                        <p>"The beach recommendations were perfect - I found my ideal quiet getaway in Goa. The travel guides were incredibly helpful for a solo traveler like me."</p>
                        <footer>- kim-jong-un, N.korea</footer>
                    </div>
                    <div class="testimonial">
                        <p>"As a photography enthusiast, HillSagar helped me find the most picturesque locations in Kerala. The golden hour at Kovalam beach was magical!"</p>
                        <footer>- Donald Trup, USA</footer>
                    </div>
                </div>
            </div>
        </section>

        <section id="newsletter">
            <div class="container">
                <div class="section-header">
                    <h2>Get Travel Inspiration</h2>
                    <p>Subscribe to our newsletter for exclusive travel tips and destination guides</p>
                </div>
                <form>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your email address" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </section>
</main>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>About HillSagar</h3>
                <p>Discover India's most beautiful hill stations and beaches with curated guides & travel insights.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <p><a href="#hills">Hill Stations</a></p>
                <p><a href="#beaches">Beaches</a></p>
                <p><a href="#packages">Travel Packages</a></p>
                <p><a href="user_dashboard.php">My Dashboard</a></p>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <p><i class="fas fa-envelope"></i> info@hillsagar.com</p>
                <p><i class="fas fa-phone"></i> +91 9876543210</p>
                <p><i class="fas fa-map-marker-alt"></i> Mumbai, India</p>
            </div>
        </div>
        
        <div class="footer-nav">
            <a href="aboutus.php">About Us</a>
            <a href="blog.php">Travel Blog</a>
            <a href="contact.php">Contact</a>
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms of Service</a>
        </div>

        <div class="copyright">
            <p><strong>&copy; 2023 HillSagar. All rights reserved.</strong></p>
        </div>
    </div>
</footer>

  <button class="back-to-top" id="toTop" aria-label="Back to top" title="Back to top" style="display:none"><i class="fa-solid fa-arrow-up"></i></button>

<!-- ✅ SEARCH FILTER SCRIPT -->
<script>
// ✅ Hill Search Filter
document.getElementById("hillSearch").addEventListener("input", function() {
  const query = this.value.toLowerCase();
  document.querySelectorAll(".hill-card").forEach(card => {
    const text = card.innerText.toLowerCase();
    card.style.display = text.includes(query) ? "block" : "none";
  });
});

// ✅ Beach Search Filter
document.getElementById("beachSearch").addEventListener("input", function() {
  const query = this.value.toLowerCase();
  document.querySelectorAll(".beach-card").forEach(card => {
    const text = card.innerText.toLowerCase();
    card.style.display = text.includes(query) ? "block" : "none";
  });
});
</script>

<script src="main.js"></script>

</body>
</html>
