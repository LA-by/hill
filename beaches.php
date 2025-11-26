<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';

// Logged-in check
$isLoggedIn = isset($_SESSION['user_id']);

// Fetch all beach packages from DB
$sql = "SELECT id, title, price, duration, image, state 
        FROM packages 
        WHERE package_type = 'beach'
        ORDER BY id DESC";
$result = $mysqli->query($sql);

$beaches = [];
while ($row = $result->fetch_assoc()) {
    $beaches[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HillSagar • Beaches in India</title>
  <meta name="description" content="Explore India's most beautiful beaches — turquoise waters, palm trees, sunsets, surfing, and peaceful coastlines across India." />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="main.css" />

<style>
.page-hero{
  background:linear-gradient(rgba(0,0,0,.4),rgba(0,0,0,.4));
  background-size:cover;background-position:center;
  text-align:center;color:var(--white);
  padding:15rem 1rem;height:90vh;position:relative;overflow:hidden;
}
.hero-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:-1;}
.page-hero h1{font-size:2.8rem;margin-bottom:.75rem}
.page-hero p{max-width:800px;margin:0 auto;font-size:1.1rem}

/* Filters */
.filters{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:2rem;}
.filter-card{background:var(--card-bg);border:var(--border);border-radius:var(--border-radius);padding:1rem;box-shadow:var(--shadow);}
.filter-card label{font-weight:700;color:var(--primary-color);}
.filter-card input,.filter-card select{width:100%;padding:.8rem;border-radius:12px;border:1px solid rgba(0,0,0,.1);}

/* Cards */
.badge{position:absolute;top:10px;left:10px;background:rgba(0,0,0,.55);color:#fff;padding:.35rem .6rem;border-radius:999px;font-size:.8rem;}
.card-image{position:relative;}

.book-now-btn{
  background:linear-gradient(45deg,var(--primary-color),#21867a);
  color:white;border:none;padding:12px 24px;border-radius:25px;font-weight:600;
  transition:.3s;cursor:pointer;display:inline-flex;align-items:center;gap:8px;
}
.book-now-btn:hover{transform:translateY(-2px);}
</style>
</head>

<body>

<header class="main-header">
  <div class="navbar container">

    <div class="slogan">
      <p style="font-size: xx-large;color:black;text-decoration: underline overline;"><strong>Hill Sagar</strong></p>
      Where Mountains Meet the Sea
    </div>

    <nav class="nav-links">
      <ul>
        <li><a href="hills.php">Hill Stations</a></li>
        <li><a href="contact.php">Contact</a></li>
        

        <?php if (!isUserLoggedIn()): ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php else: ?>
          <li><a href="user_home.php">My Page</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
        <li><a href="index.php">Home</a></li> 
      </ul>
    </nav>

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
    <h1>India’s Breathtaking Beaches</h1>
    <p>Golden sands, coconut trees, chill breeze & unforgettable coastal escapes.</p>
     <a href="#featured" class="cta-button">Explore Destinations</a>
  </div>
</section>

<section class="container">
  <div class="section-header">
    <h2>Top Beach Destinations in India</h2>
    <p>Search & filter beaches by state to find your perfect ocean getaway</p>
  </div>

  <!-- Filters -->
  <div class="filters">
    <div class="filter-card">
      <label for="search">Search place</label>
      <input type="search" id="search" placeholder="e.g., Goa, Varkala, Gokarna…" />
    </div>

    <div class="filter-card">
      <label for="state">State</label>
      <select id="state">
        <option value="">All</option>
        <option>Goa</option>
        <option>Kerala</option>
        <option>Tamil Nadu</option>
        <option>Karnataka</option>
        <option>Maharashtra</option>
        <option>Andaman & Nicobar</option>
        <option>Odisha</option>
        <option>Gujarat</option>
        <option>West Bengal</option>
        <option>Andhra Pradesh</option>
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
// ✅ Dark Mode Load + Toggle
const themeToggle=document.getElementById("themeToggle");
const savedTheme=localStorage.getItem("hs-theme");

if(savedTheme==="dark"){
  document.body.classList.add("dark-theme");
}

themeToggle.addEventListener("click",()=>{
  document.body.classList.toggle("dark-theme");

  if(document.body.classList.contains("dark-theme")){
    localStorage.setItem("hs-theme","dark");
  } else {
    localStorage.setItem("hs-theme","light");
  }
});

// ✅ PHP → JS DB Data
const BEACHES = <?= json_encode($beaches) ?>;
const loggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

const grid=document.getElementById('cards');
const search=document.getElementById('search');
const stateSel=document.getElementById('state');
const results=document.getElementById('resultsCount');

// ✅ Render DB Cards
function render(){
  const q=(search.value||'').toLowerCase();
  const st=stateSel.value;

  const filtered=BEACHES.filter(b=>
    (!q || b.title.toLowerCase().includes(q)) &&
    (!st || b.state === st)
  );

  grid.innerHTML=filtered.map(b=>{
    const img = b.image ? `uploads/${b.image}` : "images/beach.jpg";
    const url = loggedIn ? `book_package.php?id=${b.id}` : "login.php";

    return `
    <article class="destination-card">
      <div class="card-image">
        <span class="badge">${b.state}</span>
        <img loading="lazy" src="${img}" alt="${b.title}">
      </div>
      <div class="card-content">
        <h3>${b.title}</h3>
        <p>Duration: ${b.duration}</p>
        <div class="card-meta"><span class="rating">₹${b.price}</span></div>

        <div class="card-actions">
          <a href="${url}" class="book-now-btn">
            <i class="fas fa-calendar-plus"></i> Book Now
          </a>
        </div>
      </div>
    </article>`;
  }).join('');

  results.textContent=`${filtered.length} beach${filtered.length===1?'':'es'} shown`;
}

// ✅ Enable search + filter
[search, stateSel].forEach(el=>el.addEventListener('input',render));
render();
</script>

</body>
</html>
