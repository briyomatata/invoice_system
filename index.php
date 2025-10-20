<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peaksphere Ken Limited - Empowering Youth & Entrepreneurs</title>
    <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="index.css">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="#home">
          Peaksphere <span class="text-success">Ken</span>
        </a>
        <button
          class="navbar-toggler"
          data-bs-toggle="collapse"
          data-bs-target="#nav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="nav">
          <ul class="navbar-nav gap-3">
            <li><a class="nav-link" href="#home">Home</a></li>
            <li><a class="nav-link" href="#about">About</a></li>
            <li><a class="nav-link" href="#pillars">Services</a></li>
            <li>
              <a class="btn btn-success px-4 rounded-pill" href="#contact"
                >Contact</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero -->
   <!-- Hero -->
<section class="hero py-5" id="home">
  <div class="container">
    <div class="row align-items-center g-5">
      <!-- Text Column -->
      <div class="col-lg-6 text-center text-lg-start text-white">
        <h1 class="display-4 fw-bold mb-3">Empowering the Next Generation</span> of Entrepreneurs</h1>
        <p class="lead mb-4">We mentor, inspire, and support youth by transforming ideas into thriving enterprises.</p>
        <a href="#contact" class="btn btn-lg btn-light rounded-pill shadow px-5">Start Your Journey</a>
      </div>
      <!-- Image Column -->
      <div class="col-lg-6 text-center">
        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=900&q=80" 
             alt="Young entrepreneurs working" 
             class="img-fluid rounded-4 shadow">
      </div>
    </div>
  </div>
</section>

    <!-- Services -->
    <section class="py-5" id="pillars">
      <div class="container">
        <h2 class="display-6 fw-bold text-center text-primary mb-4">
          Our Five Core Pillars
        </h2>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card service-card p-4 text-center">
              <i class="bi bi-lightbulb service-icon"></i>
              <h5>Business Incubation</h5>
              <p>
                Providing startups with resources, networks & guidance from idea
                to market.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card service-card p-4 text-center">
              <i class="bi bi-people service-icon"></i>
              <h5>Youth Mentorship</h5>
              <p>
                Hands-on mentorship to equip young entrepreneurs with skills &
                resilience.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card service-card p-4 text-center">
              <i class="bi bi-gear service-icon"></i>
              <h5>Business Support</h5>
              <p>
                Professional services that boost efficiency & organizational
                performance.
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card service-card p-4 text-center">
              <i class="bi bi-link-45deg service-icon"></i>
              <h5>Market Linkages</h5>
              <p>
                Connecting businesses to opportunities, partners & broader
                markets.
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card service-card p-4 text-center">
              <i class="bi bi-mortarboard service-icon"></i>
              <h5>Entrepreneurship Training</h5>
              <p>
                High-impact training programs for innovation, leadership &
                excellence.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

   <!-- About -->
<section class="py-5 bg-light" id="about">
  <div class="container">
    <div class="row align-items-center g-4">
      <!-- Image -->
      <div class="col-md-6">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80" 
             alt="Team collaboration" 
             class="img-fluid rounded-4 shadow">
      </div>
      <!-- Text -->
      <div class="col-md-6 text-center text-md-start">
        <h2 class="display-6 fw-bold text-primary mb-3">About Us</h2>
        <p class="lead text-muted">
          Peaksphere Ken Limited drives entrepreneurship, innovation, and sustainable business growth in Kenya. 
          We empower individuals and enterprises through tailored programs designed to unlock potential and create lasting impact.
        </p>
      </div>
    </div>
  </div>
</section>

    <!-- Contact (Form only) -->
    <section class="py-5" id="contact">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="fw-bold text-primary">Let's Build Your Success Story</h2>
          <p class="lead">Send us an inquiry and we’ll get back to you.</p>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card shadow p-4 rounded-4">
              <form method="POST" action="send_mail.php">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    name="name"
                    placeholder="Name"
                    required
                  />
                  <label>Full Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="Email"
                    required
                  />
                  <label>Email</label>
                </div>
                <div class="form-floating mb-3">
                  <select class="form-select" name="service" required>
                    <option selected disabled>Choose a service...</option>
                    <option>Business Incubation</option>
                    <option>Youth Mentorship</option>
                    <option>Business Support</option>
                    <option>Market Linkages</option>
                    <option>Entrepreneurship Training</option>
                  </select>
                  <label>Interested Service</label>
                </div>
                <div class="form-floating mb-3">
                  <textarea
                    class="form-control"
                    name="message"
                    style="height: 120px"
                    required
                  ></textarea>
                  <label>Message</label>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary w-100 rounded-pill"
                >
                  Submit Inquiry
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 mt-5">
      <div class="container">
        <div class="row">
          <!-- Company Info -->
          <div class="col-md-4 mb-4">
            <h5 class="fw-bold">Peaksphere Ken Limited</h5>
            <p>
              Driving entrepreneurship, innovation, and sustainable business
              growth in Kenya.
            </p>
          </div>
          <!-- Quick Links -->
          <div class="col-md-4 mb-4">
            <h6 class="fw-bold">Quick Links</h6>
            <ul class="list-unstyled">
              <li>
                <a href="#about" class="text-white text-decoration-none"
                  >About Us</a
                >
              </li>
              <li>
                <a href="#pillars" class="text-white text-decoration-none"
                  >Services</a
                >
              </li>
              <li>
                <a href="#contact" class="text-white text-decoration-none"
                  >Contact</a
                >
              </li>
            </ul>
          </div>
          <!-- Contact Info -->
          <div class="col-md-4 mb-4">
            <h6 class="fw-bold">Contact</h6>
            <p><i class="bi bi-geo-alt-fill me-2"></i> Nairobi, Kenya</p>
            <p><i class="bi bi-envelope-fill me-2"></i> peaksphere@gmail.com</p>
            <p><i class="bi bi-telephone-fill me-2"></i> +254 712345678</p>
            <div class="footer-social d-flex gap-3 mt-3">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-twitter"></i></a>
              <a href="#"><i class="bi bi-facebook"></i></a>
            </div>
          </div>
        </div>
        <div class="text-center mt-4 border-top pt-3">
          <p class="mb-0">
            &copy; 2025 Peaksphere Ken Limited. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
    <!-- Back to Top Button -->
    <button id="backToTop"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Show/Hide button on scroll
      const backToTop = document.getElementById("backToTop");
      window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
          backToTop.style.display = "flex";
        } else {
          backToTop.style.display = "none";
        }
      });

      // Smooth scroll to top
      backToTop.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
    </script>
  </body>
</html>
