<?php
session_start();

// Check login status
$isLoggedIn   = isset($_SESSION['customer_id']); 

$customerName = $_SESSION['customer_name'] ?? '';
$userRole     = $_SESSION['role'] ?? 'guest';

// Redirect non-customers
if ($isLoggedIn && $userRole !== 'customer') {
    if ($userRole === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    }
    if ($userRole === 'therapist') {
        header("Location: therapist_dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <title>Green Life Wellness Center</title>
</head>
<body>

        <!-- Landing Page-->
<section id="Home" class="background">
    <div class="overlay"></div>
    <header>
        <nav class="nav_container">
            <div class="nav_logo">
                <img src="logo.png" alt="Green Life Wellness Center Logo">
                <h1>Green Life Wellness Center</h1>
            </div>

            <!-- Homepage links -->
            <ul class="nav_links">
                <li class="link"><a href="#Home">Home</a></li>
                <li class="link"><a href="#Service">Services</a></li>
                <li class="link"><a href="#Programmes">Upcoming Programmes</a></li>
                <li class="link"><a href="#About">About Us</a></li>
                <li class="link"><a href="#Contact">Contact Us</a></li>
            </ul>

          
            <div class="nav_button" id="navButtonContainer">
               <?php if ($isLoggedIn): ?>
               <span>Hi, <?= htmlspecialchars($customerName) ?></span>
                <a href="logout.php" class="btn">Logout</a>
                <?php else: ?>
                <button class="btn" id="loginBtn">Login</button>
                <?php endif; ?>
            </div>
        </nav>

        <div class="header_container">
            <div class="header_content">
                <h1>Welcome to Green Life Wellness Center</h1>
                <p>At Green Life, we believe true wellness is more than the absence of illness — it’s the harmony of mind, body, and spirit.
                    Our mission is to guide you toward a healthier, balanced, and more fulfilling life through natural therapies, personalized care, and holistic healing.</p>
            </div>
        </div>

      <!-- Chat Popup -->
<div class="chat-float">
  <button id="chatButton"><i class="ri-chat-smile-2-fill"></i> Inquiry</button>
</div>

<div id="chatPopup" class="chat-popup" style="display:none;">
  <div class="chat-header">
    <h3>Send Inquiry</h3>
    <span id="closeChat" style="cursor:pointer;">&times;</span>
  </div>

  <div class="chat-body">
    <label for="chatType">Inquiry Type</label>
    <select id="chatType" required>
      <option value="" disabled selected>Select inquiry type</option>
      <option value="customer-support">Customer Support</option>
      <option value="ayurveda">Ayurveda</option>
      <option value="yoga">Yoga</option>
      <option value="meditation">Meditation</option>
      <option value="wellness-consultation">Wellness Consultation</option>
    </select>

    <label for="chatSubject">Subject</label>
    <input type="text" id="chatSubject" placeholder="Enter subject" required />

    <label for="chatMessage">Message</label>
    <textarea id="chatMessage" rows="4" placeholder="Type your message..." required></textarea>

    <div id="chatError" class="chat-error" aria-live="polite"></div>

    <button id="sendMessage">Send</button>
  </div>
</div>
    </header>
</section>


    <!-- Services Section -->
    <section id="Service"class="service_container">
        <div class="service_header">
            <div class="service_header_content">
                <h2 class="service_header">Ways We Support You</h2>
                <p>At our wellness center, your well-being is at the heart of everything we do. We offer a range of holistic, therapeutic, 
                and restorative services designed to support your mind, body, and spirit. Whether you're seeking relaxation, stress relief, 
                physical healing, or emotional balance, we’re here to walk alongside you on your path to wellness.</p>
            
                <div class="service_grid">
                    <div class="service_card">
                        <span><i class="ri-flower-fill"></i></span>
                        <h3>Ayurvedic Therapy</h3>
                        <p>Experience natural healing through Ayurvedic Therapy — a time-honored approach that balances mind, body, and spirit using herbal
                             treatments, massage, and personalized care rooted in ancient wisdom.</p>
                        <a href="#Service1" onclick="showService('Service1')">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-open-arm-fill"></i></span>
                        <h3>Yoga and Meditation</h3>
                        <p>Experience the perfect balance of mind and body through guided yoga postures and 
                            meditation practices that promote relaxation, flexibility, and inner peace.</p>
                        <a href="#Service2" onclick="showService('Service2')">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-presentation-line"></i></span>
                        <h3>Nutrition and Diet Consultation</h3>
                        <p>Get personalized diet plans and expert nutrition 
                            advice to improve your health, boost energy, and achieve your wellness goals.</p>
                        <a href="#Service3" onclick="showService('Service3')">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-hotel-bed-line"></i></span>
                        <h3>Physiotherapy</h3>
                        <p>Restore mobility, relieve pain, and strengthen your body with professional physiotherapy 
                            treatments designed for recovery and long-term well-being.</p>
                        <a href="#Service4" onclick="showService('Service4')">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-mental-health-fill"></i></span>
                        <h3>Wellness Programmes</h3>
                        <p>Join our holistic wellness programmes that combine Ayurveda, fitness, 
                            stress management, and lifestyle guidance for a healthier and happier you.</p>
                        <a href="#Programmes" onclick="showService('Programmes')">More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- Programmes Section -->
<section id="Programmes" class="programmes_container">
  <div class="programmes_header">
    <h2>Upcoming Programmes at Green Life Wellness Center</h2>
    <p>
      Join us for our upcoming wellness programmes designed to rejuvenate your
      mind, body, and spirit. From yoga retreats to Ayurvedic workshops, we
      offer a variety of experiences to help you connect with yourself and
      nature.
    </p>
  </div>

  <div class="programmes grid">
    <!-- Programme 1 -->
  <div class="programme_card">
    <h3>Detox & Rejuvenation Retreat</h3>
    <div class="programme_item"><i class="ri-calendar-schedule-fill"></i><span>Date: September 10 – 14, 2025</span></div>
    <div class="programme_item"><i class="ri-user-fill"></i><span>Dr Nirmala Perera – Senior Ayurveda Specialist</span></div>
    <div class="programme_item"><i class="ri-map-pin-2-fill"></i><span>Green Life Wellness Center, Colombo</span></div>

    <!-- Register button -->
    <a href="#" class="register_btn" data-program="1">REGISTER</a>



    <!-- Message box -->
    <div id="programMessage1"></div>

    <!-- Registration form (hidden) -->
    <form id="programForm1" class="programForm hidden">
    <input type="hidden" name="program_id" value="1">
    <button type="submit">Confirm Registration</button>
    </form>

  </div>

  <!-- Programme 2 -->
  <div class="programme_card">
    <h3>Stress Relief & Mindfulness Workshop</h3>
    <div class="programme_item"><i class="ri-calendar-schedule-fill"></i><span>Date: September 20, 2025</span></div>
    <div class="programme_item"><i class="ri-user-fill"></i><span>Mr. Sahan Jayawardena – Certified Yoga & Meditation Trainer</span></div>
    <div class="programme_item"><i class="ri-map-pin-2-fill"></i><span>Green Life Wellness Center, Colombo</span></div>

   <a href="#" class="register_btn" data-program="2">REGISTER</a>

    <div id="programMessage2"></div>

    <form id="programForm2" class="programForm hidden">
      <input type="hidden" name="program_id" value="2">
      <button type="submit">Confirm Registration</button>
    </form>
  </div>

  <!-- Programme 3 -->
  <div class="programme_card">
    <h3>Healthy Weight Management Programme</h3>
    <div class="programme_item"><i class="ri-calendar-schedule-fill"></i><span>Date: November 02, 2025</span></div>
    <div class="programme_item"><i class="ri-user-fill"></i><span>Ms. Anjali De Silva – Wellness Coach & Lifestyle Consultant</span></div>
    <div class="programme_item"><i class="ri-map-pin-2-fill"></i><span>Independence Square, Colombo 07</span></div>

    <a href="#" class="register_btn" data-program="3">REGISTER</a>

    <div id="programMessage3"></div>

    <form id="programForm3" class="programForm hidden">
      <input type="hidden" name="program_id" value="3">
      <button type="submit">Confirm Registration</button>
    </form>
  </div>

</section>
<style> 
.hidden { display: none; }
 .msg { margin-top: 8px; padding: 10px; border-radius: 6px; border: 1px solid transparent; }
 .msg.success { background: #e6ffed; color: #0f5132; border-color: #badbcc; }
 .msg.error { background: #ffecec; color: #842029; border-color: #f5c2c7; } 
.msg.info { background: #7b808675; color: #084298; border-color: #6889665e; }


 </style>

    <!-- About Section -->
    <section id="About"class="about_us_container">
        <div class="about_us">
            <h2>About Green Life Wellness Center</h2>
            <div class="about_image">
                <img src="About.jpg" alt="about">
            </div>

            <h3>Our Story</h3>
            <p>Green Life Wellness Center was founded with a vision to bring holistic healing and modern wellness practices
            to the heart of Colombo. We believe true well-being comes from the balance of mind, body, and spirit — and 
            our mission is to guide you on that journey. Rooted in Sri Lanka’s rich traditions of Ayurveda and yoga, and enhanced with modern therapies, 
            we offer a nurturing space where you can relax, recharge, and rediscover yourself.</p>
    
            <div class="section_content">
                <h3>What We Offer</h3>
                <p>Our wellness experts design programs that blend tradition with innovation, including:</p>
                <ul>
                    <li><strong>Ayurvedic Therapy</strong> – authentic treatments guided by Sri Lankan Ayurvedic practitioners</li>
                    <li><strong>Yoga & Meditation Classes</strong> – to strengthen the body and calm the mind</li>
                    <li><strong>Nutrition & Diet Consultation</strong> – personalized plans for optimal health</li>
                    <li><strong>Physiotherapy</strong> – expert care for injury recovery and pain relief</li>
                    <li><strong>Wellness Programmes</strong> – holistic retreats and workshops for lifestyle transformation</li>
                </ul>
            </div>

            <div class="about_promise">
                <h3>Our Promise to You</h3>
                <p>When you step into Green Life Wellness Center, you are not just booking a treatment —
                you are beginning a journey towards lasting health and inner peace.</p>
                <p class="tagline">Because wellness is not a luxury — it’s a way of life.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="Contact"class="footer">
        <div class="footer_content">
            <div class="footer_column about">
                <h3>Green Life Wellness Center</h3>
                <p>Green Life Wellness Center is dedicated to promoting holistic health and well-being through natural therapies, personalized care, and a nurturing environment.</p>
            </div>

            <div class="footer_quick links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Programmes</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer_sub links">
                <h3>Quick Sub Links</h3>
                <ul>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms & Condition</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer_section contact">
                <h3>Contact Us</h3>
                <p><i class="ri-map-pin-2-fill"></i> 123 Wellness St, Colombo, Sri Lanka</p>
                <p><i class="ri-phone-fill"></i> +94 11 035 3808 or +94 75 035 3808</p>
                <p><i class="ri-mail-fill"></i> care@greenlife.com</p>
            </div>
        </div>

        <div class="footer_bar">
            <div class="footer_bar_content">
                <p>&copy;2025 Green Life Wellness Center. All rights reserved.</p>
                <div class="footer_social">
                    <a href="#"><i class="ri-facebook-fill"></i></a>
                    <a href="#"><i class="ri-instagram-fill"></i></a>
                    <a href="#"><i class="ri-linkedin-fill"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Subpages for services -->
<section id="Service1" class="Service1 hidden"> 
  <div class="Service1_Content">
    <h1>AYURVEDIC THERAPY</h1>
    <p>
      Experience the timeless healing power of Ayurveda. Our therapies combine
      herbal oils, detox treatments, and natural healing techniques to bring
      balance to your body and mind.
    </p>

    <!-- Benefit Box -->
    <div class="benefit-box">
      <div class="card">
        <h3>Benefits</h3>
        <ul>
          <li>Detoxifies and rejuvenates the body</li>
          <li>Relieves stress, anxiety, and fatigue</li>
          <li>Promotes better sleep and relaxation</li>
          <li>Strengthens immunity and restores energy</li>
        </ul>
      </div>

      <!-- Book Now Button -->
      <a href="#" class="book-btn" data-service="Ayurveda" onclick="handleBooking(this)">BOOK NOW</a>
    </div>

    <!-- Booking Form Container -->
    <div id="bookingFormContainer" class="hidden">
      <?php


      require 'db.php'; // your PDO connection

      // Generate next 4 Mondays
      $weeksToShow = 4;
      $dates = [];
      $today = new DateTime();
      $today->setTime(0,0);
      $nextMonday = clone $today;
      if ($today->format('N') != 1) $nextMonday->modify('next Monday');

      for ($i = 0; $i < $weeksToShow; $i++) {
          $dates[] = $nextMonday->format('Y-m-d');
          $nextMonday->modify('+1 week');
      }

      // Time slots
      $startHour = 10;
      $endHour = 19;
      $timeSlots = [];
      for ($hour = $startHour; $hour <= $endHour; $hour++) {
          $timeSlots[] = sprintf("%02d:00:00", $hour);
      }

      // Handle form submission
      if ($_SERVER['REQUEST_METHOD'] === 'POST' 
          && ($_POST['service'] ?? '') === 'Ayurveda') {

        if(!isset($_SESSION['customer_id'])){
            die("<p class='error'>You must login to submit a booking. <a href='login.php'>Login here</a></p>");
        }

        $customer_id = $_SESSION['customer_id'];
        $booking_date = $_POST['booking_date'] ?? '';
        $booking_time = $_POST['booking_time'] ?? '';

        // Map service to therapist_id (example)
        $therapists = [
          'Ayurveda' => 1 // replace 1 with actual therapist ID
        ];
        $therapist_id = $therapists['Ayurveda'];

        if ($booking_date && $booking_time) {
            $stmt = $pdo->prepare("INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$customer_id, $therapist_id, 'Ayurveda', $booking_date, $booking_time])) {
                echo "<p class='message'>Booking confirmed for " . date('l, F j, Y', strtotime($booking_date)) . " at " . date('h:i A', strtotime($booking_time)) . ".</p>";
            } else {
                echo "<p class='error'>Failed to save booking. Please try again.</p>";
            }
        } else {
            echo "<p class='error'>Please select a date and time.</p>";
        }
      }
      ?>

      <form method="post" id="bookingForm1" class="bookingForm">
        <input type="hidden" name="service" value="Ayurveda">

        <!-- Date Selection -->
        <label for="booking_date">Choose a Monday:</label>
        <select name="booking_date" id="booking_date" required>
            <option value="">Only on Mondays</option>
            <?php foreach($dates as $date): ?>
                <option value="<?= $date ?>"><?= date('l, F j, Y', strtotime($date)) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Time Selection -->
        <label for="booking_time">Choose a Time:</label>
        <select name="booking_time" id="booking_time" required>
            <option value="">10:00 AM to 07:00 PM</option>
            <?php foreach($timeSlots as $time): ?>
                <option value="<?= $time ?>"><?= date("h:i A", strtotime($time)) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Confirm Booking</button>
      </form>
      </div>
  </div>
  <div class="hero-image-wrapper">
    <img src="S1.jpg" alt="Ayurveda Therapy" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>

  <a href="#" class="back-btn" onclick="goBack()">← Back to Home</a>
</section>

<script>
const isCustomerLoggedIn = <?= isset($_SESSION['customer_id']) ? 'true' : 'false' ?>;

function handleBooking(button) {
    if(!isCustomerLoggedIn) {
        alert("Please login first to book a service.");
        window.location.href = "login.php";
        return;
    }
    document.getElementById('bookingFormContainer').classList.remove('hidden');
}
</script>

<section id="Service2" class="Service2 hidden">  
  <div class="Service2_Content">
    <h1>YOGA & MEDITATION</h1>
    <p>
      Enhance your well-being through guided yoga sessions and mindful meditation practices.
      Whether you’re a beginner or advanced, our classes help you connect within and live with balance.
    </p>

    <div class="benefit-box">
      <div class="card">
        <h3>Benefits</h3>
        <ul>
          <li>Improves flexibility, strength, and posture</li>
          <li>Reduces stress and promotes mental clarity</li>
          <li>Boosts immunity and energy levels</li>
          <li>Encourages mindfulness and inner peace</li>
        </ul>
      </div>
      <a href="#" class="book-btn" data-service="Yoga" onclick="handleBooking2(this)">BOOK NOW</a>
    </div>

    <!-- Booking Form Container -->
    <div id="bookingFormContainer2" class="hidden">
      <?php
      require 'db.php'; // PDO connection

      // Generate next 4 weeks for Tue, Fri, Sun
      $weeksToShow = 4;
      $dates = [];
      $today = new DateTime();
      $today->setTime(0,0);
      $validDays = ['2','5','7']; // Tue=2, Fri=5, Sun=7
      $nextDay = clone $today;

      while (count($dates) < ($weeksToShow * count($validDays))) {
          if (in_array($nextDay->format('N'), $validDays)) {
              $dates[] = $nextDay->format('Y-m-d');
          }
          $nextDay->modify('+1 day');
      }

      // Time slots
      $timeSlots = ["09:00:00", "18:00:00"];

      // Handle form submission
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['service'] ?? '') === 'Yoga') {
          if(!isset($_SESSION['customer_id'])){
              die("<p class='error'>You must login to book Yoga & Meditation. <a href='login.php'>Login here</a></p>");
          }

          $customer_id = $_SESSION['customer_id'];
          $booking_date = $_POST['booking_date'] ?? '';
          $booking_time = $_POST['booking_time'] ?? '';

          // Map service to therapist_id (example)
          $therapists = [
              'Yoga' => 2 // replace with correct therapist ID
          ];
          $therapist_id = $therapists['Yoga'];

          if ($booking_date && $booking_time) {
              $stmt = $pdo->prepare("INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?)");
              if ($stmt->execute([$customer_id, $therapist_id, 'Yoga', $booking_date, $booking_time])) {
                  echo "<p class='message'>Booking confirmed for " . date('l, F j, Y', strtotime($booking_date)) . " at " . date('h:i A', strtotime($booking_time)) . ".</p>";
              } else {
                  echo "<p class='error'>Failed to save booking. Please try again.</p>";
              }
          } else {
              echo "<p class='error'>Please select a date and time.</p>";
          }
      }
      ?>

      <form method="post" id="bookingForm2" class="bookingForm">
        <!-- Hidden field for service -->
        <input type="hidden" name="service" value="Yoga">

        <!-- Select date -->
        <label for="booking_date2">Choose a Date (Tue, Fri, Sun):</label>
        <select name="booking_date" id="booking_date2" required>
            <option value="">-- Select Available Date --</option>
            <?php foreach($dates as $date): ?>
                <option value="<?= $date ?>"><?= date('l, F j, Y', strtotime($date)) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Select time -->
        <label for="booking_time2">Choose a Time:</label>
        <select name="booking_time" id="booking_time2" required>
            <option value="">-- Select Time Slot --</option>
            <?php foreach($timeSlots as $time): ?>
                <option value="<?= $time ?>"><?= date("h:i A", strtotime($time)) ?> <?= ($time=="09:00:00" ? "- 11:00 AM" : "- 08:00 PM") ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Confirm Booking</button>
      </form>
    </div>
  </div>

  <div class="hero-image-wrapper">
    <img src="S2.jpg" alt="Yoga and Meditation" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>
  <a href="#" class="back-btn" onclick="goBack()">← Back to Home</a>
</section>

<script>
const isCustomerLoggedIn2 = <?= isset($_SESSION['customer_id']) ? 'true' : 'false' ?>;

function handleBooking2(button) {
    if(!isCustomerLoggedIn) {
        alert("Please login first to book a service.");
        window.location.href = "login.php";
        return;
    }
    const service = button.getAttribute('data-service');
    if(service === "Yoga") {
        document.getElementById('bookingFormContainer2').classList.remove('hidden');
    }
}
</script>

<section id="Service3" class="Service3 hidden"> 
  <div class="Service3_Content">
    <h1>NUTRITION & DIET CONSULTATION</h1>
    <p>
      Transform your lifestyle with a personalized diet plan crafted by our wellness experts.
      We design nutrition strategies tailored to your body type, health goals, and daily routine.
    </p>

    <div class="benefit-box">
      <div class="card">
        <h3>Benefits</h3>
        <ul>
          <li>Supports healthy weight management</li>
          <li>Improves digestion and metabolism</li>
          <li>Enhances energy and productivity</li>
          <li>Prevents lifestyle-related diseases</li>
        </ul>
      </div>
      <a href="#" class="book-btn" data-service="Nutrition" onclick="handleBooking3(this)">BOOK NOW</a>
    </div>

    <!-- Booking Form Container -->
    <div id="bookingFormContainer3" class="hidden">
      <?php
      require 'db.php'; // PDO connection

      // Allowed days: Wednesday & Saturday
      $availableDays = ['Wednesday', 'Saturday'];
      $dates3 = [];
      $today = new DateTime();
      $interval = new DateInterval('P1D'); // daily interval
      $period = new DatePeriod($today, $interval, 30); // next 30 days

      foreach ($period as $date) {
          if (in_array($date->format('l'), $availableDays)) {
              $dates3[] = $date->format('Y-m-d');
          }
      }

      // Time slots: 09:00 - 13:00
      $timeSlots3 = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00'];

      // Handle form submission
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['service'] ?? '') === 'Nutrition') {
          if(!isset($_SESSION['customer_id'])){
              die("<p class='error'>You must login to submit a booking. <a href='login.php'>Login here</a></p>");
          }

          $customer_id = $_SESSION['customer_id'];
          $booking_date = $_POST['booking_date'] ?? '';
          $booking_time = $_POST['booking_time'] ?? '';

          // Example: assign a therapist ID for Nutrition service
          $therapist_id = 3; // replace with actual therapist ID from DB

          if ($booking_date && $booking_time) {
              $stmt = $pdo->prepare("INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?)");
              if ($stmt->execute([$customer_id, $therapist_id, 'Nutrition', $booking_date, $booking_time])) {
                  echo "<p class='message'>Booking confirmed for " . date('l, F j, Y', strtotime($booking_date)) . " at " . date('h:i A', strtotime($booking_time)) . ".</p>";
              } else {
                  echo "<p class='error'>Failed to save booking. Please try again.</p>";
              }
          } else {
              echo "<p class='error'>Please select a date and time.</p>";
          }
      }
      ?>

      <!-- Booking Form -->
      <form method="post" id="bookingForm3" class="bookingForm">
        <input type="hidden" name="service" value="Nutrition">

        <label for="booking_date3">Choose a Day:</label>
        <select name="booking_date" id="booking_date3" required>
            <option value="">-- Wednesdays & Saturdays only --</option>
            <?php foreach($dates3 as $date): ?>
                <option value="<?= $date ?>"><?= date('l, F j, Y', strtotime($date)) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="booking_time3">Choose a Time:</label>
        <select name="booking_time" id="booking_time3" required>
            <option value="">-- 09:00 AM to 01:00 PM --</option>
            <?php foreach($timeSlots3 as $time): ?>
                <option value="<?= $time ?>"><?= date("h:i A", strtotime($time)) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Confirm Booking</button>
      </form>
    </div>
    <!-- End Booking Form -->

  </div>

  <div class="hero-image-wrapper">
    <img src="S3.jpg" alt="Nutrition and Diet" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>

  <a href="#" class="back-btn" onclick="goBack()">← Back to Home</a>
</section>

<script>
const isCustomerLoggedIn3 = <?= isset($_SESSION['customer_id']) ? 'true' : 'false' ?>;

function handleBooking3(button) {
    if(!isCustomerLoggedIn3) {
        alert("Please login first to book a service.");
        window.location.href = "login.php";
        return;
    }
    document.getElementById('bookingFormContainer3').classList.remove('hidden');
}
</script>


<section id="Service4" class="Service4 hidden"> 
  <div class="Service4_Content">
    <h1>PHYSIOTHERAPY</h1>
    <p>
      Regain strength, mobility, and confidence with our specialized physiotherapy treatments.
      We use evidence-based techniques to treat pain, restore movement, and support recovery.
    </p>

    <div class="benefit-box">
      <div class="card">
        <h3>Benefits</h3>
        <ul>
          <li>Reduces chronic pain and discomfort</li>
          <li>Accelerates recovery from injuries or surgeries</li>
          <li>Improves mobility, balance, and coordination</li>
          <li>Prevents future injuries with corrective exercises</li>
        </ul>
      </div>
      <a href="#" class="book-btn" data-service="Physiotherapy" onclick="handleBooking4(this)">BOOK NOW</a>
    </div>

    <!-- Booking Form Container -->
    <div id="bookingFormContainer4" class="hidden">
      <?php
    
      require 'db.php'; // your PDO connection

      // Available days: Wednesday & Saturday for the next 30 days
      $availableDays = ['Wednesday', 'Saturday'];
      $dates = [];
      $today = new DateTime();
      $interval = new DateInterval('P1D'); // daily interval
      $period = new DatePeriod($today, $interval, 30); // next 30 days

      foreach ($period as $date) {
          if (in_array($date->format('l'), $availableDays)) {
              $dates[] = $date->format('Y-m-d');
          }
      }

      // Time slots: 09:00 to 18:00 hourly
      $timeSlots = [];
      for ($hour = 9; $hour <= 18; $hour++) {
          $timeSlots[] = sprintf("%02d:00:00", $hour);
      }

      // Handle form submission
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['service'] ?? '') === 'Physiotherapy') {
          if(!isset($_SESSION['customer_id'])){
              die("<p class='error'>You must login to submit a booking. <a href='login.php'>Login here</a></p>");
          }

          $customer_id = $_SESSION['customer_id'];
          $booking_date = $_POST['booking_date'] ?? '';
          $booking_time = $_POST['booking_time'] ?? '';

          // Map service to therapist_id
          $therapists = ['Physiotherapy' => 4]; // replace 4 with actual therapist ID
          $therapist_id = $therapists['Physiotherapy'];

          if ($booking_date && $booking_time) {
              $stmt = $pdo->prepare("INSERT INTO bookings (customer_id, therapist_id, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?)");
              if ($stmt->execute([$customer_id, $therapist_id, 'Physiotherapy', $booking_date, $booking_time])) {
                  echo "<p class='message'>Booking confirmed for " . date('l, F j, Y', strtotime($booking_date)) . " at " . date('h:i A', strtotime($booking_time)) . ".</p>";
              } else {
                  echo "<p class='error'>Failed to save booking. Please try again.</p>";
              }
          } else {
              echo "<p class='error'>Please select a date and time.</p>";
          }
      }
      ?>

      <!-- Booking Form -->
      <form method="post" id="bookingForm4" class="bookingForm">
        <input type="hidden" name="service" value="Physiotherapy">

        <!-- Select date -->
        <label for="booking_date4">Choose a Day:</label>
        <select name="booking_date" id="booking_date4" required>
            <option value="">-- Wednesdays & Saturdays only --</option>
            <?php foreach($dates as $date): ?>
                <option value="<?= $date ?>"><?= date('l, F j, Y', strtotime($date)) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Select time -->
        <label for="booking_time4">Choose a Time:</label>
        <select name="booking_time" id="booking_time4" required>
            <option value="">-- 09:00 AM to 06:00 PM --</option>
            <?php foreach($timeSlots as $time): ?>
                <option value="<?= $time ?>"><?= date("h:i A", strtotime($time)) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Confirm button -->
        <button type="submit">Confirm Booking</button>
      </form>
    </div>
    <!-- End Booking Form -->

  </div>

  <div class="hero-image-wrapper">
    <img src="S4.jpg" alt="Physiotherapy" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>

  <a href="#" class="back-btn" onclick="goBack()">← Back to Home</a>
