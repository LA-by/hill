<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Payment with Mobile OTP</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #2c786c, #004445);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .payment-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.25);
      width: 380px;
      opacity: 0;
      transform: translateY(-50px);
      transition: all 0.8s ease;
      margin: 40px 0;
    }

    .payment-container.active {
      opacity: 1;
      transform: translateY(0);
      animation: bounceIn 1s ease;
    }

    @keyframes bounceIn {
      0%   { transform: scale(0.9); opacity: 0; }
      50%  { transform: scale(1.05); opacity: 1; }
      70%  { transform: scale(0.95); }
      100% { transform: scale(1); }
    }

    .payment-container:hover {
      box-shadow: 0 0 25px rgba(255,94,98,0.7);
      transform: scale(1.02);
    }

    .payment-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-size: 24px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 10px;
      margin-bottom: 5px;
      color: #444;
    }

    input, select, button {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
      font-size: 14px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #ff5e62;
      box-shadow: 0 0 8px rgba(255,94,98,0.5);
      outline: none;
    }

    button {
      background: #ff5e62;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border: none;
      transition: 0.3s;
    }

    button:hover {
      background: #e74c3c;
      transform: scale(1.05);
    }

    .otp-box {
      display: none;
      animation: fadeIn 0.8s ease;
    }

    .success {
      text-align: center;
      color: green;
      font-weight: bold;
      display: none;
      font-size: 18px;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background: #ddd;
      border-radius: 5px;
      overflow: hidden;
      margin-top: 10px;
      display: none;
    }

    .progress {
      height: 100%;
      width: 0%;
      background: #28a745;
      animation: progressAnim 3s linear forwards;
    }

    @keyframes progressAnim {
      from { width: 0%; }
      to { width: 100%; }
    }

    .error {
      color: red;
      text-align: center;
      display: none;
      font-size: 14px;
    }

    .qr-box {
      text-align: center;
      margin-bottom: 15px;
      display: none;
    }

    .qr-box img {
      width: 180px;
      height: auto;
      margin-top: 10px;
      border: 2px solid #ccc;
      border-radius: 10px;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-6px); }
      50% { transform: translateX(6px); }
      75% { transform: translateX(-4px); }
    }

    .shake {
      animation: shake 0.4s;
    }

    /* Footer */
    footer {
      background: #003d33;
      color: #fff;
      padding: 40px 20px;
      width: 100%;
      margin-top: auto;
    }

    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .footer-column {
      flex: 1;
      min-width: 220px;
      margin: 10px;
    }

    .footer-column h3 {
      margin-bottom: 10px;
      font-size: 18px;
      border-bottom: 2px solid #ff5e62;
      display: inline-block;
      padding-bottom: 5px;
    }

    .footer-column p, 
    .footer-column a {
      font-size: 14px;
      color: #ccc;
      text-decoration: none;
      margin: 5px 0;
      display: block;
    }

    .footer-column a:hover {
      color: #fff;
    }

    .footer-nav {
      text-align: center;
      margin-bottom: 15px;
    }

    .footer-nav a {
      color: #ccc;
      margin: 0 10px;
      text-decoration: none;
      font-size: 14px;
    }

    .footer-nav a:hover {
      color: #fff;
    }

    .copyright {
      text-align: center;
      font-size: 14px;
      color: #bbb;
    }
  </style>
