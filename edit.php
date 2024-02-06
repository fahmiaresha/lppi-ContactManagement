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

    // Memproses form pengiriman data kontak
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phone'];

        // Validasi input
        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phoneNumber)) {
            // Mengupdate kontak
            $updatedContact = new Contact($contactId, $name, $email, $phoneNumber);
            $contactManager->updateContact($updatedContact);
            header('Location: index.php'); // Redirect ke halaman utama setelah update
            exit();
        } else {
            echo "Invalid input. Please provide valid data.";
        }
    }

} else {
    echo "Invalid request.";
    exit();
}
?>

<!--  -->