<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

// Logged-in check
$isLoggedIn = isset($_SESSION['user_id']);

// Fetch all hill packages
$sql = "SELECT id, title, price, duration, image, state 
        FROM packages 
        WHERE package_type = 'hill_station' 
        ORDER BY id DESC";
$result = $mysqli->query($sql);

$hills = [];
while ($row = $result->fetch_assoc()) {
    $hills[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>HillSagar • Hill Stations in India</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="main.css" />

<style>
.page-hero {
  background: linear-gradient(rgba(0,0,0,.4),rgba(0,0,0,.4));
  background-size: cover;
  background-position: center;
  color: var(--white);
  text-align: center;
  padding: 15rem 1rem;
  border-radius: var(--border-radius);
  position: relative;
  overflow: hidden;
  height: 90vh;
}
.hero-video {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
}
.page-hero h1 {
  color: var(--white);
  font-size: 2.8rem;
  margin-bottom: .75rem;
}
.page-hero p {
  max-width: 800px;
  margin: 0 auto;
  opacity: .95;
  font-size: 1.15rem;
}

.destination-card img {
  width: 100%;
  height: 240px;
  object-fit: cover;
  border-radius: 14px;
}

.badge {
  position: absolute;
  top: 10px;
  left: 10px;
  background: rgba(0,0,0,.55);
  color: #fff;
  padding: .35rem .6rem;
  border-radius: 999px;
  font-size: .8rem;
}

.card-actions {
  text-align: center;
  margin-top: 15px;
}
.book-now-btn {
  background: linear-gradient(45deg,var(--primary-color),#21867a);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 25px;
  font-weight: 600;
  cursor: pointer;
  transition: .3s;
  display: inline-block;
}
.book-now-btn:hover {
  background: linear-gradient(45deg,#21867a,var(--primary-color));
  transform: translateY(-2px);
}

/* ✅ Filters Wrapper */
.filters {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 1.3rem;
  margin: 2.5rem 0;
}

/* ✅ Filter Card Box */
.filter-card {
  background: var(--card-bg);
  padding: 1.2rem 1rem;
  border-radius: var(--border-radius);
  border: var(--border);
  box-shadow: var(--shadow);
  backdrop-filter: blur(8px);
  transition: transform .3s ease, box-shadow .3s ease;
}

.filter-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 28px rgba(0, 0, 0, .18);
}

/* ✅ Labels */
.filter-card label {
  font-weight: 700;
  font-size: .95rem;
  margin-bottom: .45rem;
  display: block;
  color: var(--primary-color);
}

/* ✅ Inputs & Select */
.filter-card input,
.filter-card select {
  width: 100%;
  padding: .9rem 1rem;
  font-size: .95rem;
  background: rgba(255,255,255,.2);
  border-radius: 14px;
  border: 1px solid rgba(0,0,0,.1);
  color: var(--text-primary);
  outline: none;
  transition: border-color .35s ease, box-shadow .35s ease;
}

/* ✅ Active Glow */
.filter-card input:focus,
.filter-card select:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 12px rgba(44, 120, 108, .45);
}

/* ✅ Placeholder style */
.filter-card input::placeholder {
  color: rgba(0,0,0,.45);
}

/* ✅ Dark Mode Support */
.dark-theme .filter-card input,
.dark-theme .filter-card select {
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.25);
  color: var(--white);
}

.dark-theme .filter-card input::placeholder {
  color: rgba(255,255,255,.45);
}

</style>
</head>

<body>

<header class="main-header">
  <div class="navbar container">
    <div class="slogan">
      <p style="font-size: xx-large;color:black;text-decoration: underline overline;">
        <strong>Hill Sagar</strong>
      </p>
      Where Mountains Meet the Sea
    </div>

    <nav class="nav-links">
      <ul>
        <li><a href="hills.php" class="active">Hill Stations</a></li>
        <li><a href="beaches.php">Beaches</a></li>
        <li><a href="index.php#featured">Destinations</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>

    <!-- ✅ Dark Mode Toggle -->
    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>

<main>

<section class="page-hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="images/backgrounds.mp4" type="video/mp4">
  </video>

  <div class="hero-content">
    <h1>India’s Most Stunning Hill Stations</h1>
    <p>Breathtaking landscapes, fresh mountain air, tea gardens, snowfall & unforgettable adventures.</p>
  </div>
</section>

<section class="container">
  <div class="section-header">
    <h2>Top Hill Destinations in India</h2>
    <p>Search & filter hills by state — find your dream vacation</p>
  </div>

  <div class="filters">
    <div class="filter-card">
      <label for="search">Search place</label>
      <input type="search" id="search" placeholder="e.g., Manali, Shimla, Darjeeling…" />
    </div>

    <div class="filter-card">
      <label for="state">State</label>
      <select id="state">
        <option value="">All</option>
        <option>Himachal Pradesh</option>
        <option>Uttarakhand</option>
        <option>Jammu & Kashmir</option>
        <option>Kerala</option>
        <option>Tamil Nadu</option>
        <option>West Bengal</option>
        <option>Karnataka</option>
        <option>Maharashtra</option>
        <option>Sikkim</option>
      </select>
    </div>
  </div>

  <div class="destination-grid" id="cards"></div>
  <p id="resultsCount" style="margin-top:1rem"></p>
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

<script>
// ✅ Dark Mode
const savedTheme = localStorage.getItem("hs-theme");
if(savedTheme === "dark") document.body.classList.add("dark-theme");
document.getElementById("themeToggle").addEventListener("click",()=>{
  document.body.classList.toggle("dark-theme");
  localStorage.setItem("hs-theme",document.body.classList.contains("dark-theme") ? "dark" : "light");
});

// ✅ HD Image Mapping
const STOCK_IMAGES = {
  "Manali": "https://images.unsplash.com/photo-1553342385-1111c7a3b55c",
  "Shimla": "https://images.unsplash.com/photo-1582738412060-82c5be1f4a32",
  "Darjeeling": "https://images.unsplash.com/photo-1602416013467-3b6c6b6ad720",
  "Ooty": "https://images.unsplash.com/photo-1531384441138-2736e62e0919",
  "Munnar": "https://images.unsplash.com/photo-1549289524-06cf8837ace1",
  "Nainital": "https://images.unsplash.com/photo-1638029481961-7eac12f90b43",
  "Gangtok": "https://images.unsplash.com/photo-1614160127239-81cbef6cd532",
  "Leh Ladakh": "https://images.unsplash.com/photo-1505236731862-76ad1d6d35a4"
};

const HILLS = <?= json_encode($hills) ?>;
const loggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

const grid=document.getElementById('cards');
const search=document.getElementById('search');
const stateSel=document.getElementById('state');
const results=document.getElementById('resultsCount');

// ✅ Render Cards
function render(){
  const q=(search.value||'').toLowerCase();
  const st=stateSel.value;

  const filtered=HILLS.filter(h=>
    (!q || h.title.toLowerCase().includes(q)) &&
    (!st || h.state === st)
  );

  grid.innerHTML=filtered.map(h=>{
    const img = h.image && h.image.trim() !== ""
      ? `uploads/${h.image}`
      : (STOCK_IMAGES[h.title] || "https://images.unsplash.com/photo-1501785888041-af3ef285b470");

    const url = loggedIn ? `book_package.php?id=${h.id}` : "login.php";

    return `
    <article class="destination-card">
      <div class="card-image">
        <span class="badge">${h.state}</span>
        <img loading="lazy" src="${img}" alt="${h.title}">
      </div>
      <div class="card-content">
        <h3>${h.title}</h3>
        <p>Duration: ${h.duration}</p>
        <div class="card-meta"><span class="rating">₹${h.price}</span></div>
        <div class="card-actions">
          <a href="${url}" class="book-now-btn">
            <i class="fas fa-calendar-plus"></i> Book Now
          </a>
        </div>
      </div>
    </article>`;
  }).join('');

  results.textContent=`${filtered.length} hill station${filtered.length===1?'':'s'} shown`;
}

// ✅ Search + Filter live updates
[search, stateSel].forEach(el=>el.addEventListener('input',render));
render();
</script>

</body>
</html>
