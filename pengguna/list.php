<?php
session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Trator</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <body>
   <div class="header_section">
         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand"href="index.html"><img src="images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="list.php">Kendaraan</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="transaksi.php">Transaksi</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="logout.php">logout</a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                  </form>
               </div>
            </nav>
         </div>
      </div>
      <div class="list_section layout_padding">
      <div class="container mt-5">
        <h1 class="text-center">Daftar Mobil</h1>
        <div class="row">
            <?php
            $host = 'localhost'; 
            $user = 'root';
            $pass = '';
            $db = 'rental_mobil'; 

            $conn = new mysqli($host, $user, $pass, $db);

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM tbl_mobil";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="/rentalMobil/pengguna/images/' . $row['foto'] . '" class="img-fluid rounded-start" alt="' . $row['sub_brand'] . '">';
                    echo '<div class="card-body">';
                    echo '<h2 class="card-title">' . $row['brand'] . '</h5>';
                    echo '<p class="card-text"><strong></strong> ' . $row['tahun'] . '</p>';
                    echo '<p class="looking_text"><strong>Harga:</strong> Rp' . number_format($row['harga'], 0, ',', '.') . ' per hari</p>';
                  //   echo '<p class="card-text"><strong></strong> ' . $row['status'] . '</p>';
                    echo '<div class="read_bt">';
                    if ($row['status'] == 'disewa' && $row['tgl_kembali'] <= date('Y-m-d')) {
                        echo '<a href="booking.php?nopol=' . $row['nopol'] . '&brand=' . $row['brand'] . '">Kembalikan Mobil</a>';
                    } if ($row['status'] == 'tersedia') {
                        echo '<a href="booking.php?nopol=' . $row['nopol'] . '&brand=' . $row['brand'] . '">Sewa Mobil</a>';
                    } else {
                        echo '<span>Mobil Disewa</span>';
                    }
                    echo '</div>';


                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p class='text-center'>Tidak ada data mobil.</p>";
            }

            $conn->close();
            ?>
            <style>
               .card {
                  height: 100%; 
                  display: flex;
                  flex-direction: column;
                }

               .card img {
                  object-fit: cover;
                  height: 204px; 
                  width: 100%; 
               }

               .card-body {
                  flex-grow: 1; 
               }

               .text-center {
                  text-align: center;
                  font-weight: bold; 
                  font-size: 40px; 
                  margin-bottom: 32px;
                  color: #3b3b3b; 
               }

               .card-title {
                  font-size: 24px;
                  font-weight: bold;
                  text-align: center;
               }

               .looking_text{
                  margin-bottom: 14px;
               }

               .card-text{
                  margin-top: 12px;
                  font-size: 14px;
                  text-align: center;
               }
               .card .btn {
                  margin-top: auto;
               }
            </style>
        </div>
    </div>
         
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="footeer_logo"><img src="images/logo.png"></div>
               </div>
            </div>
            <div class="footer_section_2">
               <div class="row">
                  <div class="col">
                     <h4 class="footer_taital">Subscribe Now</h4>
                     <p class="footer_text">There are many variations of passages of Lorem Ipsum available,</p>
                     <div class="form-group">
                        <textarea class="update_mail" placeholder="Enter Your Email" rows="5" id="comment" name="Enter Your Email"></textarea>
                        <div class="subscribe_bt"><a href="#">Subscribe</a></div>
                     </div>
                  </div>
                  <div class="col">
                     <h4 class="footer_taital">Information</h4>
                     <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority </p>
                  </div>
                  <div class="col">
                     <h4 class="footer_taital">Helpful Links</h4>
                     <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority </p>
                  </div>
                  <div class="col">
                     <h4 class="footer_taital">Invesments</h4>
                     <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority </p>
                  </div>
                  <div class="col">
                     <h4 class="footer_taital">Contact Us</h4>
                     <div class="location_text"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left_15">Location</span></a></div>
                     <div class="location_text"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left_15">(+71) 8522369417</span></a></div>
                     <div class="location_text"><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left_15">demo@gmail.com</span></a></div>
                     <div class="social_icon">
                        <ul>
                           <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free Html Templates</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a></p>
               </div>
            </div>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>