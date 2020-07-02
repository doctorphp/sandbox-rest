<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/hello-world' => 
      array (
        0 => 'Doctor\\Rest\\Route\\RouterCache',
        1 => 'route1',
      ),
      '/users' => 
      array (
        0 => 'Doctor\\Rest\\Route\\RouterCache',
        1 => 'route1',
      ),
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/user/(\\d+))$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 
            array (
              0 => 'Doctor\\Rest\\Route\\RouterCache',
              1 => 'route1',
            ),
            1 => 
            array (
              'id' => 'id',
            ),
          ),
        ),
      ),
    ),
  ),
);