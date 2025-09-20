<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan Masuk</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      padding: 20px;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    #pesan-box {
      margin-top: 20px;
      white-space: pre-wrap;
      background: #f0f0f0;
      padding: 15px;
      border-radius: 8px;
      height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Daftar Pesan Masuk</h2>
  <div id="pesan-box">Memuat pesan...</div>
</div>

<script>
  function loadPesan() {
    fetch('data-pesan.php')
      .then(res => res.text())
      .then(data => {
        document.getElementById('pesan-box').innerHTML = data;
      });
  }

  // Muat pesan saat pertama kali dibuka
  loadPesan();

  // Perbarui setiap 5 detik
  setInterval(loadPesan, 5000);
</script>

</body>
</html>
