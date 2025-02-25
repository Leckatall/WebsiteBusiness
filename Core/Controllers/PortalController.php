<?php

namespace Core\Controllers;

use Core\Session;

class PortalController extends BaseController
{
    public function index(): void
    {
        switch (Session::getRole()) {
            case 0:
                $this->abort(401);
                break;
            case 1:
                load_view("portals/student-portal.view.php", ['heading' => "Student Portal"]);
                break;
            case 2:
                load_view("portals/tutor-portal.view.php", ['heading' => "Tutor Portal"]);
                break;
            case 3:
                load_view("portals/admin-portal.view.php", ['heading' => "Admin Portal"]);
                break;
        }
    }
}