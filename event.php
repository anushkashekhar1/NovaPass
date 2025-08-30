<?php
session_start();

// Initialize events + cart in session
if (!isset($_SESSION['events'])) {
    $_SESSION['events'] = [];
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add event (organizer)
if (isset($_POST['event_name']) && isset($_POST['price'])) {
    $newEvent = [
        "name" => $_POST['event_name'],
        "desc" => $_POST['desc'],
        "price" => $_POST['price']
    ];
    $_SESSION['events'][] = $newEvent;
    header("Location: events.php"); // refresh
    exit();
}

// Handle add to cart (user)
if (isset($_GET['addcart'])) {
    $id = $_GET['addcart'];
    if (isset($_SESSION['events'][$id])) {
        $_SESSION['cart'][] = $_SESSION['events'][$id];
    }
    header("Location: events.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NovaPass - Events</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
  <div class="brand">
    <div class="logo">✦</div>
    <div class="brand-text">NovaPass</div>
  </div>
  <nav class="nav">
    <a href="events.php" class="btn btn-ghost">Events</a>
    <a href="mytickets.html" class="btn btn-ghost">My Tickets</a>
    <a href="https://www.coinbase.com" target="_blank" class="btn btn-filled">Install Coinbase</a>
  </nav>
</header>

<main class="hero" style="min-height:20vh;">
  <div class="hero-inner">
    <h1 class="title" style="font-size:48px;">Available Events</h1>
    <p class="subtitle">Welcome, <?php echo $_SESSION['user']['name'] ?? 'Guest'; ?>! Browse and book your tickets.</p>
  </div>
</main>

<section style="max-width:900px;margin:0 auto;padding:20px;">
  <h2>Your Cart (<?php echo count($_SESSION['cart']); ?>)</h2>
  <ul>
    <?php foreach ($_SESSION['cart'] as $c): ?>
      <li><?php echo $c['name'] . " - $" . $c['price']; ?></li>
    <?php endforeach; ?>
  </ul>
</section>

<section style="max-width:900px;margin:30px auto;padding:20px;">
  <h2>Event Listings</h2>
  <?php if (empty($_SESSION['events'])): ?>
    <p>No events yet. Organizers can add events below.</p>
  <?php else: ?>
    <div class="features" style="grid-template-columns:repeat(2,1fr);">
      <?php foreach ($_SESSION['events'] as $id => $ev): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($ev['name']); ?></h3>
          <p><?php echo htmlspecialchars($ev['desc']); ?></p>
          <p><strong>$<?php echo htmlspecialchars($ev['price']); ?></strong></p>
          <a href="events.php?addcart=<?php echo $id; ?>" class="btn btn-filled">Add to Cart</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<section style="max-width:700px;margin:40px auto;padding:20px;">
  <h2>Add New Event (Organizer)</h2>
  <form method="post" action="events.php" class="signup-form">
    <label>
      Event Name
      <input type="text" name="event_name" required>
    </label>
    <label>
      Description
      <input type="text" name="desc" required>
    </label>
    <label>
      Price
      <input type="number" name="price" required>
    </label>
    <div class="form-actions">
      <button type="submit" class="btn btn-outline">Add Event</button>
    </div>
  </form>
</section>

</body>
</html>
