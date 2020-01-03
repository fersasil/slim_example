<?php
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

$auth = import_controller("auth");


$app->group('/auth', function (Group $group) use ($auth){

  $group->post('/sign-in', $auth->signIn);
  $group->post('/sign-up', $auth->signUp);
});