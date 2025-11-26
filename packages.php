<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

// Logged-in check
$isLoggedIn = isset($_SESSION['user_id']);

// Fetch all packages
$sql = "SELECT id, title, description, price, duration, image FROM packages ORDER BY id DESC";
$result = $mysqli->query($sql);

$packages = [];
while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Travel Packages - HillSagar</title>
<meta name="description" content="Explore hill stations, beaches & travel packages in India.">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="main.css" />

<style>
/* ✅ Search UI */
.search-section {
  background: var(--card-bg);
  padding: 1.4rem;
  margin: 2.5rem auto;
  border-radius: var(--border-radius);
  border: var(--border);
  box-shadow: var(--shadow);
  max-width: 850px;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.search-section input {
  width: 100%;
  padding: .95rem 1.1rem;
  border-radius: 14px;
  font-size: 1rem;
  border: 1px solid rgba(0,0,0,.15);
  background: rgba(255,255,255,0.65);
  transition: .3s ease;
}

.search-section input:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 12px rgba(44,120,108,.4);
}

/* ✅ Search Icon */
.search-icon {
  font-size: 1.4rem;
  color: var(--primary-color);
}

/* ✅ Count Display */
#resultsCount {
  text-align: center;
  margin-top: 1rem;
  font-weight: 600;
  color: var(--primary-color);
}

/* ✅ Dark Mode Support */
.dark-theme .search-section input {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.3);
  color: var(--white);
}
</style>

</head>
<body>

<header class="main-header">
  <div class="navbar container">
    
    <!-- Left: Slogan -->
    <div class="slogan">
      <p style="font-size: xx-large;color:black;text-decoration: underline overline;">
        <strong>Hill Sagar</strong>
      </p>
      Where Mountains Meet the Sea
    </div>

    <!-- Center: Navigation -->
    <nav class="nav-links">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.php">About</a></li>
        <li><a href="packages.php" class="active">Packages</a></li>
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

    <!-- Right: Dark Mode -->
    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>

<main>

<section id="hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="images/backgrounds.mp4" type="video/mp4">
  </video>

  <div class="hero-content">
    <h2>All Travel Packages</h2>
    <p>Find the perfect holiday—mountains, beaches, forests & beyond.</p>
  </div>
</section>

<section class="container">

  <!-- ✅ Live Search -->
  <div class="search-section">
    <i class="fas fa-search search-icon"></i>
    <input type="search" id="searchInput" placeholder="Search packages — e.g., Goa, Manali, Kerala...">
  </div>

  <!-- ✅ Package Grid -->
  <div class="destination-grid" id="cards"></div>

  <p id="resultsCount"></p>
</section>

</main>

 <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About HillSagar</h3>
                    <p>Discover India's most beautiful hill stations and pristine beaches with our expertly curated travel guides and recommendations.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <p><a href="#hills" style="color: black;">Hill Stations</a></p>
                    <p><a href="#beaches" style="color: black;">Beaches</a></p>
                    <p><a href="#featured" style="color: black;">Featured Destinations</a></p>
                    <p><a href="#testimonials" style="color: black;">Testimonials</a></p>
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
                <p style="color: black;"><strong>&copy; 2023 HillSagar. All rights reserved.</strong></p>
            </div>
        </div>
    </footer>

<script>
// ✅ Theme Persistence
const savedTheme = localStorage.getItem("hs-theme");
if(savedTheme === "dark") document.body.classList.add("dark-theme");

document.getElementById("themeToggle").addEventListener("click", () => {
  document.body.classList.toggle("dark-theme");
  localStorage.setItem("hs-theme", 
    document.body.classList.contains("dark-theme") ? "dark" : "light"
  );
});

// ✅ PHP → JS array
const PACKAGES = <?= json_encode($packages) ?>;
const loggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

const grid = document.getElementById("cards");
const searchInput = document.getElementById("searchInput");
const resultsCount = document.getElementById("resultsCount");

// ✅ Render Cards Function
function render() {
  const q = searchInput.value.toLowerCase();

  const filtered = PACKAGES.filter(pkg =>
    pkg.title.toLowerCase().includes(q) ||
    pkg.description.toLowerCase().includes(q)
  );

  grid.innerHTML = filtered.map(p => {
    const img = p.image ? `uploads/${p.image}` : "images/placeholder.jpg";
    const url = loggedIn ? `book_package.php?id=${p.id}` : "login.php";

    return `
    <article class="destination-card">
      <div class="card-image">
        <img src="${img}" alt="${p.title}">
      </div>
      <div class="card-content">
        <h3>${p.title}</h3>
        <p>${p.duration}</p>
        <p>${p.description.substring(0, 120)}...</p>
        <div class="card-meta">
          <span class="rating">₹${p.price}</span>
          <a href="${url}" class="cta-button">Book Now</a>
        </div>
      </div>
    </article>
    `;
  }).join('');

  resultsCount.textContent = `${filtered.length} package${filtered.length !== 1 ? 's' : ''} found`;
}

searchInput.addEventListener("input", render);
render();
</script>

</body>
</html>
