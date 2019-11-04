<?php
namespace App\Model;

class LoginManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';
    
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    
    /**
     * @param array $userData
     * @return int
     */
    public function insert(array $userData): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`, `password`) VALUES (:name, :password)");
        $statement->bindValue('name', $userData['name'], \PDO::PARAM_STR);
        $statement->bindValue('password', $userData['password'], \PDO::PARAM_STR);
        
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
    
    public function selectOneByName(string $name)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE name=:name");
        $statement->bindValue('name', $name, \PDO::PARAM_STR);
        $statement->execute();
        
        return $statement->fetch();
    }
}
