document.addEventListener('DOMContentLoaded', () => {
  const passwordInput = document.getElementById('password');
  const showPassCheckbox = document.getElementById('showPass');
  const loginForm = document.getElementById('loginForm');
  const errorMsg = document.getElementById('errorMsg');

  // Show/hide password
  showPassCheckbox.addEventListener('change', () => {
    passwordInput.type = showPassCheckbox.checked ? 'text' : 'password';
  });

  // Form validation
  loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = passwordInput.value.trim();
    let isValid = true;
    let errorMessage = "";

    // Email validation
    if (email === "") {
      isValid = false;
      errorMessage = "Please enter your email.";
    } else {
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      if (!emailPattern.test(email)) {
        isValid = false;
        errorMessage = "Please enter a valid email address.";
      }
    }

    // Password validation
    if (isValid && password === "") {
      isValid = false;
      errorMessage = "Please enter your password.";
    } else if (isValid && password.length < 6) {
      isValid = false;
      errorMessage = "Password must be at least 6 characters.";
    }

    // Display error message or proceed
    if (!isValid) {
      showError(errorMessage);
    } else {
      hideError();
      handleLoginSuccess(email);
    }
  });

  // Real-time validation for better UX
  document.getElementById('email').addEventListener('blur', validateEmail);
  passwordInput.addEventListener('input', validatePassword);

  function validateEmail() {
    const email = document.getElementById('email').value.trim();
    if (email === "") return;
    
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailPattern.test(email)) {
      showError("Please enter a valid email address.");
    } else {
      hideError();
    }
  }

  function validatePassword() {
    const password = passwordInput.value.trim();
    if (password === "") return;
    
    if (password.length < 6) {
      showError("Password must be at least 6 characters.");
    } else {
      hideError();
    }
  }

  function showError(message) {
    errorMsg.textContent = "⚠ " + message;
    errorMsg.style.display = "block";
    
    // Hide error message after 5 seconds
    setTimeout(() => {
      hideError();
    }, 5000);
  }

  function hideError() {
    errorMsg.style.display = "none";
  }

  function handleLoginSuccess(email) {
    // Create success message container
    const successContainer = document.createElement('div');
    successContainer.className = 'success-container';
    
    // ✅ Show personalized message
    const successMsg = document.createElement('div');
    successMsg.className = 'success-message';
    successMsg.innerHTML = `
      <div class="success-content">
        <span class="success-icon">✓</span>
        <h3>Welcome ${email}!</h3>
        <p>You have successfully logged in.</p>
      </div>
    `;
    
    successContainer.appendChild(successMsg);
    loginForm.parentNode.insertBefore(successContainer, loginForm);
    
    // ✅ Green styling
    const style = document.createElement('style');
    style.textContent = `
      .success-container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
      }
      
      .success-message {
        background: #e6f9e6; /* light green */
        color: #2e7d32;      /* dark green text */
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
        text-align: center;
        max-width: 400px;
        width: 100%;
        border: 2px solid rgba(46, 125, 50, 0.3);
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
        animation: successPopIn 0.6s ease-out forwards, successPulse 2s ease-in-out infinite 0.6s;
      }
      
      .success-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
      }
      
      .success-icon {
        font-size: 32px;
        font-weight: bold;
        width: 60px;
        height: 60px;
        background: rgba(46, 125, 50, 0.1);
        color: #2e7d32;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: iconBounce 0.8s ease-in-out 0.3s both;
      }
      
      .success-message h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #2e7d32;
      }
      
      .success-message p {
        margin: 0;
        font-size: 16px;
        line-height: 1.5;
        color: #2e7d32;
      }
      
      @keyframes successPopIn {
        0% {
          opacity: 0;
          transform: translateY(-20px) scale(0.95);
        }
        50% {
          transform: translateY(5px) scale(1.02);
        }
        100% {
          opacity: 1;
          transform: translateY(0) scale(1);
        }
      }
      
      @keyframes iconBounce {
        0%, 20%, 50%, 80%, 100% { transform: scale(1); }
        40% { transform: scale(1.3); }
        60% { transform: scale(1.1); }
      }
      
      @keyframes successPulse {
        0% { box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3); }
        50% { box-shadow: 0 8px 35px rgba(46, 125, 50, 0.5); }
        100% { box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3); }
      }
    `;
    
    document.head.appendChild(style);

    // Reset form
    loginForm.reset();
    passwordInput.type = 'password';
    showPassCheckbox.checked = false;

    // Redirect after 2s
    setTimeout(() => {
      window.location.href = "index.php";
    }, 2000);
  }
});
