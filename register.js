// Get elements
const registerForm = document.getElementById('registerForm');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const errorMsg = document.getElementById('errorMsg');
const togglePassword = document.getElementById('togglePassword');

// Show/hide password
togglePassword.addEventListener('change', () => {
    const type = togglePassword.checked ? 'text' : 'password';
    password.type = type;
    confirmPassword.type = type;
});

// Form submit event
registerForm.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default submission

    // Trim values
    const usernameVal = username.value.trim();
    const emailVal = email.value.trim();
    const passwordVal = password.value.trim();
    const confirmPasswordVal = confirmPassword.value.trim();

    // Validation
    let isValid = true;
    let errorMessage = "";

    if (usernameVal === '' || emailVal === '' || passwordVal === '' || confirmPasswordVal === '') {
        isValid = false;
        errorMessage = 'Please fill in all fields!';
    }

    // Simple email regex check
    if (isValid) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailVal)) {
            isValid = false;
            errorMessage = 'Please enter a valid email!';
        }
    }

    if (isValid && passwordVal.length < 6) {
        isValid = false;
        errorMessage = 'Password must be at least 6 characters!';
    }

    if (isValid && passwordVal !== confirmPasswordVal) {
        isValid = false;
        errorMessage = 'Passwords do not match!';
    }

    // Display error message or proceed
    if (!isValid) {
        showError(errorMessage);
    } else {
        hideError();
        handleRegistrationSuccess();
    }
});

// Real-time validation for better UX
username.addEventListener('blur', validateUsername);
email.addEventListener('blur', validateEmail);
password.addEventListener('input', validatePassword);
confirmPassword.addEventListener('input', validateConfirmPassword);

function validateUsername() {
    const usernameVal = username.value.trim();
    if (usernameVal === "") return;

    if (usernameVal.length < 3) {
        showError("Username must be at least 3 characters.");
    } else {
        hideError();
    }
}

function validateEmail() {
    const emailVal = email.value.trim();
    if (emailVal === "") return;

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailVal)) {
        showError("Please enter a valid email address.");
    } else {
        hideError();
    }
}

function validatePassword() {
    const passwordVal = password.value.trim();
    if (passwordVal === "") return;

    if (passwordVal.length < 6) {
        showError("Password must be at least 6 characters.");
    } else {
        hideError();
    }
}

function validateConfirmPassword() {
    const passwordVal = password.value.trim();
    const confirmPasswordVal = confirmPassword.value.trim();

    if (confirmPasswordVal === "" || passwordVal === "") return;

    if (passwordVal !== confirmPasswordVal) {
        showError("Passwords do not match.");
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

function handleRegistrationSuccess() {
    // Create success message container
    const successContainer = document.createElement('div');
    successContainer.className = 'success-container';

    // Create success message element
    const successMsg = document.createElement('div');
    successMsg.className = 'success-message';
    successMsg.innerHTML = `
        <div class="success-content">
            <span class="success-icon">✓</span>
            <h3>Registration Successful!</h3>
            <p>Welcome aboard! Your account has been created successfully.</p>
        </div>
    `;

    successContainer.appendChild(successMsg);
    registerForm.parentNode.insertBefore(successContainer, registerForm);

    // Add styles for the success message
    const style = document.createElement('style');
    style.textContent = `
        .success-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .success-message {
            background: #e6f9e6;  /* light green box */
            color: #2e7d32;       /* green text */
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
            text-align: center;
            max-width: 400px;
            width: 100%;
            border: 2px solid rgba(46, 125, 50, 0.3);
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
            animation: successPopIn 0.6s ease-out forwards;
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
            0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
            50% { transform: translateY(5px) scale(1.02); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes iconBounce {
            0%, 20%, 50%, 80%, 100% { transform: scale(1); }
            40% { transform: scale(1.3); }
            60% { transform: scale(1.1); }
        }
    `;
    document.head.appendChild(style);

    // Reset form
    registerForm.reset();
    password.type = 'password';
    confirmPassword.type = 'password';
    togglePassword.checked = false;

    // ✅ Wait 2 seconds before redirect
    setTimeout(() => {
        window.location.href = "index.php";
    }, 2000);
}
