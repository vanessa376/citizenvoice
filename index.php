<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CitiVoice | Amplify Your Voice</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }

    nav {
      background-color: #007bff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav .logo img {
      height: 70px;
      width: auto;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 1em;
    }

    nav ul li a:hover {
      text-decoration: underline;
    }

    .hero-section {
      background-image: url('abaturage.png');
      height: 80vh;
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
    }

    .hero-content h1 {
      font-size: 3em;
      margin-bottom: 10px;
    }

    .hero-content span {
      color: #ffcc00;
    }

    .cta-btn {
      background-color: #ffcc00;
      color: black;
      padding: 12px 25px;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
      font-weight: bold;
    }

    .about-section, .how-section {
      padding: 40px;
      text-align: center;
    }

    .steps {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .step {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      max-width: 300px;
      margin: 10px;
    }

    .step:hover {
      transform: translateY(-5px);
    }

    .step i {
      font-size: 2em;
      margin-bottom: 10px;
      color: #007bff;
    }

    footer {
      background-color: #333;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <nav>
    <div class="logo">
      <a href="#"><img src="logo.png" alt="CitiVoice Logo"></a>
    </div>
    <ul>
      <li><a href="#about">About Us</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#faqs">FAQs</a></li>
      <li><a href="signup.php">Get Started</a></li>
    </ul>
  </nav>

  <header class="hero-section">
    <div class="hero-content">
      <h1>Amplify Your Voice with <span>CitiVoice</span></h1>
      <p>Speak up, be heard, and make a difference in your community with our powerful civic engagement platform.</p>
      <a href="#about" class="cta-btn">Learn More</a>
    </div>
  </header>

  <section id="about" class="about-section">
    <h2>About CitiVoice</h2>
    <p>CitiVoice is a platform that enables citizens to raise issues, engage with local authorities, and track resolutions effortlessly. Your voice matters—make it count.</p>
  </section>

  <section id="services" class="about-section">
    <h2>Our Services</h2>
    <p>We provide tools for citizens to submit complaints, track their progress, and receive timely resolutions from local authorities.</p>
  </section>

  <section id="faqs" class="about-section">
    <h2>Frequently Asked Questions</h2>
    <p>Find answers to common questions about how to use CitiVoice and how it benefits your community engagement.</p>
  </section>

  <section id="how-it-works" class="how-section">
    <h2>How It Works</h2>
    <div class="steps">
      <div class="step">
        <i class="fas fa-edit"></i>
        <h3>Submit a Complaint</h3>
        <p>Share your concerns directly with authorities.</p>
      </div>
      <div class="step">
        <i class="fas fa-tasks"></i>
        <h3>Track Progress</h3>
        <p>Follow up on the status of your complaint easily.</p>
      </div>
      <div class="step">
        <i class="fas fa-check-circle"></i>
        <h3>Get Resolutions</h3>
        <p>Receive updates and final resolutions promptly.</p>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 CitiVoice. All rights reserved.</p>
  </footer>

</body>
</html>
