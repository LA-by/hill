<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - HillSagar</title>
  <meta name="description" content="Get in touch with HillSagar for travel queries, support, and partnerships.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="main.css">

<style>
/* ✅ CONTACT PAGE SPACING */
#contact {
  padding: 80px 0 200px;
  background: var(--bg-color);
  color: var(--text-primary);
}

/* ✅ Contact Grid Layout */
.destination-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
  gap: 32px;
}

/* ✅ Card Styling */
.destination-card {
  background: var(--card-bg);
  padding: 32px;
  border-radius: var(--border-radius);
  backdrop-filter: var(--backdrop);
  box-shadow: var(--shadow);
  display: flex;
  flex-direction: column;
  transition: 0.3s ease;
  min-height: 500px;
  border: var(--border);
}

.destination-card:hover {
  transform: translateY(-6px);
}

/* ✅ Normal Text */
.destination-card p {
  font-size: 20px;
  color: var(--text-primary);
  margin: 8px 0;
}

/* ✅ Contact Form Styling */
.contact-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.contact-form label {
  font-size: 15px;
  font-weight: 600;
  color: var(--text-primary);
}

.contact-form input,
.contact-form textarea {
  width: 100%;
  padding: 14px 16px;
  border: 2px solid var(--gray);
  border-radius: 10px;
  font-size: 15px;
  background: var(--gray-light);
  color: var(--text-primary);
  transition: 0.25s;
}

.contact-form input::placeholder,
.contact-form textarea::placeholder {
  color: var(--text-color);
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-color: var(--primary-color);
  background: var(--white);
  box-shadow: 0 0 8px rgba(44,120,108,0.35);
  outline: none;
}

/* ✅ Send Button */
.contact-form button {
  padding: 15px;
  width: 100%;
  background: var(--primary-color);
  color: var(--white);
  border: none;
  border-radius: 40px;
  font-size: 17px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.25s ease;
}

.contact-form button:hover {
  background: var(--secondary-color);
  transform: translateY(-2px);
}

/* ✅ Social Icons */
.social-links a {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  width: 45px;
  height: 45px;
  background: var(--gray-light);
  border-radius: 50%;
  font-size: 19px;
  color: var(--secondary-color);
  margin-right: 10px;
  transition: 0.25s ease;
}

.social-links a:hover {
  background: var(--primary-color);
  color: var(--white);
  transform: scale(1.12);
}

/* ✅ Floating Plane Chat Button */
.chat-widget {
  position: fixed;
  right: 24px;
  bottom: 24px;
  z-index: 999;
}

.chat-toggle-btn {
  width: 75px;
  height: 75px;
  border-radius: 50%;
  background: var(--accent-color);
  border: none;
  cursor: pointer;
  box-shadow: var(--shadow);
  display: flex;
  justify-content: center;
  align-items: center;
}

.chat-toggle-btn img {
  width: 42px;
  transition: 0.6s ease;
}

.plane-fly {
  transform: translate(-20px,-30px) rotate(-25deg) scale(1.2);
}

.plane-land {
  transform: translate(0,0) rotate(0) scale(1);
}

/* ✅ Chat Window */
.chat-window {
  position: absolute;
  right: 0;
  bottom: 95px;
  width: 330px;
  background: var(--card-bg);
  border-radius: 16px;
  box-shadow: var(--shadow);
  display: none;
  flex-direction: column;
  overflow: hidden;
  border: var(--border);
}

.chat-header {
  background: var(--primary-color);
  color: var(--white);
  padding: 14px;
  display: flex;
  justify-content: space-between;
}

.chat-body {
  padding: 14px;
  background: var(--bg-color);
  height: 200px;
  color: var(--text-primary);
  font-size: 15px;
}

.chat-footer {
  display: flex;
  border-top: 1px solid var(--gray);
}

.chat-footer input {
  flex: 1;
  padding: 12px;
  border: none;
  background: var(--gray-light);
  color: var(--text-primary);
  outline: none;
}

.chat-footer button {
  background: var(--primary-color);
  border: none;
  padding: 0 16px;
  color: var(--white);
  cursor: pointer;
  font-size: 18px;
}

