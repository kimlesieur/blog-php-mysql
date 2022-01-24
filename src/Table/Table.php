<?php
namespace App\Table;
use App\Table\Exception\NotFoundException;
use \PDO;


class Table {

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(\PDO $pdo)
    {
        if($this->table === null){
            throw new \Exception("La class " . get_class($this) . " n'a pas de propriété \$table");
        }
        if($this->class === null){
            throw new \Exception("La class " . get_class($this) . " n'a pas de propriété \$class");
        }
        $this->pdo = $pdo;
    }

    /**
     * @param string $field Champ à rechercher
     * @param mixed $value Valeur associée au champ 
     * 
     * @return bool Vérifie si valeur existe dans la table donnée
     */
    public function exists(string $field, $value, ?int $exceptId = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        //On rajoute un paramètre à la requête SQL pour indiquer que l'id doit être différent de $except s'il est défini
        if($exceptId !== null){
            $sql .= " AND id != $exceptId";
        }
        $params = [$value];
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        //dd($query);
        //Nous renvoie le nb d'éléments qui match au niveau de la DB
        $result = $query->fetch(PDO::FETCH_NUM)[0];
        return $result > 0;
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM ". $this->table  ." WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query -> fetch();
        if ($result === false){
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }





}