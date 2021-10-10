<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * User Interface Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class AnalyticsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Reviews');
		$this->loadModel('Comments');
		$this->loadModel('Engagements');
                
			
	}
	
	function beforeRender( Event $event )
	{
		parent::beforeRender( $event );
		$this->viewBuilder()->layout('ui');
	}
		
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	public function index ( ... $args )
	{
		
	}
	public function settings()
	{
	
	}
	
	public function engagements()
	{
		$user = $this->Auth->user();
		
		if ( empty($user) ) {
			$url = $this->request->url;
			$uri = $this->request->getUri();
			$uriParts = explode('?', $uri, 2);
			
			if ( count($uriParts) > 1 ) {
				$qString = array_pop($uriParts);
			}
			
			if (isset($qString)) $url .= '?'.$qString;
			$referer = urlencode($url);
			
			return $this->redirect("/login/?redr=$referer");
		}
		
		$this->viewBuilder()->setLayout('ui');
		
		$requestQuery = $this->request->getQueryParams();
		$expectedQueryFormat = Array ( 'is_frame' => 1, 'auto_refresh_frame' => 1, 'refresh_interval' => 2, 'cache' => 'no' );
		

		
		if ( $requestQuery ) {
			// foreach ( array_keys($query) as $providedKey ) {
				// foreach ( array_keys($expectedQueryFormat) as $definedKey ) {
					// if ( array_search($providedKey, $qyery) !== array_search($definedKey, $expectedQueryFormat) ) {
						
					// }
				// }
			// }
			
			if ( array_diff_key($requestQuery, $expectedQueryFormat) ) {
				$this->Flash->error(__('Sorry, we can\'t seem to understand your request. You must have entered an invalid url'));
				return null;
			}
			
			$this->viewBuilder()->setLayout('blank');
			$this->setPageCssClasses(['bg-w']);
			$this->autoRender = false;
		}
		
		if ( $this->request->is('ajax') ) {
			$this->viewBuilder()->setLayout('ajax');
			$this->autoRender = false;
		}
		
		
		$engagements = [];
		$query = $this->Engagements->Find('list', ['limit' => 20])->where(['Engagements.user_mcd_id =' => $user->mcd_id]);
		$results = $query->all();
		$Engagements = $results->toArray();
		
		// $Engagements = $this->Engagements->getAllBelongingToUser( $user->mcd_id, 'list', ['limit' => 200] );
		
		$UsersController = new UsersController();
		$MediaController = new MediaController();
		
		foreach ($Engagements as $engagement) {
			$media = $MediaController->getMedia($engagement->media_mcd_id);
			$initiator = 'Someone';
			$message = '';
			
			if ( $engagement->initiator ) {
				$user = $UsersController->getUser($engagement->initiator);
				$user = $UsersController->createProfile($user);
				$initiator = $user->fullname;
			}
			
			switch( $engagement->category ) {
				case 'listen': {
					$engagement->message = $initiator . " is listening to your song '". $media->title . "' from " . $engagement->location;
					$engagements[] = $engagement;
				}
				break;
				case 'watch': {
					$engagement->message = $initiator . "' is watching your video '". $media->title ."' from " . $engagement->location;
					$engagements[] = $engagement;
				}
				break;
				case 'download': {
					if ( $media->filetype === 'audio' ) {
							$message = $initiator . " downloaded your song '" . $media->title . "' from " . $engagement->location;
					} elseif ($media->filetype === 'video') {
						$engagement->message = $initiator . " downloaded your video '". $media->title ."' from ". $engagement->location;
						$engagements[] = $engagement;
					}
				}
				break;
				default: {
					
				}
			}
		}
		
		
		$this->set( 'engagements', $engagements );
		$this->set( 'pageTitle', 'Engagements' );
		
	}
	
	public function contentReach()
	{
		$this->autoRender = false;
	}
}
