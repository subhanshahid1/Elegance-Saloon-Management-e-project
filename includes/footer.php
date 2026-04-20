<?php
// We use the same query logic as your header.php
$footer_cat_query = "SELECT DISTINCT category FROM services WHERE status = 'active' ORDER BY category ASC LIMIT 5";
$footer_cat_result = mysqli_query($conn, $footer_cat_query);
?>
<footer>
  <div class="footer-top">

    <div class="col logo-col">
      <div class="logo">ELEGANCE <span>✦ SALOON ✦</span></div>
      <p>Premium grooming & styling for those who appreciate the finest.</p>
      <div class="socials">
        <a href="#">f</a>
        <a href="#">in</a>
        <a href="#">ig</a>
        <a href="#">yt</a>
      </div>
    </div>

    <div class="col">
      <h4>Quick Links</h4>
      <a href="index.php">Home</a>
      <a href="aboutus.php">About Us</a>
      <a href="services.php">Our Services</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="col">
      <h4>Our Services</h4>
      <?php 
      if ($footer_cat_result && mysqli_num_rows($footer_cat_result) > 0) {
          while($row = mysqli_fetch_assoc($footer_cat_result)) {
              $cat_name = $row['category'];
              // Same slug logic as header.php to ensure the link works
              $cat_slug = strtolower(str_replace(' ', '-', $cat_name));
              ?>
              <a href="services.php#<?php echo $cat_slug; ?>">
                  <?php echo htmlspecialchars($cat_name); ?>
              </a>
              <?php
          }
      } else {
          echo '<a href="services.php">All Services</a>';
      }
      ?>
    </div>

    <div class="col">
      <h4>Contact Us</h4>
      <p>📍 123 Main Street, Karachi</p>
      <p>📞 +92 300 1234567</p>
      <p>✉ info@elegancesaloon.com</p>
      <p>🕐 Mon–Sat: 9am – 9pm</p>
    </div>

  </div>

  <div class="footer-bottom">
    <p>© <?php echo date('Y'); ?> <span>Elegance Saloon</span>. All rights reserved.</p>
    <p>Designed with ♥ for style</p>
  </div>
</footer>