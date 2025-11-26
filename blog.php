<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Travel Blog - HillSagar</title>
  <meta name="description" content="Read the latest travel blogs from HillSagar – explore India's hills, beaches, and hidden gems.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="main.css">

  <style>
    /* Blog Styles */
    .blog-full {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease, padding 0.3s ease;
      margin-top: 0;
      padding: 0 15px;
      border-top: 1px solid transparent;
      font-size: 0.95rem;
      line-height: 1.6;
    }
    .blog-full.open {
      max-height: 500px; /* enough space for blog text */
      padding: 15px;
      border-top: 1px solid var(--accent-color);
      margin-top: 10px;
    }
    .see-more {
      display: inline-block;
      margin-top: 10px;
      cursor: pointer;
      background: var(--accent-color);
      color: white;
      padding: 8px 14px;
      border-radius: 6px;
      font-weight: bold;
      transition: 0.3s;
      text-align: center;
    }
    .see-more:hover {
      background: #d99a00; /* darker accent */
    }

    /* Fix: Blog Cards Grid */
    .destination-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }
    .destination-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .destination-card:hover {
      transform: translateY(-5px);
    }
    .card-image img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
  </style>
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


  <!-- Blog Section -->
  <main>
    <section id="blog" aria-label="Travel Blog">
      <div class="container">
        <div class="section-header">
          <h2>HillSagar Travel Blog</h2>
          <p>Explore stories, guides, and tips from India’s most beautiful destinations.</p>
        </div>

        <!-- Blog Grid -->
        <div class="destination-grid">
          
          <!-- Blog Post 1 -->
          <div class="destination-card">
            <div class="card-image">
              <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Manali hills">
            </div>
            <div class="card-content">
              <h3>A Journey to the Heart of Manali</h3>
              <p>Manali is not just a hill station, it’s a paradise. From snow-covered mountains to cozy cafes...</p>
              <a class="see-more" onclick="toggleBlog('blog1', this)">Read More</a>
              <div class="blog-full" id="blog1">
                <p>
                  Manali, nestled in the Kullu Valley of Himachal Pradesh, is one of India`s most 
                  popular hill stations. Surrounded by the mighty Himalayas, it offers everything from 
                  adventure sports like paragliding and skiing to peaceful walks along apple orchards. 
                  Don`t miss visiting Solang Valley, Rohtang Pass, and the charming Old Manali streets 
                  filled with cafes and handicraft shops. Manali is a blend of natural beauty and vibrant 
                  culture, making it a must-visit.
                </p>
              </div>
            </div>
          </div>

          <!-- Blog Post 2 -->
          <div class="destination-card">
            <div class="card-image">
              <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="Goa beach">
            </div>
            <div class="card-content">
              <h3>Goa Beyond Beaches</h3>
              <p>Everyone knows Goa for its beaches, but there’s much more – waterfalls, spice plantations...</p>
              <a class="see-more" onclick="toggleBlog('blog2', this)">Read More</a>
              <div class="blog-full" id="blog2">
                <p>
                  Goa is often thought of as a party destination, but beyond its beaches lies a world 
                  of natural and cultural wonders. Explore the Dudhsagar Waterfalls, take a walk through 
                  centuries-old spice plantations, or visit the Portuguese churches of Old Goa – a UNESCO 
                  World Heritage Site. Don’t forget to try Goan cuisine, from seafood curries to bebinca, 
                  the famous dessert. Goa offers a mix of relaxation, history, and adventure unlike any 
                  other place in India.
                </p>
              </div>
            </div>
          </div>

          <!-- Blog Post 3 -->
          <div class="destination-card">
            <div class="card-image">
              <img src="https://images.unsplash.com/photo-1541364983171-a8ba01e95cfc?auto=format&fit=crop&w=600&q=80" alt="Darjeeling">
            </div>
            <div class="card-content">
              <h3>Darjeeling – The Tea Capital</h3>
              <p>Known for its world-famous tea, Darjeeling offers scenic mountain views and a blend...</p>
              <a class="see-more" onclick="toggleBlog('blog3', this)">Read More</a>
              <div class="blog-full" id="blog3">
                <p>
                  Darjeeling, perched in West Bengal, is often called the “Queen of the Hills.” Famous 
                  for its aromatic tea plantations, the town also offers breathtaking views of Mt. Kanchenjunga, 
                  the world’s third-highest peak. Visitors can take a ride on the historic Darjeeling 
                  Himalayan Railway, a UNESCO World Heritage site. The blend of Tibetan, Nepali, and British 
                  influences is visible in its food, architecture, and festivals. Darjeeling is a peaceful yet 
                  culturally rich escape.
                </p>
              </div>
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
          <p><a href="beaches.php">Beaches</a></p>
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
        <a href="aboutus.php">About Us</a>
        <a href="blog.php" class="active">Travel Blog</a>
        <a href="contact.php">Contact</a>
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms of Service</a>
      </div>

      <div class="copyright">
        <p>&copy; 2023 HillSagar. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- JS for Blog Toggle -->
  <script>
    function toggleBlog(id, btn) {
      const blog = document.getElementById(id);
      blog.classList.toggle("open");
      btn.innerText = blog.classList.contains("open") ? "Read Less" : "Read More";
    }
  </script>
  <script src="main.js"></script>
</body>
</html>
