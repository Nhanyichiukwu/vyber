<?php

namespace App\Utility;

class AjaxMaskedRoutes
{

    const ROUTES = [
        'k3ZtKE2hKb4rSgSW2yhJzFZCCRpIfHsZ' => 'Suggestion',
        'ww8hutqCPrLZJFoEpXBr2J39t8kxNQKn' => 'Newsfeed',
        'fKQbiDgglUZhbhg9VCxcaQWCMiDsHnO8' => 'Profile',
    ];

    /**
     * @param string $routeMask
     * @return string The matched route if $routeMask key exists, or the $routeMask otherwise
     */
    public static function getRoute(string $routeMask)
    {
        return self::ROUTES[$routeMask] ?? $routeMask;
    }

    /**
     * @param string $route
     * @return int|string The matched mask if exists, or the $route otherwise.
     */
    public static function getRouteMaskFor(string $route)
    {
        $flip = array_flip(self::ROUTES);
        return $flip[ucfirst($route)] ?? $route;
    }
}
