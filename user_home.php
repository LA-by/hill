<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/db.php';
requireUserLogin();

$name = $_SESSION['user_name'] ?? 'User';
$photo = $_SESSION['user_photo'] ?? null;
$packages = $mysqli->query("SELECT id, title, price, duration, image FROM packages ORDER BY id DESC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HillSagar - Welcome <?php echo htmlspecialchars($name); ?></title>
    <meta name="description" content="Welcome to your personalized travel experience with HillSagar. Discover and book amazing travel packages.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="main.css">

<style>
/* ✅ Flexible card layout so button stays bottom */
.destination-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 8px;
}

.card-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-desc {
    font-size: 14px;
    margin: 6px 0;
    color: #555;
    line-height: 1.4;
}

/* ✅ Rating & Best Time Row */
.card-meta {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    margin-top: auto;
    padding-bottom: 8px;
}

.rating {
    font-weight: bold;
    color: #e4a11b;
}

/* ✅ Bottom-centered Book Now Button */
.book-bottom-btn {
    background: var(--primary-color, #2c786c);
    color: white;
    padding: 10px 22px;
    border-radius: 28px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    margin: 10px auto 0;
    display: block;
    transition: 0.25s ease-in-out;
}

.book-bottom-btn:hover {
    background: var(--secondary-color, #004445);
}
</style>

</head>
<body>
<header class="main-header">
  <div class="navbar container">
    
    <div class="slogan">
      <div class="hill.sagar"><p style="font-size: xx-large;color:black;text-decoration:underline overline;"><strong>Hill Sagar</strong></p></div>
      Where Mountains Meet the Sea
    </div>

    <nav class="nav-links">
      <ul>
        
        <li><a href="user_dashboard.php">Dashboard</a></li>
        <li><a href="packages.php">All Packages</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>

    <div class="user-profile">
        <?php if ($photo): ?>
            <img src="uploads/<?php echo htmlspecialchars($photo); ?>" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
        <?php endif; ?>
        <span style="color:#000;font-weight:bold;">Welcome, <?php echo htmlspecialchars($name); ?>!</span>
    </div>
  </div>
</header>

<main>
<section id="hero">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="images/backgrounds.mp4" type="video/mp4">
    </video>
    <div class="hero-content">
        <h2>Welcome Back, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>Ready for your next adventure? Explore our curated travel packages and book your perfect getaway.</p>
        <a href="#packages" class="cta-button">View Packages</a>
    </div>
</section>
        
<section id="packages">
    <div class="container">
        <div class="section-header">
            <h2>Available Travel Packages</h2>
            <p>Choose from our handpicked selection of amazing destinations</p>
        </div>
        <div class="destination-grid">
            <?php while($row = $packages->fetch_assoc()): ?>
                <article class="destination-card">
                    <div class="card-image">
                        <img src="<?php echo !empty($row['image']) ? 'uploads/'.htmlspecialchars($row['image']) : 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&w=1600&q=90'; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="card-desc">A curated travel escape featuring sightseeing, meals & comfortable stay.</p>
                        <div class="card-meta">
                            <span class="rating">₹<?php echo htmlspecialchars($row['price']); ?></span>
                            <span><?php echo htmlspecialchars($row['duration']); ?></span>
                        </div>
                        <a href="book_package.php?id=<?php echo (int)$row['id']; ?>" class="book-bottom-btn">Book Now</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- ✅ HILL STATIONS SECTION -->
<section id="hills">
    <div class="container">
        <div class="section-header">
            <h2>India's Enchanting Hill Stations</h2>
            <p>Escape the heat & explore India's most beautiful mountain destinations.</p>
        </div>

        <div class="destination-grid">

<?php
$hills = [
["Shimla, Himachal Pradesh","https://images.unsplash.com/photo-1603262110263-fb0112e7cc33?auto=format&fit=crop&w=1600&q=90","★ 4.8","Oct–Jun","Shimla","A colonial-era hill town famous for pine forests & mall road strolls."],
["Darjeeling, West Bengal","https://images.unsplash.com/photo-1544986581-efac024faf62?auto=format&fit=crop&w=1600&q=90","★ 4.7","Feb–Mar, Sep–Dec","Darjeeling","The land of tea gardens & spectacular sunrise over Kanchenjunga."],
["Munnar, Kerala","https://images.unsplash.com/photo-1589302168068-964664d93dc0?auto=format&fit=crop&w=1600&q=90","★ 4.6","Sep–May","Munnar","Endless green tea plantations, misty mountains & cool weather."],
["Manali, Himachal Pradesh","https://images.unsplash.com/photo-1617113930978-fc1b1aebaf8c?auto=format&fit=crop&w=1600&q=90","★ 4.5","Oct–Jun","Manali","Adventure paradise surrounded by snow peaks & river valleys."],
["Ooty, Tamil Nadu","https://images.unsplash.com/photo-1586864387967-d02ef85d93ae?auto=format&fit=crop&w=1600&q=90","★ 4.6","Oct–Jun","Ooty","Beautiful lakes, gardens & the iconic Nilgiri toy train."],
["Nainital, Uttarakhand","https://images.unsplash.com/photo-1586861203921-966cd1df2495?auto=format&fit=crop&w=1600&q=90","★ 4.7","Mar–Jun, Oct–Dec","Nainital","A peaceful lakeside escape surrounded by lush hills."],
["Gangtok, Sikkim","https://images.unsplash.com/photo-1610641818989-70ebf43328d0?auto=format&fit=crop&w=1600&q=90","★ 4.8","Mar–Jun, Oct–Dec","Gangtok","Monasteries, snow peaks & breathtaking Himalayan landscapes."],
["Mussoorie, Uttarakhand","https://images.unsplash.com/photo-1604924733765-6cb68028ecbb?auto=format&fit=crop&w=1600&q=90","★ 4.6","Apr–Jun, Oct–Nov","Mussoorie","Charming hill station with waterfalls & mountain viewpoints."],
["Kodaikanal, Tamil Nadu","https://images.unsplash.com/photo-1586863097422-5d8e20e6ce06?auto=format&fit=crop&w=1600&q=90","★ 4.7","Sep–May","Kodaikanal","Misty hills, serene lakes & star-shaped Kodaikanal Lake."]
];

foreach ($hills as $h):
?>
<article class="destination-card">
    <div class="card-image">
        <img src="<?php echo $h[1]; ?>" alt="<?php echo $h[0]; ?>">
    </div>
    <div class="card-content">
        <h3><?php echo $h[0]; ?></h3>
        <p class="card-desc"><?php echo $h[5]; ?></p>
        <div class="card-meta">
            <span class="rating"><?php echo $h[2]; ?></span>
            <span>Best: <?php echo $h[3]; ?></span>
        </div>
        <a href="book_package.php?location=<?php echo $h[4]; ?>" class="book-bottom-btn">Book Now</a>
    </div>
</article>
<?php endforeach; ?>

        </div>

        <a href="hills.php" class="see-more">View All Hill Stations <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

<!-- ✅ BEACHES SECTION -->
<section id="beaches">
    <div class="container">
        <div class="section-header">
            <h2>India's Pristine Beaches</h2>
            <p>Discover turquoise waters, golden sands & unforgettable sunsets.</p>
        </div>

        <div class="destination-grid">

<?php
$beaches = [
["Palolem, Goa","https://images.unsplash.com/photo-1544006659-f0b21884ce1d?auto=format&fit=crop&w=1600&q=90","★ 4.7","Oct–Mar","Palolem","A calm crescent-shaped beach perfect for relaxation & kayaking."],
["Radhanagar, Andaman","https://images.unsplash.com/photo-1605390119405-592effdb8b27?auto=format&fit=crop&w=1600&q=90","★ 4.9","Oct–May","Radhanagar","Asia’s top-rated beach with crystal clear waters & white sand."],
["Kovalam, Kerala","https://images.unsplash.com/photo-1613086091459-83f14e28f239?auto=format&fit=crop&w=1600&q=90","★ 4.5","Sep–May","Kovalam","Iconic lighthouse beach with gentle waves & palm-lined shores."],
["Varkala, Kerala","https://images.unsplash.com/photo-1550367085-4caaf0b3b41c?auto=format&fit=crop&w=1600&q=90","★ 4.6","Aug–Mar","Varkala","Cliffside beach famous for cafes, sunsets & healing springs."],
["Calangute, Goa","https://images.unsplash.com/photo-1589308078056-d651f97c8ed3?auto=format&fit=crop&w=1600&q=90","★ 4.6","Oct–Feb","Calangute","Popular beach buzzing with nightlife, markets & adventure sports."],
["Gokarna, Karnataka","https://images.unsplash.com/photo-1604890429184-ccb209d29245?auto=format&fit=crop&w=1600&q=90","★ 4.7","Oct–Mar","Gokarna","Pristine beaches with scenic treks & peaceful surroundings."],
["Pondicherry, Tamil Nadu","https://images.unsplash.com/photo-1624188099748-3dbfc2a76cc2?auto=format&fit=crop&w=1600&q=90","★ 4.6","Oct–Mar","Pondicherry","French-style seaside town with serene beaches & cafes."],
["Ganpatipule, Maharashtra","https://images.unsplash.com/photo-1585594884073-7ea0d33302ec?auto=format&fit=crop&w=1600&q=90","★ 4.5","Nov–Feb","Ganpatipule","Clean, uncrowded beach with a beachfront temple."],
["Digha, West Bengal","https://images.unsplash.com/photo-1600067015409-1eb2bf28c6d6?auto=format&fit=crop&w=1600&q=90","★ 4.4","Oct–Feb","Digha","Budget-friendly coastal retreat with peaceful sea views."]
];

foreach ($beaches as $b):
?>
<article class="destination-card">
    <div class="card-image">
        <img src="<?php echo $b[1]; ?>" alt="<?php echo $b[0]; ?>">
    </div>
    <div class="card-content">
        <h3><?php echo $b[0]; ?></h3>
        <p class="card-desc"><?php echo $b[5]; ?></p>
        <div class="card-meta">
            <span class="rating"><?php echo $b[2]; ?></span>
            <span>Best: <?php echo $b[3]; ?></span>
        </div>
        <a href="book_package.php?location=<?php echo $b[4]; ?>" class="book-bottom-btn">Book Now</a>
    </div>
</article>
<?php endforeach; ?>

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

<script src="main.js"></script>
</body>
</html>
