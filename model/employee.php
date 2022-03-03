<?php
class Employee
{
    private $table = "employees";
    private $Connection;
    private $id;
    private $Name;
    private $Surname;
    private $email;
    private $phone;
    public function __construct($Connection) { $this->Connection = $Connection; }
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getName() { return $this->Name; }
    public function setName($Name) { $this->Name = $Name; }
    public function getSurname() { return $this->Surname; }
    public function setSurname($Surname) { $this->Surname = $Surname; }
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }
    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function save() {
        $consultation = $this->Connection->prepare("INSERT INTO " . $this->table . " (Name,Surname,email,phone) VALUES (:Name,:Surname,:email,:phone)");
        $result = $consultation->execute(array(
            "Name" => $this->Name,
            "Surname" => $this->Surname,
            "email" => $this->email,
            "phone" => $this->phone
        ));
        $this->Connection = null;
        return $result;
    }
    public function update() {
        $consultation = $this->Connection->prepare("UPDATE " . $this->table . " SET Name = :Name, Surname = :Surname, email = :email, phone = :phone WHERE id = :id");
        $resultado = $consultation->execute(array(
            "id" => $this->id,
            "Name" => $this->Name,
            "Surname" => $this->Surname,
            "email" => $this->email,
            "phone" => $this->phone
        ));
        $this->Connection = null;
        return $resultado;
    }
    public function getAll() {
        $consultation = $this->Connection->prepare("SELECT id,Name,Surname,email,phone FROM " . $this->table);
        $consultation->execute();
        /* Fetch all of the remaining rows in the result set */
        $resultados = $consultation->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $resultados;
    }
    public function getById($id) {
        $consultation = $this->Connection->prepare("SELECT id,Name,Surname,email,phone FROM " . $this->table . "  WHERE id = :id");
        $consultation->execute(array(
            "id" => $id
        ));
        /*Fetch all of the remaining rows in the result set*/
        $resultado = $consultation->fetchObject();
        $this->Connection = null; //connection closure
        return $resultado;
    }
    public function getBy($column, $value) {
        $consultation = $this->Connection->prepare("SELECT id,Name,Surname,email,phone FROM " . $this->table . " WHERE :column = :value");
        $consultation->execute(array(
            "column" => $column,
            "value" => $value
        ));
        $resultados = $consultation->fetchAll();
        $this->Connection = null; //connection closure
        return $resultados;
    }
    public function deleteById($id) {
        try {
            $consultation = $this->Connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
            $consultation->execute(array(
                "id" => $id
            ));
            $Connection = null;
        } catch (Exception $e) {
            echo 'Failed DELETE (deleteById): ' . $e->getMessage();
            return -1;
        }
    }
    public function deleteBy($column, $value) {
        try {
            $consultation = $this->Connection->prepare("DELETE FROM " . $this->table . " WHERE :column = :value");
            $consultation->execute(array(
                "column" => $value,
                "value" => $value,
            ));
            $Connection = null;
        } catch (Exception $e) {
            echo 'Failed DELETE (deleteBy): ' . $e->getMessage();
            return -1;
        }
    }
}
