<?php


namespace App\Model;


class SubscriptionManager extends AbstractManager
{
    public const TABLE = 'subscription';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllJoinSeasonTwo(): array
    {
        return $this->pdo->query("SELECT subscriber.id, subscriber.name, s.season_id FROM " . self::TABLE . " s JOIN subscriber ON subscriber.id=s.subscriber_id WHERE s.season_id = 2;")->fetchAll();
    }

    public function saveSubscription(array $subscription)
    {
        $query = "INSERT INTO " . self::TABLE .
            " (`season_id`,`subscriber_id`) 
            VALUES 
            (:season_id, :subscriber_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':season_id', $subscription['season_id'], \PDO::PARAM_INT);
        $statement->bindValue(':subscriber_id', $subscription['subscriber_id'], \PDO::PARAM_INT);

        $statement->execute();
    }
}