<?php
require 'CypeSimpledbConnect.php';

$cSimpledb = new CypeSimpledbConnect();
echo json_encode($cSimpledb->SQLQueryResultForPlacesDomain());