</section>

<script>
const isCustomerLoggedIn4 = <?= isset($_SESSION['customer_id']) ? 'true' : 'false' ?>;

function handleBooking4(button) {
    if(!isCustomerLoggedIn4) {
        alert("Please login first to book a service.");
        window.location.href = "login.php";
        return;
    }
    document.getElementById('bookingFormContainer4').classList.remove('hidden');
}
</script>

<style>
.bookingForm {
    margin-top: 10px;
    padding: 15px;
    background: #097c1602;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    max-width: 40%;
    margin-left: 250px;
}

.bookingForm label {
    display: block;
    font-weight: 600;
    margin-top: 15px;
    color: #333;
}

.bookingForm select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    transition: border 0.3s;
}

.bookingForm select:focus {
    border-color: #ff7300;
    outline: none;
}

.bookingForm button {
    padding: 10px 20px;
    margin-top: 15px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background-color: #ff7300;
    color: #fff;
    transition: background 0.3s;
}

.bookingForm button:hover {
    background-color: #e65c00;
}
</style>
<div id="bookingSuccessModal" class="hidden modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h3>Booking Confirmed!</h3>
    <p>Your booking has been successfully saved. See you soon!</p>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("loginBtn");
    const modal = document.getElementById("loginModal");
    const closeBtn = document.querySelector(".closeBtn");
    const authFrame = document.getElementById("authFrame");
    const navButtonContainer = document.getElementById("navButtonContainer");

    if(loginBtn){
        loginBtn.addEventListener("click", () => {
            authFrame.src = "login.php";
            modal.style.display = "flex";
        });
    }

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });

    window.addEventListener("message", (event) => {
        if (event.data === "showRegister") {
            authFrame.src = "register.php";
        }
        if (event.data === "showLogin") {
            authFrame.src = "login.php";
        }
        if (event.data.type === "authSuccess") {
            modal.style.display = "none";
            navButtonContainer.innerHTML = `
                <span>Hi, <?= htmlspecialchars($customerName) ?></span>
                <a href="logout.php" class="btn">Logout</a>
            `;
        }
    });
});
</script>



