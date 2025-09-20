<?php
$feedback = '';
$error = '';
$namaPengirim = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    $namaPengirim = htmlspecialchars($nama); // simpan nama untuk ditampilkan

    if (empty($nama) || empty($email) || empty($pesan)) {
        $error = '⚠️ Data tidak lengkap. Harap isi semua kolom.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '📧 Email tidak valid.';
    } else {
        $formatPesan = "Nama: $nama\nEmail: $email\nPesan:\n$pesan\n-------------------------------------------------------------------------------------------------------------------------\n";
        $sukses = file_put_contents('pesan.txt', $formatPesan, FILE_APPEND | LOCK_EX);

        if ($sukses === false) {
            $error = '❌ Gagal menyimpan pesan. Periksa izin file.';
        } else {
            $feedback = "✅ Terima kasih <strong>$namaPengirim</strong>, pesan Anda telah disimpan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hasil Kirim Pesan</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f0f4ff, #e3eafc);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      animation: fadeIn 0.8s ease-in-out;
    }

    .box {
      background: #fff;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 400px;
      width: 90%;
      animation: slideUp 0.6s ease;
    }

    h1 {
      font-size: 1.4rem;
      color: #2b2e4a;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1rem;
      color: #4a4a4a;
    }

    .success {
      color: #2ecc71;
    }

    .error {
      color: #e74c3c;
    }

    strong {
      color: #2b2e4a;
    }

    a {
      display: inline-block;
      margin-top: 1.5rem;
      padding: 10px 20px;
      background: #2b2e4a;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background 0.3s;
    }

    a:hover {
      background: #3e4160;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        background-color: #fff;
      }
      to {
        background-color: #f0f4ff;
      }
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>
      <?php if ($feedback): ?>
        <span class="success"><?= $feedback ?></span>
      <?php elseif ($error): ?>
        <span class="error"><?= htmlspecialchars($error) ?></span>
      <?php endif; ?>
    </h1>
    <a href="index.html#kontak">⬅️ Kembali ke Halaman</a>
  </div>
</body>
</html>
