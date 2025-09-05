<?php
session_start();
// Check login status
$isLoggedIn = isset($_SESSION['customer_id']);
$customerName = $_SESSION['customer_name'] ?? '';
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
<section class="background">
    <div class="overlay"></div>
    <header>
        <nav class="nav_container">
            <div class="nav_logo">
                <img src="logo.png" alt="Green Life Wellness Center Logo">
                <h1>Green Life Wellness Center</h1>
            </div>

            <!-- Middle Nav Links -->
            <ul class="nav_links">
                <li class="link"><a href="#">Home</a></li>
                <li class="link"><a href="#">Services</a></li>
                <li class="link"><a href="#">Upcoming Programmes</a></li>
                <li class="link"><a href="#">About Us</a></li>
                <li class="link"><a href="#">Contact Us</a></li>
            </ul>

            <!-- Right Button -->
            <div class="nav_button" id="navButtonContainer">
                <?php if ($isLoggedIn): ?>
                    <span>Welcome, <?= htmlspecialchars($customerName) ?></span>
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

        <!-- Chat Floating Button -->
        <div class="chat-float">
            <button id="chatButton"><i class="ri-chat-smile-2-fill"></i> Inquiry</button>
        </div>

        <!-- Chat Popup -->
        <div id="chatPopup" class="chat-popup" style="display:none;">
            <div class="chat-header">
                <h3>Send Inquiry</h3>
                <span id="closeChat">&times;</span>
            </div>
            <div class="chat-body">
                <label for="chatSubject">Subject</label>
                <input type="text" id="chatSubject" placeholder="Enter subject" required />
                <label for="chatMessage">Message</label>
                <textarea id="chatMessage" rows="4" placeholder="Type your message..." required></textarea>
                <button id="sendMessage">Send</button>
            </div>
        </div>
    </header>
</section>


    <!-- Services Section -->
    <section class="service_container">
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
                        <a href="#">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-open-arm-fill"></i></span>
                        <h3>Yoga and Meditation</h3>
                        <p>Experience the perfect balance of mind and body through guided yoga postures and 
                            meditation practices that promote relaxation, flexibility, and inner peace.</p>
                        <a href="#">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-presentation-line"></i></span>
                        <h3>Nutrition and Diet Consultation</h3>
                        <p>Get personalized diet plans and expert nutrition 
                            advice to improve your health, boost energy, and achieve your wellness goals.</p>
                        <a href="#">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-hotel-bed-line"></i></span>
                        <h3>Physiotherapy</h3>
                        <p>Restore mobility, relieve pain, and strengthen your body with professional physiotherapy 
                            treatments designed for recovery and long-term well-being.</p>
                        <a href="#">More</a>
                    </div>

                    <div class="service_card">
                        <span><i class="ri-mental-health-fill"></i></span>
                        <h3>Wellness Programmes</h3>
                        <p>Join our holistic wellness programmes that combine Ayurveda, fitness, 
                            stress management, and lifestyle guidance for a healthier and happier you.</p>
                        <a href="#">More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- Programmes Section -->
<section class="programmes_container">
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
      <div class="programme_item">
        <i class="ri-calendar-schedule-fill"></i>
        <span>Date: September 10 – 14, 2025</span>
      </div>
      <div class="programme_item">
        <i class="ri-user-fill"></i>
        <span>Dr Nirmala Perera – Senior Ayurveda Specialist</span>
      </div>
      <div class="programme_item">
        <i class="ri-map-pin-2-fill"></i>
        <span>Green Life Wellness Center, Colombo</span>
      </div>
      <a href="#" class="register_btn" data-service="programme1" onclick="handleBooking(this)">REGISTER</a>
    </div>

    <!-- Programme 2 -->
    <div class="programme_card">
      <h3>Stress Relief & Mindfulness Workshop</h3>
      <div class="programme_item">
        <i class="ri-calendar-schedule-fill"></i>
        <span>Date: September 20, 2025</span>
      </div>
      <div class="programme_item">
        <i class="ri-user-fill"></i>
        <span>Mr. Sahan Jayawardena – Certified Yoga & Meditation Trainer</span>
      </div>
      <div class="programme_item">
        <i class="ri-map-pin-2-fill"></i>
        <span>Green Life Wellness Center, Colombo</span>
      </div>
      <a href="#" class="register_btn" data-service="programme2" onclick="handleBooking(this)">REGISTER</a>
    </div>

    <!-- Programme 3 -->
    <div class="programme_card">
      <h3>Healthy Weight Management Programme</h3>
      <div class="programme_item">
        <i class="ri-calendar-schedule-fill"></i>
        <span>Date: November 02, 2025</span>
      </div>
      <div class="programme_item">
        <i class="ri-user-fill"></i>
        <span>Ms. Anjali De Silva – Wellness Coach & Lifestyle Consultant</span>
      </div>
      <div class="programme_item">
        <i class="ri-map-pin-2-fill"></i>
        <span>Independence Square, Colombo 07</span>
      </div>
      <a href="#" class="register_btn" data-service="programme3" onclick="handleBooking(this)">REGISTER</a>
    </div>
  </div>