/* ✅ Mobile Responsive */
@media(max-width: 768px) {
  .destination-grid {
    grid-template-columns: 1fr;
  }
  .chat-window {
    width: 280px;
  }
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

    <nav class="nav-links" aria-label="Main navigation">
      <ul>
        <li><a href="hills.php">Hill Stations</a></li>
        <li><a href="beaches.php">Beaches</a></li>
        <li><a href="index.php#featured">Destinations</a></li>
        <li><a href="index.php#testimonials">Testimonials</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>

    <button class="theme-toggle" id="themeToggle">
      <i class="fas fa-moon"></i> <span>Dark Mode</span>
    </button>
  </div>
</header>

<main>
<section id="contact">
  <div class="container">
    <div class="section-header">
      <h2>Contact Us</h2>
      <p>Have questions or need support? We’re here to help you plan the perfect getaway.</p>
    </div>

    <div class="destination-grid">

      <!-- ✅ Contact Form -->
      <div class="destination-card">
        <div class="card-content">
          <h3>Send us a Message</h3>
          <form action="#" method="post" class="contact-form">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
            
            <button type="submit">Send Message</button>
          </form>
        </div>
      </div>

      <!-- ✅ Contact Info -->
      <div class="destination-card">
        <div class="card-content">
          <h3>Reach Us At</h3>
          <p><i class="fas fa-envelope"></i> info@hillsagar.com</p>
          <p><i class="fas fa-phone"></i> +91 9687939701</p>
          <p><i class="fas fa-map-marker-alt"></i> Mumbai, India</p>

          <h3>Follow Us</h3>
          <div class="social-links">
            <a href="https://facebook.com/HillSagarOfficial" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com/HillSagarOfficial" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com/HillSagar_India" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://pinterest.com/HillSagarTravel" target="_blank"><i class="fab fa-pinterest"></i></a>
            <a href="https://wa.me/919687939701" target="_blank"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
</main>

<!-- ✅ Floating Plane WhatsApp Chat Widget -->
<div class="chat-widget">
  <button class="chat-toggle-btn" id="chatToggleBtn">
    <img src="images/plane.png" alt="Chat Plane" id="planeIcon">
  </button>

  <div class="chat-window" id="chatWindow">
    <div class="chat-header">
      <strong>HillSagar Support</strong>
      <button id="chatCloseBtn" style="background:none;border:none;color:#fff;font-size:20px;cursor:pointer;">×</button>
    </div>

    <div class="chat-body">
      Chat with us on WhatsApp — we reply fast ✅
    </div>

    <div class="chat-footer">
      <input type="text" id="chatInput" placeholder="Type message..." />
      <button id="chatSendBtn"><i class="fab fa-whatsapp"></i></button>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="footer-content">
      <div class="footer-column">
        <h3>About HillSagar</h3>
        <p>Discover India's best hill stations & beaches through curated guides and travel inspirations.</p>
      </div>
      <div class="footer-column">
        <h3>Quick Links</h3>
        <p><a href="index.php#hills">Hill Stations</a></p>
        <p><a href="index.php#beaches">Beaches</a></p>
        <p><a href="index.php#featured">Featured Destinations</a></p>
        <p><a href="index.php#testimonials">Testimonials</a></p>
      </div>
      <div class="footer-column">
        <h3>Contact Us</h3>
        <p><i class="fas fa-envelope"></i> info@hillsagar.com</p>
        <p><i class="fas fa-phone"></i> +91 9687939701</p>
        <p><i class="fas fa-map-marker-alt"></i> Mumbai, India</p>
      </div>
    </div>

    <div class="footer-nav">
      <a href="aboutus.php">About Us</a>
      <a href="blog.php">Travel Blog</a>
      <a href="contact.php" class="active">Contact</a>
      <a href="privacy.php">Privacy Policy</a>
      <a href="terms.php">Terms of Service</a>
    </div>

    <div class="copyright">
      <p>&copy; 2025 HillSagar. All rights reserved.</p>
    </div>
  </div>
</footer>

<script>
// ✅ WhatsApp Chat Integration
const whatsappNumber = "919687939701"; // <-- CHANGE NUMBER HERE ✅

const chatToggleBtn = document.getElementById('chatToggleBtn');
const chatCloseBtn  = document.getElementById('chatCloseBtn');
const chatWindow    = document.getElementById('chatWindow');
const planeIcon     = document.getElementById('planeIcon');
const chatInput     = document.getElementById('chatInput');
const chatSendBtn   = document.getElementById('chatSendBtn');

// ✅ Open Chat + Takeoff Animation
chatToggleBtn.onclick = () => {
  chatWindow.style.display = "flex";
  planeIcon.classList.remove("plane-land");
  planeIcon.classList.add("plane-fly");
};

// ✅ Close Chat + Landing Animation
chatCloseBtn.onclick = () => {
  chatWindow.style.display = "none";
  planeIcon.classList.remove("plane-fly");
  planeIcon.classList.add("plane-land");
};

// ✅ Send Message to WhatsApp
function sendToWhatsApp() {
  const message = encodeURIComponent(chatInput.value.trim());
  if (!message) return;

  window.open(`https://wa.me/${whatsappNumber}?text=${message}`, "_blank");
  chatInput.value = "";
}

chatSendBtn.onclick = sendToWhatsApp;

chatInput.addEventListener("keydown", e => {
  if (e.key === "Enter") sendToWhatsApp();
});
</script>

<script src="main.js"></script>
</body>
</html>
