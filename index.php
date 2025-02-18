<?php

require "functions.php";

require "router.php";

$config = require "config.php";

// connect to SQL DB
require "Database.php";
$db = new Database($config['database']);

