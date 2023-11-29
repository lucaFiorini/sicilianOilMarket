 <?php

 enum LoginErros{

 }
class Profile{
    private int $ID;
    private string $name;
    private string $surname;
    private string $email;

    public function __construct(int $ID, string $name, string $surname, string $email){
        $this->ID = $ID;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
    }
    public static function getFromDB(int $ID) : Profile | false{ 
        return false; 
    }
    public function getID(): int{return $this->ID;}
    public function getName(): string{return $this->name;}
    public function getSurname(): string{return $this->surname;}
    public function getEmail(): string{return $this->email;}

}

class Customer extends Profile{
    
    public function __construct(Profile $p){
    }

}

/*todo
class ProducerInterface extends Producer{
    Profile p;

}
/*
?>