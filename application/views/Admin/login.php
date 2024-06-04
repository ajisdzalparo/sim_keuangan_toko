<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="<?= base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">
 <!-- fontawesome -->
 <link rel="stylesheet" href="<?= base_url("assets/fontawesome/css/all.min.css") ?>">
 <title>Log-in</title>
</head>

<body>
 <section class="py-3 py-md-5">
  <div class="container">
   <div class="row justify-content-center mb-3">
    <img src="<?= base_url('assets/images/title-side.png'); ?>" alt="" style="width: 179px; height: 153px;" class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
   </div>
   <div class="row justify-content-center">
    <p class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 text-center"><span class="text-primary">Selamat Datang Kembali</span> Kami merindukan Anda!</p>
   </div>
   <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
     <?php if ($this->session->flashdata('error')) : ?>
      <div class="alert alert-danger" role="alert">
       <?= $this->session->flashdata('error'); ?>
      </div>
     <?php endif; ?>
     <div class="card border-1 border-primary rounded-3 shadow-sm">
      <div class="card-body p-3 p-md-4 p-xl-5">
       <form action="<?= site_url('admin/login') ?>" method="post">
        <div class="row gy-2 overflow-hidden">
         <div class="col-12 mt-5">
          <label for="email" class="form-label">Email</label>
          <div class="mb-2 d-flex align-items-center">
           <input type="email" class="form-control py-2 border-1 border-primary" name="email" id="email" placeholder="Masukkan email Anda" required>
          </div>
         </div>
         <div class="col-12">
          <label for="password" class="form-label">Password</label>
          <div class="mb-2 d-flex align-items-center">
           <input type="password" class="form-control py-2 border-1 border-primary" name="password" id="password" value="" placeholder="Masukkan password" required>
          </div>
         </div>
         <div class="col-12">
          <div class="d-grid my-3">
           <button class="btn btn-primary btn-lg" type="submit" id="loginButton">
            <span id="buttonText">Masuk</span>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="spinner" style="display: none;"></span>
           </button>
          </div>
         </div>
         <div class="col-12 d-flex justify-content-between">
          <?php echo anchor('owner/login', 'Login Sebagai Owner', 'class="m-0 text-secondary text-decoration-none"'); ?>
         </div>
        </div>
       </form>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>

 <script>
  document.getElementById('loginButton').addEventListener('click', function(event) {
   event.preventDefault(); // Mencegah form dari submit otomatis
   var button = this;
   var text = document.getElementById('buttonText');
   var spinner = document.getElementById('spinner');
   var form = button.closest('form');

   text.textContent = 'Loading...'; // Mengubah teks tombol
   spinner.style.display = 'inline-block'; // Menampilkan spinner

   setTimeout(function() {
    form.submit(); // Submit form setelah delay
   }, 3000); // Delay 3000 ms atau 3 detik
  });
 </script>
</body>

</html>