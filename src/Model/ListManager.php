<?php


namespace App\Model;


class ListManager extends AbstractManager
{
    public const TABLE = 'list';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function saveList(int $subscriber_id)
    {
        $query = "INSERT INTO " . self::TABLE .
            " (`subscriber_id`) 
            VALUES 
            (:subscriber_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':subscriber_id', $subscriber_id, \PDO::PARAM_INT);
        $statement->execute();
    }
    public function selectAllJoinSubscriber(): array
    {
        return $this->pdo->query("SELECT subscriber.id, subscriber.name FROM " . self::TABLE . " l JOIN subscriber AS subscriber ON subscriber.id=l.subscriber_id;")->fetchAll();
    }
}