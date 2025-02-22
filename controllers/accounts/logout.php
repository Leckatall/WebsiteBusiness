<?php

use Core\Database\AccountManager;

AccountManager::logout();
redirect("/");
