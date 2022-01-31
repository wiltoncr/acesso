<?php

namespace App;

use Src\Database\Connect;

class People extends \Src\Database\Connect
{
    protected $name;
    protected $name_fantasy;
    protected $type_people; /**TRUE é fisica e False é juridica */
    protected $email;
    protected $cpf;
    protected $cnpj;
    protected $active;

    public function __construct(
        string $name,
        string $name_fantasy,
        bool $type_people,
        string $email,
        string $cpf = "",
        string $cnpj = "",
        bool $active = true
    ) {
        $this->name = $name;
        $this->name_fantasy = $name_fantasy;
        $this->type_people = $type_people;
        $this->email = $email;
        
        if ($type_people) {
            $this->cpf = $cpf;
        } else {
            $this->cnpj = $cnpj;
        }
        
        $this->active = $active;
    }

    public function listPeople() {
       $result =  Connect::selectDB("SELECT * FROM pessoa");
       return $result;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    private function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name_fantasy
     */ 
    public function getName_fantasy()
    {
        return $this->name_fantasy;
    }

    /**
     * Set the value of name_fantasy
     *
     * @return  self
     */ 
    private function setName_fantasy($name_fantasy)
    {
        $this->name_fantasy = $name_fantasy;

        return $this;
    }

    /**
     * Get the value of type_people
     */ 
    public function getType_people()
    {
        return $this->type_people;
    }

    /**
     * Set the value of type_people
     *
     * @return  self
     */ 
    private function setType_people($type_people)
    {
        $this->type_people = $type_people;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    private function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    private function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of cnpj
     */ 
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set the value of cnpj
     *
     * @return  self
     */ 
    private function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    private function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
