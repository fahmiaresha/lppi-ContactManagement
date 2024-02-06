<?php

class ContactManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function addContact(Contact $contact)
    {
        $name = $contact->getName();
        $email = $contact->getEmail();
        $phoneNumber = $contact->getPhoneNumber();

        $query = "INSERT INTO contacts (name, email, phone) VALUES ('$name', '$email', '$phoneNumber')";
        $result = $this->database->conn->query($query);

        if (!$result) {
            echo "Error: " . $this->database->conn->error;
        }
    }

    public function updateContact(Contact $contact)
    {
        $contactId = $contact->getId();
        $name = $contact->getName();
        $email = $contact->getEmail();
        $phoneNumber = $contact->getPhoneNumber();

        $query = "UPDATE contacts SET name='$name', email='$email', phone='$phoneNumber' WHERE id=$contactId";
        $this->database->conn->query($query);
    }

    public function deleteContact($contactId)
    {
        $query = "DELETE FROM contacts WHERE id=$contactId";
        $this->database->conn->query($query);
    }

    public function getContactById($contactId)
    {
        $query = "SELECT * FROM contacts WHERE id=$contactId";
        $result = $this->database->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Contact($row['id'], $row['name'], $row['email'], $row['phone']);
        }

        return null;
    }


    public function getContacts()
    {
        $contacts = array();

        $query = "SELECT * FROM contacts";
        $result = $this->database->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $phoneNumber = $row['phone'];
                $contact = new Contact($id, $name, $email, $phoneNumber);
                $contacts[] = $contact;
            }
        }

        return $contacts;
    }
}

?>
