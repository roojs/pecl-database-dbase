--TEST--
dbase_get_record(): error conditions
--SKIPIF--
<?php
if (!extension_loaded('dbase')) die('skip dbase extension not available');
if (PHP_INT_SIZE != 8) die('skip for 64bit platforms only');
?>
--FILE--
<?php
var_dump(dbase_get_record());
var_dump(dbase_get_record(fopen('php://input', 'r'), 1));

$filename = __DIR__ . DIRECTORY_SEPARATOR . 'dbase_get_record_error.dbf';
$db = dbase_create($filename, [['foo', 'C', 15]]);
var_dump(dbase_get_record($db, -1));
var_dump(dbase_get_record($db, 1));
var_dump(dbase_get_record($db, 2147483648));
?>
===DONE===
--EXPECTF--
Warning: dbase_get_record() expects exactly 2 parameters, 0 given in %s on line %d
NULL

Warning: dbase_get_record(): supplied resource is not a valid dbase resource in %s on line %d
bool(false)

Warning: dbase_get_record(): record number has to be in range 1..2147483647, but is -1 in %s on line %d
bool(false)

Warning: dbase_get_record(): Tried to read bad record 1 in %s on line %d
bool(false)

Warning: dbase_get_record(): record number has to be in range 1..2147483647, but is 2147483648 in %s on line %d
bool(false)
===DONE===
--CLEAN--
<?php
unlink(__DIR__ . DIRECTORY_SEPARATOR . 'dbase_get_record_error.dbf');
?>
