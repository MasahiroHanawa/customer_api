<?php
namespace config;

return [
  'doctrine' => [
    'driver' => [
      // defines an annotation driver with two paths, and names it `my_annotation_driver`
      'my_annotation_driver' => [
        'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
        'cache' => 'array',
        'paths' => [
          'path/to/my/entities',
          'another/path',
        ],
      ],

      // default metadata driver, aggregates all other drivers into a single one.
      // Override `orm_default` only if you know what you're doing
      'orm_default' => [
        'drivers' => [
          // register `my_annotation_driver` for any entity under namespace `My\Namespace`
          'My\Namespace' => 'my_annotation_driver',
        ],
      ],
    ],
    'connection' => [
      // default connection name
      'orm_default' => [
        'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
        'params' => [
          'host'     => 'localhost',
          'port'     => '3306',
          'user'     => 'username',
          'password' => 'password',
          'dbname'   => 'database',
        ],
      ],
    ],
  ],
];