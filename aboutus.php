<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - HillSagar</title>
  <meta name="description" content="Learn more about HillSagar, our vision, and our mission to connect travelers with India's majestic hills and serene beaches.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <!-- Header -->
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
        <li><a href="index.php">Home</a></li>

       
      </ul>
    </nav>

    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>


  <!-- About Section -->
  <main>
    <section id="about" aria-label="About section">
      <div class="container">
        <div class="section-header">
          <h2>About HillSagar</h2>
          <p>Discover who we are, our journey, and why we’re passionate about travel in India.</p>
        </div>

        <div class="destination-grid">
          <!-- About Story -->
          <div class="destination-card">
            <div class="card-content">
              <h3>Our Story</h3>
              <p>
                HillSagar was founded with a vision to bring travelers closer to the breathtaking beauty of India’s 
                landscapes. From the snow-kissed peaks of the Himalayas to the golden sands of Goa, 
                we curate travel experiences that inspire adventure and relaxation alike.
              </p>
              <p>
                What started as a small travel blog has now become a trusted platform for explorers around the globe. 
                Our guides, tips, and recommendations help people create memories that last a lifetime.
              </p>
            </div>
          </div>

          <!-- Mission & Vision -->
          <div class="destination-card">
            <div class="card-content">
              <h3>Our Mission & Vision</h3>
              <p>
                <strong>Mission:</strong> To connect travelers with India’s most authentic destinations 
                while promoting sustainable and responsible tourism.
              </p>
              <p>
                <strong>Vision:</strong> To become India’s most loved travel platform where every explorer finds 
                their perfect journey — be it in the hills, on the beaches, or hidden gems in between.
              </p>
            </div>
          </div>
        </div>

        <!-- Our Team -->
        <div class="section-header">
          <h2>Meet Our Team</h2>
          <p>The passionate explorers and storytellers behind HillSagar</p>
        </div>
        <div class="destination-grid">
          <div class="destination-card">
            <div class="card-image">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Founder">
            </div>
            <div class="card-content">
              <h3>Rohan Mehta</h3>
              <p>Founder & Travel Enthusiast</p>
            </div>
          </div>
          <div class="destination-card">
            <div class="card-image">
              <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Co-Founder">
            </div>
            <div class="card-content">
              <h3>Aditi Sharma</h3>
              <p>Co-Founder & Photographer</p>
            </div>
          </div>
          <div class="destination-card">
            <div class="card-image">
              <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Content Lead">
            </div>
            <div class="card-content">
              <h3>Vikram Singh</h3>
              <p>Content Lead & Storyteller</p>
            </div>
          </div>
        </div>

      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-column">
          <h3>About HillSagar</h3>
          <p>Discover India's most beautiful hill stations and pristine beaches with our expertly curated travel guides and recommendations.</p>
        </div>
        <div class="footer-column">
          <h3>Quick Links</h3>
          <p><a href="hills.php">Hill Stations</a></p>
          <p><a href="index.php#beaches">Beaches</a></p>
          <p><a href="index.php#featured">Featured Destinations</a></p>
          <p><a href="index.php#testimonials">Testimonials</a></p>
        </div>
        <div class="footer-column">
          <h3>Contact Us</h3>
          <p><i class="fas fa-envelope"></i> info@hillsagar.com</p>
          <p><i class="fas fa-phone"></i> +91 9876543210</p>
          <p><i class="fas fa-map-marker-alt"></i> Mumbai, India</p>
        </div>
      </div>

      <div class="footer-nav">
        <a href="aboutus.php" class="active">About Us</a>
        <a href="blog.php">Travel Blog</a>
        <a href="contact.php">Contact</a>
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms of Service</a>
      </div>

      <div class="copyright">
        <p>&copy; 2023 HillSagar. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="main.js"></script>
</body>
</html>
