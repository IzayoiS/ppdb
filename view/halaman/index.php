<!doctype html>
<html lang="en">

  <head>
    <title>SMK BINA RAHAYU</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700|Indie+Flower" rel="stylesheet">
    
    <link rel="icon" href="../../assets/img/avatar/icone.PNG">

    <link rel="stylesheet" href="../../assets/style/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../../assets/style/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../../assets/style/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/style/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../assets/style/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="../../assets/style/css/aos.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../../assets/style/css/style.css">
    
    <style>
      .slider-img {
        width: 100%;
        height: 100%;
        object-fit: contain;     
        object-position: center; 
      }

      @media (min-width: 768px) {
        #heroSlider .carousel-inner {
          height: 950px;
        }
      }

      /* Reduce gap between slider and diagram */
      #heroSlider {
        margin-bottom: 0;
      }

      .container .card {
        margin-top: 2rem !important;
      }

      /* Responsive Navbar Styles */
      .site-mobile-menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #000;
        position: relative;
        z-index: 2001;
        padding: 8px 12px;
      }

      @media (max-width: 991.98px) {
        .site-mobile-menu-toggle {
          display: block;
        }

        .site-navigation {
          display: none !important;
        }

        .site-quick-contact {
          display: none !important;
        }

        .top-social {
          width: 100%;
          justify-content: center;
          text-align: center;
          margin-top: 10px;
          display: none !important;
        }

        .menu-wrap {
          justify-content: space-between;
          padding: 5px 15px !important;
          border-radius: 50px;
        }

        .site-logo {
          flex: 1;
        }

        .site-logo a {
          font-size: 1.8rem !important;
        }

        /* Reduce gap on mobile */
        .container .card {
          margin-top: 1rem !important;
        }
      }

      /* Mobile Menu Improvements */
      .site-mobile-menu {
        width: 300px;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 2000;
        padding-top: 20px;
        background: #fff;
        height: 100vh;
        transform: translateX(100%);
        box-shadow: -10px 0 20px -10px rgba(0, 0, 0, 0.1);
        transition: .3s all ease-in-out;
        overflow-y: auto;
      }

      .site-mobile-menu.active {
        transform: translateX(0);
      }

      .site-mobile-menu-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
      }

      .site-mobile-menu-close {
        float: right;
        font-size: 2rem;
        cursor: pointer;
      }

      .site-mobile-menu-body {
        padding: 20px;
      }

      .mobile-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .mobile-menu-list li {
        margin-bottom: 15px;
      }

      .mobile-menu-list li a {
        display: block;
        padding: 10px 15px;
        color: #000;
        text-decoration: none;
        border-radius: 4px;
        transition: .3s all ease;
      }

      .mobile-menu-list li a:hover,
      .mobile-menu-list li a.active {
        background: #fd4d40;
        color: #fff;
      }

      .mobile-menu-divider {
        height: 1px;
        background: #eee;
        margin: 20px 0;
      }

      /* Overlay when menu is open */
      .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        opacity: 0;
        visibility: hidden;
        transition: .3s all ease;
      }

      .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="site-wrap" id="home-section">

      <!-- Mobile Menu Overlay -->
      <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

      <!-- Mobile Menu -->
      <div class="site-mobile-menu" id="mobileMenu">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close" id="closeMobileMenu">
            <span>&times;</span>
          </div>
          <div style="clear: both;"></div>
        </div>
        <div class="site-mobile-menu-body">
          <ul class="mobile-menu-list">
            <li><a href="" class="active">Home</a></li>
            <li><div class="mobile-menu-divider"></div></li>
            <li><a href="login.php">Login Peserta</a></li>
            <li><a href="daftarSiswa.php">Daftar Peserta</a></li>
            <li><a href="../login">Login Guru</a></li>
          </ul>
        </div>
      </div>

      <header class="site-navbar site-navbar-target" role="banner">
        <div class="container mb-3">
          <div class="d-flex align-items-center">
            <div class="site-logo mr-auto">
              <a href="index.html">SPTB<span class="text-primary">.</span></a>
            </div>
            <div class="site-quick-contact d-none d-lg-flex ml-auto">
              <div class="d-flex site-info align-items-center mr-5">
                <span class="block-icon mr-3"><span class="icon-map-marker text-yellow"></span></span>
                <span>Jl. Raya Pengasinan No. 55, Sawangan <br> Depok</span>
              </div>
              <div class="d-flex site-info align-items-center">
                <span class="block-icon mr-3"><span class="icon-clock-o"></span></span>
                <span>Sunday - Friday 8:00AM - 4:00PM <br> Saturday CLOSED</span>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="menu-wrap d-flex align-items-center">
            <!-- Desktop Navigation -->
            <nav class="site-navigation text-left mr-auto d-none d-lg-block" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto">
                <li class="active"><a href="" class="">Home</a></li>
              </ul>
            </nav>

            <!-- Desktop Top Social -->
            <div class="top-social ml-auto d-none d-lg-flex align-items-center">
              <a href="login.php" class="mr-3 text-success small">Login Peserta</a>
              <a href="daftarSiswa.php" class="mr-3 text-teal small">Daftar Peserta</a> |
              <a href="../login" class="text-yellow small">Login Guru</a>
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="site-mobile-menu-toggle ml-auto d-lg-none" id="openMobileMenu">
              <span class="icon-menu"></span>
            </div>
          </div>
        </div>
      </header>

      <!-- Hero Slider -->
      <div id="heroSlider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#heroSlider" data-slide-to="0" class="active"></li>
          <li data-target="#heroSlider" data-slide-to="1"></li>
          <li data-target="#heroSlider" data-slide-to="2"></li>
          <li data-target="#heroSlider" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../../assets/style/images/hero_1.PNG" class="slider-img" alt="Hero 1">
          </div>
          <div class="carousel-item">
            <img src="../../assets/style/images/hero_2.PNG" class="slider-img" alt="Hero 2">
          </div>
          <div class="carousel-item">
            <img src="../../assets/style/images/hero_3.PNG" class="slider-img" alt="Hero 3">
          </div>
          <div class="carousel-item">
            <img src="../../assets/style/images/hero_4.JPEG" class="slider-img" alt="Hero 4">
          </div>
        </div>

        <a class="carousel-control-prev" href="#heroSlider" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#heroSlider" role="button" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>

      <!-- Diagram Kuota Jurusan -->
      <div class="container">
        <div class="card shadow-sm p-3 mt-5">
          <h5 class="text-center mb-3 text-dark font-weight-bold">Diagram Sisa Kuota Jurusan</h5>
          <canvas id="chartKuota" height="100"></canvas>
          <div id="keteranganKuota" class="mt-3 text-center"></div>
        </div>
      </div>

      <!-- Gallery Section -->
      <div class="site-section">
        <div class="container">
          <div class="row mb-5">
            <div class="col-12 text-center">
              <span class="text-cursive h5 text-red d-block">Our Gallery</span>
              <h2 class="text-black">Gallery Of SMK Bina Rahayu</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-4">
              <a href="../../assets/style/images/image1.jpg" data-fancybox="gal"><img src="../../assets/style/images/image1.jpg" alt="Image" class="img-fluid"></a>
            </div>
            <div class="col-md-4 mb-4">
              <a href="../../assets/style/images/image2.jpg" data-fancybox="gal"><img src="../../assets/style/images/image2.jpg" alt="Image" class="img-fluid"></a>
            </div>
            <div class="col-md-4 mb-4">
              <a href="../../assets/style/images/image3.jpg" data-fancybox="gal"><img src="../../assets/style/images/image3.jpg" alt="Image" class="img-fluid"></a>
            </div>
            <div class="col-md-4 mb-4">
              <a href="../../assets/style/images/image4.jpg" data-fancybox="gal"><img src="../../assets/style/images/image4.jpg" alt="Image" class="img-fluid"></a>
            </div>
            <div class="col-md-4 mb-4">
              <a href="../../assets/style/images/image5.jpg" data-fancybox="gal"><img src="../../assets/style/images/image5.jpg" alt="Image" class="img-fluid"></a>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="site-section py-5 bg-warning">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-12 d-flex">
              <h2 class="text-white m-0">Penerimaan Taruna Baru</h2>
              <a href="daftarSiswa.php" class="btn btn-primary btn-custom-1 py-3 px-5 ml-auto">Daftar!</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="site-footer" style="padding: 20px 0 5px 0">
        <div class="container">
          <p class="text-center"> Modified By : <a>Mahasiswa Unpam</a> </p>
        </div>
      </footer>

    </div>

    <!-- Scripts -->
    <script src="../../assets/style/js/jquery-3.3.1.min.js"></script>
    <script src="../../assets/style/js/popper.min.js"></script>
    <script src="../../assets/style/js/bootstrap.min.js"></script>
    <script src="../../assets/style/js/owl.carousel.min.js"></script>
    <script src="../../assets/style/js/jquery.fancybox.min.js"></script>

    <!-- Mobile Menu Script -->
    <script>
      $(document).ready(function() {
        // Open mobile menu
        $('#openMobileMenu').click(function() {
          $('#mobileMenu').addClass('active');
          $('#mobileMenuOverlay').addClass('active');
          $('body').css('overflow', 'hidden');
        });

        // Close mobile menu
        $('#closeMobileMenu, #mobileMenuOverlay').click(function() {
          $('#mobileMenu').removeClass('active');
          $('#mobileMenuOverlay').removeClass('active');
          $('body').css('overflow', 'auto');
        });

        // Close menu when clicking a link
        $('.mobile-menu-list a').click(function() {
          $('#mobileMenu').removeClass('active');
          $('#mobileMenuOverlay').removeClass('active');
          $('body').css('overflow', 'auto');
        });
      });
    </script>

    <!-- Chart Script -->
    <?php
      include('../../config/connection.php');
      $kuota = mysqli_query($conn, "SELECT jurusan, kuota_total, kuota_terisi FROM setting_kuota");
      $labels = [];
      $data_sisa = [];
      $data_terisi = [];
      $data_total = [];

      while ($row = mysqli_fetch_assoc($kuota)) {
        $sisa = $row['kuota_total'] - $row['kuota_terisi'];
        $labels[] = $row['jurusan'];
        $data_sisa[] = $sisa;
        $data_terisi[] = $row['kuota_terisi'];
        $data_total[] = $row['kuota_total'];
      }
    ?>
    <script>
      const labels = <?php echo json_encode($labels); ?>;
      const sisa = <?php echo json_encode($data_sisa); ?>;
      const terisi = <?php echo json_encode($data_terisi); ?>;
      const total = <?php echo json_encode($data_total); ?>;

      const ctx = document.getElementById('chartKuota').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Sisa Kuota',
            data: sisa,
            borderWidth: 1,
            backgroundColor: '#4CAF50'
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Jumlah Sisa Kuota' } },
            x: { title: { display: true, text: 'Jurusan' } }
          },
          plugins: { legend: { display: false } }
        }
      });

      // Keterangan kuota
      const keteranganDiv = document.getElementById('keteranganKuota');
      let html = '';
      labels.forEach((nama, i) => {
        const status = terisi[i] >= total[i]
          ? `<span class='text-danger'>(Penuh)</span>`
          : `<span class='text-success'>(Tersisa ${sisa[i]})</span>`;
        html += `<div class="small mb-1">${nama}: <b>${terisi[i]}/${total[i]}</b> ${status}</div>`;
      });
      keteranganDiv.innerHTML = html;
    </script>
  </body>

</html>