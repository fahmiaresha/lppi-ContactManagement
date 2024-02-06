<?php
require_once 'kontak.php';
require_once 'contactManager.php';

// Membuat objek Database
$database = new Database();

// Membuat objek ContactManager dengan menggunakan objek Database
$contactManager = new ContactManager($database);

// Memastikan parameter ID ada dalam URL
if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    // Menghapus kontak
    $contactManager->deleteContact($contactId);
    
    header('Location: index.php'); // Redirect ke halaman utama setelah delete
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>
