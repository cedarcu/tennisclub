<?php

$router = $di->getRouter();

// Define your routes here
$router->add(
    '/juniorMembers',
    [
        'controller' => 'member',
        'action'     => 'search',
        3	     => ['membertype' => 'Junior'],
    ]
);

$router->add(
    '/seniorMembers',
    [
        'controller' => 'member',
        'action'     => 'search',
        3	     => ['membertype' => 'Senior'],
    ]
);

$router->handle();
