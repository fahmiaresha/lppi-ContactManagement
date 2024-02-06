<?php
require_once 'kontak.php';
require_once 'contactManager.php';

// Membuat objek Database
$database = new Database();

// Membuat objek ContactManager dengan menggunakan objek Database
$contactManager = new ContactManager($database);

// Memproses form pengiriman data kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];

    // Validasi input
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phoneNumber)) {
        // Menambahkan kontak baru
        $newContact = new Contact(null, $name, $email, $phoneNumber); // id dapat diabaikan karena akan di-generate otomatis
        $contactManager->addContact($newContact);
    } else {
        echo "Invalid input. Please provide valid data.";
    }
}

// Mengambil daftar kontak
$contacts = $contactManager->getContacts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
   <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        form {
            margin-top: 20px;
        }

        .edit-btn,
        .delete-btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Contact Management</h2>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addContactModal">Add Contact</button>
        <!-- Add Contact Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" style="margin-top:-20px">
                            <div class="">
                                <label for="addName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="addName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="addEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="addEmail" name="email" required>
                            </div>
                            <div class="">
                                <label for="addPhone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="addPhone" name="phone" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Contact</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Kontak -->
        <table class="table table-bordered table-striped" id="ContactTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact) : ?>
                    <tr>
                        <td><?php echo $contact->getName(); ?></td>
                        <td><?php echo $contact->getEmail(); ?></td>
                        <td><?php echo $contact->getPhoneNumber(); ?></td>
                        <td>
                           
                            
                            <!-- Tombol untuk membuka modal edit -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editPostModal<?php echo $contact->getId(); ?>">
                                    Edit
                                </button>

                                <!-- Modal untuk Edit Post -->
                                <div class="modal fade" id="editPostModal<?php echo $contact->getId(); ?>" tabindex="-1"
                                    aria-labelledby="editPostModalLabel<?php echo $contact->getId(); ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editPostModalLabel<?php echo $contact->getId(); ?>">Edit Contact
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="edit.php?id=<?php echo $contact->getId(); ?>" method="post" style="margin-top:-20px">
                                                <div class="">
                                                    <label for="addName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="addName" name="name" value="<?php echo $contact->getName(); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="addEmail" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="addEmail" name="email" value="<?php echo $contact->getEmail(); ?>" required>
                                                </div>
                                                <div class="">
                                                    <label for="addPhone" class="form-label">Phone</label>
                                                    <input type="number" class="form-control" id="addPhone" name="phone" value="<?php echo $contact->getPhoneNumber(); ?>" required>
                                                </div>
                                              
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Save Changes</button>
                                                   
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteContactModal<?php echo $contact->getId(); ?>">Delete</button>
                            <!-- Modal Konfirmasi Delete -->
                            <div class="modal fade" id="deleteContactModal<?php echo $contact->getId(); ?>" tabindex="-1" aria-labelledby="deleteContactModalLabel<?php echo $contact->getId(); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteContactModalLabel<?php echo $contact->getId(); ?>">Delete Contact</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <?php echo $contact->getName(); ?>'s contact?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a class="btn btn-danger" href="delete.php?id=<?php echo $contact->getId(); ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $('#ContactTable').DataTable({   

    });

</script>
</body>

</html>