<!-- Login/Register Modal -->
<div id="loginModal" class="modal" style="
    display:none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 120%;
    background-color: rgba(173, 173, 173, 0.08);
    justify-content: center;
    align-items: center;
    z-index: 1000;
">
    <div class="modal-content" style="
        background: #65796a5f;
        padding: 20px;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
        max-hight: 800px;
        hight: 100%;
        position: relative;
    ">
        <span class="closeBtn" style="
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        ">&times;</span>
        <iframe id="authFrame" style="width:100%; height:400px; border:none;"></iframe>
    </div>
</div>


   

<script>
function showService(serviceId) {
  if (serviceId === "Programmes") {
    // Show all main pages (don't hide anything)
    document.querySelectorAll('#Home, #Service, #About, #Contact, #Programmes')
      .forEach(section => section.classList.remove('hidden'));

    // Scroll to Programmes section
    document.getElementById('Programmes').scrollIntoView({ behavior: 'smooth' });
    return;
  }

  // Normal flow: hide all main pages except Programmes
  document.querySelectorAll('#Home, #Service, #About,#Programmes, #Contact')
    .forEach(section => section.classList.add('hidden'));

  // Hide all subpages
  document.querySelectorAll('.Service1, .Service2, .Service3, .Service4')
    .forEach(section => section.classList.add('hidden'));

  // Show the selected subpage
  const selected = document.getElementById(serviceId);
  if (selected) {
    selected.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

function goBack() {
  // Hide all subpages
  document.querySelectorAll('.Service1, .Service2, .Service3, .Service4')
    .forEach(section => section.classList.add('hidden'));

  // Show all main pages
  document.querySelectorAll('#Home, #Service, #About, #Contact, #Programmes')
    .forEach(section => section.classList.remove('hidden'));

  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

<script>
const isCustomerLoggedIn = <?= isset($_SESSION['customer_id']) ? 'true' : 'false' ?>;

function handleBooking(button) {
    if(!isCustomerLoggedIn) {
        alert("Please login first to book a service.");
        window.location.href = "login.php"; 
        return;
    }

    // Hide all booking forms
    document.querySelectorAll('[id^="bookingFormContainer"]').forEach(form => {
        form.classList.add('hidden');
    });

    // Show the correct booking form based on service
    const service = button.getAttribute("data-service");
    if(service === "Ayurveda") document.getElementById("bookingFormContainer").classList.remove("hidden");
    else if(service === "Yoga") document.getElementById("bookingFormContainer2").classList.remove("hidden");
    else if(service === "Nutrition") document.getElementById("bookingFormContainer3").classList.remove("hidden");
    else if(service === "Physiotherapy") document.getElementById("bookingFormContainer4").classList.remove("hidden");
}

// Attach AJAX submit to all booking forms
document.querySelectorAll('.bookingForm').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if(!isCustomerLoggedIn) {
            alert("Please login first to book a service.");
            window.location.href = "login.php";
            return;
        }

        const formData = new FormData(this);

        fetch('booking_process.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if(data.includes('success')) {
                showBookingSuccess(); // show modal/banner
                this.reset(); // clear form
                const serviceSection = this.closest('[id^="Service"]');
                if(serviceSection) serviceSection.classList.add('hidden'); // hide service section
            } else {
                alert('Booking failed. Please try again.');
            }
        })
        .catch(err => console.error(err));
    });
});

