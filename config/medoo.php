<?php

return [
  'database_type' => 'mysql',
  'database_name' => 'mb',
  'server' => 'localhost',
  'username' => 'root',
  'password' => '111111',
  'port' => 3306,
  'charset' => 'utf8',
  'option' => [
      \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
      \PDO::ATTR_EMULATE_PREPARES => false,
  ],
];
