<?php

namespace Core\Controllers;
class BaseController
{
    public function index()
    {

    }
    public function show(int $id)
    {

    }
    public function create()
    {

    }
    public function store()
    {

    }
    public function edit(int $id)
    {

    }
    public function update(int $id)
    {

    }
    public function destroy(int $id)
    {

    }
    public function abort(int $status_code=404){
        http_response_code($status_code);
        require base_path("views/{$status_code}.php");
        return false;

    }
}