// Booking success modal
function showBookingSuccess() {
    const modal = document.getElementById('bookingModal');
    if(modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'block';
    } else {
        alert("Booking Confirmed!"); // fallback if modal not present
    }
}

function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    if(modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }
}
</script>


<script>
window.addEventListener('DOMContentLoaded', () => {
    const isLoggedIn = <?= json_encode($isLoggedIn) ?>;
    const forms = document.querySelectorAll('.programForm');

    const getForm = (id) => document.getElementById('programForm' + id);
    const getMsgBox = (id) => document.getElementById('programMessage' + id);

    function hideAllForms() {
        forms.forEach(f => f.classList.add('hidden'));
    }

    function showMessage(programId, html, type = 'info') {
        const box = getMsgBox(programId);
        if (!box) return;
        box.innerHTML = `<div class="msg ${type}">${html}</div>`;
    }

    function clearAllMessages() {
        [1, 2, 3].forEach(id => {
            const box = getMsgBox(id);
            if (box) box.innerHTML = '';
        });
    }

    // Global function for inline onclick
    window.handleBooking = function(linkEl) {
        const programId = linkEl.dataset.program;
        clearAllMessages();

        if (!isLoggedIn) {
            hideAllForms();
            showMessage(programId, 'Please log in to register. <a href="login.php">Log in</a>', 'error');
            return false;
        }

        hideAllForms();
        const form = getForm(programId);
        if (form) form.classList.remove('hidden');
        return false; // critical for inline onclick="return handleBooking(this)"
    };

    // Prevent default behavior for all register links
    document.querySelectorAll('.register_btn').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            handleBooking(e.currentTarget);
        });
    });

    // AJAX form submission
    forms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const programId = form.querySelector('input[name="program_id"]').value;
            const msgBox = getMsgBox(programId);
            const submitBtn = form.querySelector('button[type="submit"]');

            if (msgBox) msgBox.innerHTML = '<div class="msg info">Registering...</div>';
            if (submitBtn) submitBtn.disabled = true;

            try {
                const res = await fetch(REGISTER_URL, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
               });

                const text = await res.text();

                // Handle server responses
                const lower = text.toLowerCase();

                if (res.redirected && res.url.includes('login.php')) {
                    showMessage(programId, 'Your session expired. Please <a href="login.php">log in</a>.', 'error');
                    return;
                } else if (lower.includes('registration successful')) {
                    showMessage(programId, 'Registration successful!', 'success');
                    form.classList.add('hidden');
                } else if (lower.includes('already registered')) {
                    showMessage(programId, 'You have already registered for this program.', 'info');
                } else if (lower.includes('invalid program')) {
                    showMessage(programId, 'Invalid program selected.', 'error');
                } else if (lower.includes('registration failed')) {
                    showMessage(programId, 'Registration failed. Please try again.', 'error');
                } else {
                    showMessage(programId, 'Unexpected server response. Please refresh and try again.', 'error');
                    console.warn('program_register.php response:', text);
                }
            } catch (err) {
                showMessage(programId, 'Network error. Please try again.', 'error');
                console.error(err);
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    });
});
</script>









