<?php
require_once __DIR__ . '/includes/db.php';

// Add sample packages if they don't exist
$samplePackages = [
    [
        'title' => 'Shimla Hill Station Package',
        'description' => 'Experience the queen of hill stations with colonial charm and panoramic views of the Himalayas. Perfect for a romantic getaway or family vacation.',
        'price' => 15000,
        'duration' => '3 Days 2 Nights',
        'image' => 'shimla.jpg'
    ],
    [
        'title' => 'Goa Beach Paradise',
        'description' => 'Relax on pristine beaches, enjoy water sports, and experience the vibrant nightlife of Goa. A perfect beach vacation destination.',
        'price' => 12000,
        'duration' => '4 Days 3 Nights',
        'image' => 'baga.jpeg'
    ],
    [
        'title' => 'Kerala Backwaters',
        'description' => 'Cruise through the serene backwaters of Kerala on traditional houseboats. Experience the unique culture and natural beauty.',
        'price' => 18000,
        'duration' => '5 Days 4 Nights',
        'image' => 'alleppy'
    ],
    [
        'title' => 'Manali Adventure',
        'description' => 'Adventure capital with snow-capped peaks, lush valleys, and thrilling activities. Perfect for adventure enthusiasts.',
        'price' => 20000,
        'duration' => '4 Days 3 Nights',
        'image' => 'manali.jpeg'
    ],
    [
        'title' => 'Darjeeling Tea Gardens',
        'description' => 'Famous for its tea gardens and stunning views of Kanchenjunga peak. Experience the charm of the tea capital.',
        'price' => 16000,
        'duration' => '3 Days 2 Nights',
        'image' => 'darjeeling.jpg'
    ],
    [
        'title' => 'Munnar Tea Plantations',
        'description' => 'Rolling tea plantations and misty mountains in God\'s Own Country. A perfect escape to nature.',
        'price' => 14000,
        'duration' => '3 Days 2 Nights',
        'image' => 'munnar.jpeg'
    ]
];

foreach ($samplePackages as $package) {
    // Check if package already exists
    $check = $mysqli->prepare("SELECT id FROM packages WHERE title = ?");
    $check->bind_param('s', $package['title']);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        // Insert new package
        $stmt = $mysqli->prepare("INSERT INTO packages (title, description, price, duration, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssiss', $package['title'], $package['description'], $package['price'], $package['duration'], $package['image']);
        $stmt->execute();
        echo "Added: " . $package['title'] . "<br>";
    } else {
        echo "Already exists: " . $package['title'] . "<br>";
    }
}

echo "<br><strong>Sample packages added successfully!</strong><br>";
echo "<a href='index.php'>Go to Home Page</a>";
?>
