<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HillSagar - Explore India's Majestic Hills & Serene Beaches</title>
    <meta name="description" content="Discover India's most beautiful hill stations and pristine beaches with HillSagar. Plan your perfect getaway with our travel guides and recommendations.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="main.css">
       
</head>
<body>
<header class="main-header">
  <div class="navbar container">
    
    <!-- Left: Slogan -->
    
    <div class="slogan">
    <div class="hill.sagar"><p style="font-size: xx-large ;color: rgb(0, 0, 0); text-decoration: underline overline;"><strong>Hill Sagar</strong></p></div>
      Where Mountains Meet the Sea
    </div>

    <!-- Center: Navigation -->
    <nav class="nav-links" aria-label="Main navigation">
      <ul>
        <li><a href="#hills">Hill Stations</a></li>
        <li><a href="#beaches">Beaches</a></li>
        <li><a href="#featured">Destinations</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>

    <!-- Right: Dark Mode -->
    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>

  </div>
</header>

<main>
       <main>
        <section id="hero" aria-label="Hero section">
            <!-- Background Video -->
            <video autoplay muted loop playsinline class="hero-video">
            <source src="images/backgrounds .mp4" type="video/mp4">
            Your browser does not support the video tag.        
            </video>

            <!-- Hero Content -->
            <div class="hero-content">
            <h2>Discover India's Natural Wonders</h2>
            <p>From the snow-capped Himalayas to the golden beaches of Goa, explore the diverse landscapes of India.</p>
            <a href="#featured" class="cta-button">Explore Destinations</a>
            </div>
        </section>
        <section id="hills" aria-labelledby="hills-heading" >
            <div class="container">
                <div class="section-header">
                    <h2 id="hills-heading">India's Enchanting Hill Stations</h2>
                    <p>Escape the heat and explore the cool climes of India's most beautiful mountain retreats.</p>
                </div>
                
                <div class="destination-grid">
                    <article class="destination-card">
                        <div class="card-image slideshow">
                            <img src="images/shimla.jpg" alt="Shimla hill station">
                        </div>

                        <div class="card-content">
                            <div>
                            <h3>Shimla, Himachal Pradesh</h3>
                            <p>The queen of hill stations with colonial charm and panoramic views of the Himalayas.</p>
                            </div>
                            <div class="card-meta">
                            <span class="rating">★ 4.8</span>
                            <span>Best: Oct-Jun</span>
                            </div>
                        </div>
                    </article>

                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/darjeeling.jpg" alt="Darjeeling tea gardens">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Darjeeling, West Bengal</h3>
                                <p>Famous for its tea gardens and stunning views of Kanchenjunga peak.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.7</span>
                                <span>Best: Feb-Mar, Sep-Dec</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/munnar.jpeg" alt="Munnar tea plantations">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Munnar, Kerala</h3>
                                <p>Rolling tea plantations and misty mountains in God's Own Country.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.6</span>
                                <span>Best: Sep-May</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/manali.jpeg" alt="Manali mountains">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Manali, Himachal Pradesh</h3>
                                <p>Adventure capital with snow-capped peaks and lush valleys.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.5</span>
                                <span>Best: Oct-Jun</span>
                            </div>
                        </div>
                    </article>
                    
                    <!-- New Hill Station Cards -->
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/ooty.jpeg" alt="Ooty hill station">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Ooty, Tamil Nadu</h3>
                                <p>Queen of the Nilgiris with botanical gardens and scenic toy train rides.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.7</span>
                                <span>Best: Oct-Jun</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gulmarg meadows">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Gulmarg, Jammu & Kashmir</h3>
                                <p>Famous for its ski resorts and the world's highest gondola ride.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.9</span>
                                <span>Best: Dec-Mar</span>
                            </div>
                        </div>
                    </article>
                </div>
                
                <a href="hills.php" class="see-more">View All Hill Stations <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>

        <section id="beaches" aria-labelledby="beaches-heading" >
            <div class="container">
                <div class="section-header">
                    <h2 id="beaches-heading">India's Pristine Beaches</h2>
                    <p>From party beaches to secluded coves, find your perfect coastal escape.</p>
                </div>
                
                <div class="destination-grid">
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Palolem beach, Goa">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Palolem, Goa</h3>
                                <p>Crescent-shaped beach with calm waters and charming beach huts.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.7</span>
                                <span>Best: Oct-Mar</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/RADHANAGAR" alt="Radhanagar beach, Andaman">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Radhanagar, Andaman</h3>
                                <p>Voted among Asia's best beaches with powdery white sand.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.9</span>
                                <span>Best: Oct-May</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/KOVALAM.jpg" alt="Kovalam beach, Kerala">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Kovalam, Kerala</h3>
                                <p>Three beautiful crescent beaches with lighthouse views.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.5</span>
                                <span>Best: Sep-May</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/varkala" alt="Varkala beach, Kerala">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Varkala, Kerala</h3>
                                <p>Cliff-lined beach with mineral springs and stunning sunsets.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.6</span>
                                <span>Best: Aug-Mar</span>
                            </div>
                        </div>
                    </article>
                    
                    <!-- New Beach Cards -->
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/agonda.jpeg" alt="Agonda beach, Goa">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Agonda, Goa</h3>
                                <p>Serene beach known for its peaceful atmosphere and turtle nesting.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.6</span>
                                <span>Best: Oct-Mar</span>
                            </div>
                        </div>
                    </article>
                    
                    <article class="destination-card">
                        <div class="card-image">
                            <img src="images/tarkarli" alt="Tarkarli beach, Maharashtra">
                        </div>
                        <div class="card-content">
                            <div>
                                <h3>Tarkarli, Maharashtra</h3>
                                <p>Clear blue waters perfect for snorkeling and scuba diving.</p>
                            </div>
                            <div class="card-meta">
                                <span class="rating">★ 4.4</span>
                                <span>Best: Oct-Feb</span>
                            </div>
                        </div>
                    </article>
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

    <script src="main.js">
    </script>
</body>
</html>