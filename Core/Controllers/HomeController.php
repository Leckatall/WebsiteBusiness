<?php

namespace Core\Controllers;

class HomeController extends BaseController
{
    public function index(): void{
        load_view("index.view.php");
    }
}