</section>


    <!-- About Section -->
    <section class="about_us_container">
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
    <footer class="footer">
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

   

<section class="Service1"> 
  <div class="Service1_Content">
    <h1>AYURVEDIC THERAPY</h1>
    <p>
      Experience the timeless healing power of Ayurveda. Our therapies combine
      herbal oils, detox treatments, and natural healing techniques to bring
      balance to your body and mind.
    </p>

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
      <a href="#" class="book-btn" data-service="Ayurveda" onclick="handleBooking(this)">BOOK NOW</a>
    </div>
  </div>

  <div class="hero-image-wrapper">
    <img src="S1.jpg" alt="Ayurveda Therapy" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>
</section>

<section class="Service2"> 
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
     <a href="#" class="book-btn" data-service="Yoga" onclick="handleBooking(this)">BOOK NOW</a>
    </div>
  </div>

  <div class="hero-image-wrapper">
    <img src="S2.jpg" alt="Yoga and Meditation" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>
</section>

<section class="Service3"> 
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
      <a href="#" class="book-btn" data-service="Nutrition" onclick="handleBooking(this)">BOOK NOW</a>
    </div>
  </div>

  <div class="hero-image-wrapper">
    <img src="S3.jpg" alt="Nutrition and Diet" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>
</section>

<section class="Service4"> 
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
      <a href="#" class="book-btn" data-service="Physiotherapy" onclick="handleBooking(this)">BOOK NOW</a>
    </div>
  </div>

  <div class="hero-image-wrapper">
    <img src="S4.jpg" alt="Physiotherapy" class="hero-image">
    <img src="Leaves4.png" alt="Decoration Leaf" class="decor-leaf leaf-left">
    <img src="Leaves3.png" alt="Decoration Leaf" class="decor-leaf leaf-right">
    <img src="Leaves1.png" alt="Decoration Flower" class="decor-flower">
  </div>
</section>
<script>

<!-- Booking Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

    window.handleBooking = function() {
        const authFrame = document.getElementById('authFrame');
        const loginModal = document.getElementById('loginModal');
        if (!isLoggedIn) {
            authFrame.src = "login.php";
            loginModal.style.display = "flex";
        } else {
            window.location.href = "booking.php";
        }
    };

 // Login/Register Modal
    const loginBtn = document.getElementById("loginBtn");
    const modal = document.getElementById("loginModal");
    const closeBtn = document.querySelector(".closeBtn");
    const authFrame = document.getElementById("authFrame");
    const navButtonContainer = document.getElementById("navButtonContainer");

    if(loginBtn){
        loginBtn.addEventListener("click", function() {
            authFrame.src = "login.php";
            modal.style.display = "flex";
        });
    }

    closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.addEventListener("click", function(e) {
        if (e.target === modal) modal.style.display = "none";
    });

    // Smooth modal switching & success update
    window.addEventListener("message", function(event) {
        if (event.data === "showRegister") {
            authFrame.src = "register.php";
        }
        if (event.data === "showLogin") {
            authFrame.src = "login.php";
        }
        if (event.data.type === "authSuccess") {
            // Close modal
            modal.style.display = "none";

            // Update nav button dynamically without reload
            navButtonContainer.innerHTML = `
                <span>Welcome, ${event.data.name}</span>
                <a href="logout.php" class="btn">Logout</a>
            `;
        }
    });

    // Chat popup functionality
    const chatButton = document.getElementById("chatButton");
    const chatPopup = document.getElementById("chatPopup");
    const closeChat = document.getElementById("closeChat");

    chatButton.addEventListener("click", () => chatPopup.style.display = "block");
    closeChat.addEventListener("click", () => chatPopup.style.display = "none");
    window.addEventListener("click", function(e) {
        if (e.target === chatPopup) chatPopup.style.display = "none";
    });
});
</script>

<!-- Login/Register Modal (Single Instance) -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="closeBtn">&times;</span>
        <iframe id="authFrame" src="login.php" frameborder="0"></iframe>
    </div>
</div>
</body>
</html>
</body>
</html>
