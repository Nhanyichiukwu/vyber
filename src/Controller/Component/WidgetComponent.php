<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Utility\CustomString;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Exception\MissingActionException;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Session;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;
use function mysql_xdevapi\getSession;

/**
 * Widget component
 *
 */
class WidgetComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param array $params
     * @param array $path
     * @return mixed
     * @throws BadRequestException
     * @throws MissingActionException
     */
    public function handle(array $params = [], array $path = [])
    {
        $session = $this->getController()->getRequest()->getSession();
        $accessKey = $params['_accessKey'] ?? null;

//        $storedAccessKey = $session->read('cw_sidebar_widget_accesskey');
//        if (!is_null($storedAccessKey)
//            && (is_null($accessKey) || $accessKey !== $storedAccessKey)
//        ) {
//            throw new NotFoundException('Oops! Looks like you took' .
//                ' a wrong turn here, or the link may be broken or have expired.'
//            );
//        }

        if (count($path) < 0) {
            throw new BadRequestException(
                "No sub-handler defined for `WidgetComponent` handle."
            );
        }
        $key = array_keys($path)[0];
        $subHandler = Inflector::camelize($path[$key]);
        $subHandler = lcfirst($subHandler);
        array_shift($path);
        return $this->{$subHandler}($params, $path);
    }

    public function notifications(array $params) {
        $cat = $params['cat'] ?? 'allForUser';
        $cat = CustomString::sanitize($cat);
        $limit = (int) $params['limit'] ?? 24;
        $user = $this->getConfig('user');

        $Notifications = (new TableLocator)->get('Notifications');
        $notifications = $Notifications->find($cat, ['user' => $user->refid])
            ->contain([
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ])
            ->orderDesc('Notifications.created')
            ->limit($limit)
            ->toArray();

        return $notifications;
    }

    public function events(array $params)
    {
        $cat = $params['cat'] ?? 'allForUser';
        $cat = CustomString::sanitize($cat);
        $limit = (int) $params['limit'] ?? 24;
        $user = $this->getConfig('user');

        $EventsTbl = (new TableLocator)->get('Events');
        $events = $EventsTbl->find($cat, ['user' => $user->refid])
            ->orderDesc('Venues.start_date')
            ->limit($limit)
            ->toArray();

        return $events;
    }
}
