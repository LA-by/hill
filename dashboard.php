<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hill Sagar Dashboard</title>
<style>
:root {
    --primary-color: #2c786c;
    --secondary-color: #004445;
    --accent-color: #f8b400;
    --light-color: rgba(255, 255, 255, 0.8);
    --dark-color: rgba(19, 30, 36, 0.8);
    --text-color: #000000;
    --white: rgba(255, 255, 255, 0.9);
    --gray-light: rgba(245, 245, 245, 0.6);
    --gray: rgba(224, 224, 224, 0.5);
    --font-main: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    --bg-color: rgba(245, 245, 247, 0.8);
    --card-bg: rgba(255, 255, 255, 0.5);
    --text-primary: #090909;
    --header-bg: rgba(255, 255, 255, 0.7);
    --footer-bg: #69d3c4;
    --nav-color: var(--primary-color);
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    --border-radius: 16px;
    --border: 1px solid rgba(255, 255, 255, 0.5);
    --backdrop: blur(10px);
}

* {box-sizing: border-box; margin: 0; padding: 0; font-family: var(--font-main);}
body {background: var(--bg-color); color: var(--text-primary);}
header {background: var(--header-bg); backdrop-filter: var(--backdrop); padding: 20px 40px; text-align: center; box-shadow: var(--shadow);}
header h1 {color: var(--primary-color); font-size: 2.5rem; margin-bottom: 5px; font-style: italic;}
header p {color: var(--secondary-color); font-size: 1.2rem;}
nav {background: var(--nav-color); padding: 10px 40px; display: flex; justify-content: space-between; color: var(--white);}
nav a {color: var(--white); text-decoration: none; margin: 0 15px; font-weight: bold;}
.container {display: flex; gap: 20px; padding: 40px;}
.sidebar {flex: 1; background: var(--card-bg); padding: 20px; border-radius: var(--border-radius); box-shadow: var(--shadow);}
.content {flex: 3; display: flex; flex-direction: column; gap: 20px;}
.card {background: var(--card-bg); padding: 20px; border-radius: var(--border-radius); box-shadow: var(--shadow);}
.profile img {width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: var(--border); margin-bottom: 15px;}
.profile h2 {margin-bottom: 5px;}
.profile p {color: var(--secondary-color);}
.packages table {width: 100%; border-collapse: collapse;}
.packages th, .packages td {padding: 12px; text-align: left; border-bottom: 1px solid var(--gray);}
.packages th {background: var(--accent-color); color: var(--white);}
button {padding: 5px 10px; border: none; border-radius: 8px; cursor: pointer; margin-right:5px;}
button.update {background: var(--primary-color); color: #fff;}
button.delete {background: #f44336; color: #fff;}
.footer {text-align: center; padding: 20px; background: var(--footer-bg); color: var(--white); margin-top: 40px;}
@media(max-width: 900px) {.container {flex-direction: column;}}
</style>
</head>
<body>

<header>
    <h1 style="color: #000; text-decoration: underline;">Hill Sagar</h1>
    <p style="color: var(--accent-color);">Where mountains meet sea</p>
</header>

<nav>
    <div style="font-size: x-large; color: #000; font-weight: 900;">Dashboard</div>
    <div>
    <a href="index.php">Home</a>
        <a href="#">Bookings</a>
    <a href="index.php#hills">Packages</a>
    <a href="login.php">Logout</a>
    </div>
</nav>

<div class="container">
    <aside class="sidebar">
        <div class="profile">
            <img src="images/vivan.png" alt="User Profile">
            <h2>Vijay Bharadava</h2>
            <p>Email: bharadavavivan358@gmail.com</p>
            <p>Phone: +91 9687939701</p>
        </div>
    </aside>

    <section class="content">
        <div class="card packages">
            <h3>Your Bookings</h3>
            <table id="bookingTable">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Shimla Adventure</td>
                        <td>2025-10-05</td>
                        <td>Confirmed</td>
                        <td>
                            <button class="update">Update</button>
                            <button class="delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Goa Beach Relax</td>
                        <td>2025-12-15</td>
                        <td>Pending</td>
                        <td>
                            <button class="update">Update</button>
                            <button class="delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Kerala Backwaters</td>
                        <td>2026-01-20</td>
                        <td>Cancelled</td>
                        <td>
                            <button class="update">Update</button>
                            <button class="delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Account Info</h3>
            <p>Member since: 2023</p>
            <p>Loyalty Points: 250</p>
            <p>Preferred Packages: Mountains & Beaches</p>
        </div>
    </section>
</div>

<div class="footer">
    &copy; 2025 Hill Sagar. All rights reserved.
</div>

<script>
// Handle Update/Delete
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('bookingTable');

    table.addEventListener('click', (e) => {
        const target = e.target;
        if (target.classList.contains('delete')) {
            if (confirm('Are you sure you want to delete this booking?')) {
                const row = target.closest('tr');
                row.remove();
            }
        } else if (target.classList.contains('update')) {
            const row = target.closest('tr');
            const packageName = prompt('Update Package Name:', row.cells[0].textContent);
            const packageDate = prompt('Update Date (YYYY-MM-DD):', row.cells[1].textContent);
            const packageStatus = prompt('Update Status:', row.cells[2].textContent);
            if (packageName) row.cells[0].textContent = packageName;
            if (packageDate) row.cells[1].textContent = packageDate;
            if (packageStatus) row.cells[2].textContent = packageStatus;
        }
    });
});
</script>

</body>
</html>
