<?php
$filename = 'pesan.txt';

if (file_exists($filename)) {
    echo nl2br(file_get_contents($filename));
} else {
    echo 'Belum ada pesan yang dikirim.';
}
?>
