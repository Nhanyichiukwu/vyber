<?php
declare(strict_types=1);

namespace App\Routing\Route;


use Cake\Routing\Route\Route;

class UsernameRoute extends Route
{
    public function parse(string $url, string $method): ?array
    {
        return parent::parse($url, $method);
    }


    public function match(array $url, array $context = []): ?string
    {
        $match = parent::match($url, $context);

        debug($match);
        exit;
        return $match;
    }
}
