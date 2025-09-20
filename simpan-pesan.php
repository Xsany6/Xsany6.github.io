<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesan Terkirim</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    /* Mengatur font Inter sebagai default */
    body {
      font-family: 'Inter', sans-serif;
      /* Mengubah latar belakang menjadi warna abu-abu seperti awan mendung */
      background: #6C7A89; /* Warna abu-abu kebiruan untuk efek mendung */
      overflow: hidden; /* Mencegah scroll karena elemen hujan */
    }

    /* Animasi masuk untuk popup */
    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }
    .popup-animation {
      animation: fadeInScale 0.5s ease-out forwards;
    }

    /* Gaya dasar untuk tetesan hujan */
    .rain {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none; /* Memastikan hujan tidak menghalangi interaksi */
      z-index: 0; /* Pastikan hujan berada di belakang popup */
      opacity: 0.8; /* Sedikit transparan agar tidak terlalu mendominasi */
    }

    .drop {
      position: absolute;
      background-color: rgba(255, 255, 255, 0.4); /* Warna tetesan hujan */
      width: 2px;
      height: 15px;
      border-radius: 50%;
      animation: fall linear infinite;
    }

    /* Variasi animasi jatuh untuk tetesan hujan */
    @keyframes fall {
      to {
        transform: translateY(100vh); /* Jatuh ke bawah layar */
      }
    }

    /* Membuat beberapa lapisan hujan dengan kecepatan dan ukuran berbeda */
    .drop:nth-child(even) {
      animation-duration: 0.8s;
      animation-delay: -0.2s;
      width: 1px;
      height: 10px;
      opacity: 0.6;
    }

    .drop:nth-child(3n) {
      animation-duration: 1.2s;
      animation-delay: -0.5s;
      width: 3px;
      height: 20px;
      opacity: 0.7;
    }

    .drop:nth-child(5n) {
      animation-duration: 1s;
      animation-delay: -0.8s;
      width: 2.5px;
      height: 18px;
      opacity: 0.5;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
  <!-- PHP logic to handle form submission and display data -->
  <?php
  // Konfigurasi koneksi database
  $host = 'localhost';
  $user = 'rizkyan';
  $pass = 'rizkyan';
  $db   = 'kontak_db';

  $conn = new mysqli($host, $user, $pass, $db);

  if ($conn->connect_error) {
      // Menampilkan pesan kesalahan yang lebih user-friendly
      die("<div class='text-center text-red-500 text-lg'>Koneksi database gagal: " . htmlspecialchars($conn->connect_error) . "</div>");
  }

  function clean_input($data) {
      return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
  }

  $nama  = clean_input($_POST['nama'] ?? '');
  $email = clean_input($_POST['email'] ?? '');
  $pesan = clean_input($_POST['pesan'] ?? '');

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      die("<div class='text-center text-red-500 text-lg'>Email tidak valid. Silakan kembali dan coba lagi.</div>");
  }

  $sql = "INSERT INTO pesan (nama, email, pesan) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
      die("<div class='text-center text-red-500 text-lg'>Kesalahan query: " . htmlspecialchars($conn->error) . "</div>");
  }

  $stmt->bind_param("sss", $nama, $email, $pesan);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  ?>

  <!-- Container untuk animasi hujan -->
  <div class="rain"></div>

  <!-- Popup utama -->
  <div class="popup-animation bg-white p-8 md:p-12 rounded-xl shadow-2xl text-center max-w-lg w-full transform transition-all duration-300 ease-in-out hover:shadow-3xl z-10 relative">
    <div class="flex items-center justify-center mb-6 text-green-500">
      <!-- Icon SVG untuk sukses -->
      <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Terima kasih!</h3>
    <p class="text-lg md:text-xl text-gray-600 leading-relaxed mb-6">
      Halo <strong class="text-indigo-600"><?php echo $nama; ?></strong>, pesanmu sudah berhasil dikirim! Kami akan segera menghubungimu. 😊
    </p>
    <a href="index.html" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-105">
      Kembali ke Beranda
    </a>
  </div>

  <script>
    // JavaScript untuk membuat tetesan hujan secara dinamis
    const rainContainer = document.querySelector('.rain');
    const numberOfDrops = 100; // Jumlah tetesan hujan

    for (let i = 0; i < numberOfDrops; i++) {
      const drop = document.createElement('div');
      drop.classList.add('drop');
      // Posisi horizontal acak untuk tetesan hujan
      drop.style.left = `${Math.random() * 100}vw`;
      // Durasi animasi acak untuk variasi
      drop.style.animationDuration = `${0.5 + Math.random() * 1.5}s`;
      // Penundaan animasi acak untuk penampilan acak
      drop.style.animationDelay = `${-Math.random() * 2}s`;
      // Tinggi awal acak
      drop.style.top = `${Math.random() * 100}vh`;
      rainContainer.appendChild(drop);
    }
  </script>
</body>
</html>
