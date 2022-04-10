<?php
$xpdo_meta_map['idCity']= array (
  'package' => 'idDB',
  'version' => '21.09.14.3',
  'table' => 'city',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'name' => '',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '250',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'idMedobj' => 
    array (
      'class' => 'idMedobj',
      'local' => 'id',
      'foreign' => 'city',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