<script>
// Chat popup functionality
const chatButton = document.getElementById("chatButton");
const chatPopup = document.getElementById("chatPopup");
const closeChat = document.getElementById("closeChat");

chatButton.addEventListener("click", () => chatPopup.style.display = "block");
closeChat.addEventListener("click", () => chatPopup.style.display = "none");
window.addEventListener("click", function(e) {
    if (e.target === chatPopup) chatPopup.style.display = "none";
});

// Send inquiry functionality
document.addEventListener("DOMContentLoaded", () => {
  const sendBtn = document.getElementById("sendMessage");

  sendBtn.addEventListener("click", () => {
    const type = document.getElementById("chatType").value;
    const subject = document.getElementById("chatSubject").value.trim();
    const message = document.getElementById("chatMessage").value.trim();
    const errorBox = document.getElementById("chatError");

    if (!type || !subject || !message) {
      errorBox.style.color = "red";
      errorBox.textContent = "Please fill in all fields.";
      return;
    }

    fetch("send_inquiry.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `type=${encodeURIComponent(type)}&subject=${encodeURIComponent(subject)}&message=${encodeURIComponent(message)}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        errorBox.style.color = "green";
        errorBox.textContent = "Inquiry sent successfully!";
        document.getElementById("chatSubject").value = "";
        document.getElementById("chatMessage").value = "";
      } else {
        errorBox.style.color = "red";
        errorBox.textContent = data.message;
      }
    })
    .catch(() => {
      errorBox.style.color = "red";
      errorBox.textContent = "Error sending inquiry. Try again.";
    });
  });
});
</script>



</body>
</html>
