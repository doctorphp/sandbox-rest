<?php return array (
  'route1' => 
  array (
    0 => 'GET',
    1 => '/hello-world',
    2 => 'App\\Controller\\HelloWorldController',
  ),
  'route2' => 
  array (
    0 => 'GET',
    1 => '/users',
    2 => 'App\\Controller\\UsersController',
  ),
  'route3' => 
  array (
    0 => 'GET',
    1 => '/user/{id:\\d+}',
    2 => 'App\\Controller\\UserController',
  ),
);