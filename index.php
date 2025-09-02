<?php
session_start();

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? '',
];

$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
  return $formName === $activeForm ? 'active' : '';
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
    <section class="background">
        <div class="overlay"></div>
        <header>
            <nav class="nav_container">
                <!-- Left Logo -->
                <div class="nav_logo">
                    <img src="Logo.png" alt="Green Life Wellness Center Logo">
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
                <div class="nav_button">
                    <button class="btn" onclick="showForm('login_form')">Login</button>
                </div>
            </nav>

            <div class="section_container header_container">
                <div class="header_content">
                    <h1>Welcome to Green Life Wellness Center</h1>
                    <p>At Green Life, we believe true wellness is more than the absence of illness — it’s the harmony of mind, body, and spirit.
                      Our mission is to guide you toward a healthier, balanced, and more fulfilling life through natural therapies, personalized care, and holistic healing.</p>
                    
                    <h2>Why Choose Green Life?</h2>
                    <ul>
                        <li>A peaceful sanctuary to recharge your energy</li>
                        <li>Experienced practitioners who care from the heart</li>
                        <li>Natural, safe, and holistic treatments</li>
                        <li>Tailored wellness plans designed just for you</li>
                    </ul>

                    <h3>Our Promise</h3>
                    <p>Every visit is more than a treatment — it’s a journey. From the moment you step in, you’ll be surrounded by warmth, compassion, and a calming environment where healing begins naturally.
                    We’re here to listen, support, and empower you on your path to wellness.</p>
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
      <a href="#" class="register_btn">REGISTER</a>
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
      <a href="#" class="register_btn">REGISTER</a>
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
      <a href="#" class="register_btn">REGISTER</a>
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

    <!-- Login Form -->
    <section class="login_container">
        <div class="form_box <?= isActiveForm('Login', $activeForm); ?>" id="login_form">
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>You don’t have an account? Click <a href="#" onclick="showForm('signup_form')">Sign-up</a></p>
            </form>
            <div class="back_homepage"><a href="#">Back to homepage</a></div>
        </div>
    </section>

    <!-- Signup Form -->
    <section class="signup_container">
        <div class="form_box  <?= isActiveForm('register', $activeForm); ?>" id="signup_form">
            <form action="login_register.php" method="post">
                <h2>Sign-up</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="number" name="mobile_number" placeholder="Mobile Number" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Sign-up</button>
                <p>Already have an account? Click <a href="#" onclick="showForm('login_form')">Login</a></p>
            </form>
            <div class="back_homepage"><a href="#">Back to homepage</a></div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
