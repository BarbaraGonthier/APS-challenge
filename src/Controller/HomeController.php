<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ListManager;
use App\Model\SubscriberManager;
use App\Model\SubscriptionManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $subscriberManager = new SubscriberManager();
        $subscribers = $subscriberManager->selectAll();

        $subscriptionManager = new SubscriptionManager();
        $thisYearSubscribers = $subscriptionManager->selectAllJoinSeasonTwo();
        $thisYearSubscribersId = [];
        $notSubscribedYet = [];
        $mailtoIds = [];

        foreach ($thisYearSubscribers as $thisYearSubscriber) {
            $thisYearSubscribersId[] = $thisYearSubscriber['id'];
        }
        foreach ($subscribers as $subscriber) {
                if (!in_array($subscriber['id'], $thisYearSubscribersId)) {
                    $notSubscribedYet[] = $subscriber;
                }
        }

        foreach ($notSubscribedYet as $mailto) {
            $mailtoIds[] = $mailto['id'];
        }

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            foreach ($mailtoIds as $subscriber_id){
                $listManager = new ListManager();
                $listManager->saveList($subscriber_id);
            }
                header('Location:/list/mail/');
        }

        return $this->twig->render('Home/index.html.twig', [
            'subscribers' => $subscribers,
            'thisYearSubscribers' => $thisYearSubscribers,
            'notSubscribedYet' => $notSubscribedYet,
        ]);

    }
}
