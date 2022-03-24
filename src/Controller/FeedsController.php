<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Feeds Controller
 *
 * @method \App\Model\Entity\Feed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
//        if ($this->AuthServiceProvider->isAuthenticated()) {
//            $this->viewBuilder()->setTemplate('dashboard');
//        }
//        $unreadNotifications = $this->Notifications->find('unread', ['user_refid' => $this->getActiveUser()->refid]);
//        $unreadMessages = $this->Messages->findUnread('unread', ['recipient' => $this->getActiveUser()->refid]);
//        $invites = $this->EventGuests->find('recent', ['guest' => $this->getActiveUser()->refid]);
//        $userActivities = $this->UserActivities->getActivities($this->getActiveUser()->refid);
//        $suggestedConnections = (array) $this->Suggestion->suggestPossibleConnections();
//        $familiarUsers = (array) $this->Suggestion->suggestPossibleAcquaintances($this->getActiveUser());
//        $pendingRequests = $this->Requests->find('pending', ['actor' => $this->getActiveUser()->refid])
//        ->toArray();
//        $trendingSongs = $trendingVideos = $trendingMovies = array();

//        $this->set(compact(
//            'unreadNotifications',
//            'pendingRequests',
////                'unreadMessages',
//            'familiarUsers',
//            'suggestedConnections',
//            'userActivities',
//            'trendingMovies',
//            'trendingVideos',
//            'trendingSongs'
//        ));
    }
}
