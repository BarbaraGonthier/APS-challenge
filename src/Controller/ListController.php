<?php


namespace App\Controller;


use App\Model\ListManager;
use App\Model\SubscriberManager;
use App\Model\SubscriptionManager;

class ListController  extends AbstractController
{
    public function mail()
    {
        $listManager = new ListManager();
        $subscribers = $listManager->selectAllJoinSubscriber();

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $subscription = array_map('trim', $_POST);
            $subscriptionManager = new SubscriptionManager();
            $subscriptionManager->saveSubscription($subscription);
            header('Location:/');
        }

        return $this->twig->render('Home/mail.html.twig', [
            'subscribers' => $subscribers,
        ]);
    }

    public function subscribe($id)
    {
        $subscriberManager = new SubscriberManager();
        $subscriber = $subscriberManager->selectOneById($id);

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $subscription = array_map('trim', $_POST);
            $subscriptionManager = new SubscriptionManager();
            $subscriptionManager->saveSubscription($subscription);
            header('Location:/');
        }
        return $this->twig->render('Home/form.html.twig', [
            'subscriber' => $subscriber,
        ]);
    }
}