</head>
<body>
  <div class="payment-container" id="paymentBox">
    <h2>Secure Payment</h2>
    <form id="paymentForm">
      <label for="name">Full Name</label>
      <input type="text" id="name" placeholder="Enter your name" required>

      <label for="mobile">Mobile Number</label>
      <input type="tel" id="mobile" placeholder="Enter mobile number" required pattern="[0-9]{10}" maxlength="10">

      <label for="amount">Amount</label>
      <input type="number" id="amount" placeholder="Enter amount" required>

      <label for="method">Payment Method</label>
      <select id="method" required>
        <option value="">Select</option>
        <option value="gpay">Google Pay</option>
        <option value="paytm">Paytm</option>
        <option value="bhim">BHIM</option>
        <option value="credit">Credit Card</option>
        <option value="debit">Debit Card</option>
        <option value="netbanking">Net Banking</option>
      </select>

      <div class="qr-box" id="qrBox">
        <p>Scan QR to Pay:</p>
        <img id="qrImage" src="images/qrcode.jpg" alt="QR Code">
      </div>

      <button type="submit">Proceed</button>
    </form>

    <div class="otp-box" id="otpBox">
      <label for="otp">Enter OTP</label>
      <input type="number" id="otp" placeholder="Enter OTP">
      <button id="verifyBtn">Verify OTP</button>
      <p class="error" id="errorMsg">❌ Invalid OTP, try again!</p>
    </div>

    <p class="success" id="successMsg">✅ Payment Successful! <br> Refreshing in 3s...</p>
    <div class="progress-bar" id="progressBar">
      <div class="progress"></div>
    </div>
  </div>

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
          <p><a href="index.php#hills">Hill Stations</a></p>
          <p><a href="index.php#beaches">Beaches</a></p>
          <p><a href="index.php#featured">Featured Destinations</a></p>
          <p><a href="index.php#testimonials">Testimonials</a></p>
        </div>
        <div class="footer-column">
          <h3>Contact Us</h3>
          <p>📧 info@hillsagar.com</p>
          <p>📞 +91 9876543210</p>
          <p>📍 Mumbai, India</p>
        </div>
      </div>

      <div class="footer-nav">
  <a href="aboutus.php">About Us</a>
  <a href="blog.php">Travel Blog</a>
  <a href="contact.php">Contact</a>
  <a href="privacy.php" class="active">Privacy Policy</a>
  <a href="terms.php">Terms of Service</a>
      </div>

      <div class="copyright">
        <p>&copy; 2023 HillSagar. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    let generatedOTP;

    window.addEventListener("load", () => {
      document.getElementById("paymentBox").classList.add("active");
    });

    document.getElementById("method").addEventListener("change", function() {
      let qrBox = document.getElementById("qrBox");
      let qrImage = document.getElementById("qrImage");
      if (this.value === "") {
        qrBox.style.display = "none";
        return;
      }
      qrImage.src = "images/qrcode.jpg";
      qrBox.style.display = "block";
    });

    document.getElementById("paymentForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let name = document.getElementById("name").value.trim();
      let mobile = document.getElementById("mobile").value.trim();
      let amount = document.getElementById("amount").value.trim();
      let method = document.getElementById("method").value;

      if (name === "" || mobile === "" || amount === "" || method === "") {
        document.getElementById("paymentBox").classList.add("shake");
        setTimeout(() => document.getElementById("paymentBox").classList.remove("shake"), 500);
        alert("⚠️ Please fill all fields!");
        return;
      }

      if (mobile.length !== 10) {
        document.getElementById("paymentBox").classList.add("shake");
        setTimeout(() => document.getElementById("paymentBox").classList.remove("shake"), 500);
        alert("⚠️ Enter a valid 10-digit mobile number!");
        return;
      }

      generatedOTP = Math.floor(100000 + Math.random() * 900000);
      alert("📩 OTP sent to " + mobile + ": " + generatedOTP);

      document.getElementById("paymentForm").style.display = "none";
      document.getElementById("otpBox").style.display = "block";
    });

    document.getElementById("verifyBtn").addEventListener("click", function() {
      let enteredOTP = document.getElementById("otp").value.trim();
      if (enteredOTP == generatedOTP) {
        document.getElementById("otpBox").style.display = "none";
        document.getElementById("successMsg").style.display = "block";
        document.getElementById("progressBar").style.display = "block";
        setTimeout(() => { location.reload(); }, 3000);
      } else {
        document.getElementById("errorMsg").style.display = "block";
        document.getElementById("paymentBox").classList.add("shake");
        setTimeout(() => {
          document.getElementById("errorMsg").style.display = "none";
          document.getElementById("paymentBox").classList.remove("shake");
        }, 1000);
      }
    });
  </script>
</body>
</html>
