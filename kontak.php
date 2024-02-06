<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "contacts";
    public $conn;

    // Fungsi untuk membuat koneksi
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Cek koneksi
        if ($this->conn->connect_error) {
            die("Koneksi Gagal: " . $this->conn->connect_error);
        }
    }

    // Fungsi untuk menutup koneksi
    public function closeConnection()
    {
        $this->conn->close();
    }
}

class Contact
{
    private $id;
    private $name;
    private $email;
    private $phoneNumber;

    public function __construct($id, $name, $email, $phoneNumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    // Getter methods
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}

?>
