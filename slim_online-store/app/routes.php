<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    //dependency inyector
    $container = $app->getContainer();
    //pr($container,"depinjector");
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("
            <a href=\"/\">/</a><br/>
            <a href=\"/users\">/users</a><br/>
            <a href=\"/users/1\">/users/1</a><br/>
            <a href=\"/users/2\">/users/2</a><br/>
            <a href=\"/users/3\">/users/3</a><br/>
            <a href=\"/users/4\">/users/4</a><br/>
            <a href=\"/users/5\">/users/5</a><br/>
        ");
        return $response;
    });

    $app->group('/users', function (Group $group) use ($container) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
