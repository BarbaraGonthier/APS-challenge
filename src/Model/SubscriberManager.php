<?php


namespace App\Model;


class SubscriberManager extends AbstractManager
{
    public const TABLE = 'subscriber';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}