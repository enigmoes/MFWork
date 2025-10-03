<?php
declare (strict_types = 1);

class Users extends Model
{
    // Strings
    public String $email;
    public String $name;
    public String $lastname;
    // Char
    public String $role;
    // Especials
    public String $password;

    public function __construct()
    {
        // Set table
        $this->setTable('users');
        // Set primary key
        $this->setPrimarykey('id');
        // Init default fields
        $this->_initDefaultFields();

        parent::__construct();
    }

    private function _initDefaultFields()
    {
        $this->email = '';
        $this->name = '';
        $this->lastname = '';

        $this->role = 'c';
    }

    protected function _setPassword($password)
    {
        $passwordHasher = new PasswordHasher;
        return $passwordHasher->hash($password);
    }
}
