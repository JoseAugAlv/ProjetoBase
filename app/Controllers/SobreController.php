<?php
// app/Controllers/SobreController.php

class SobreController extends BaseController
{
    public function index()
    {
        $this->view('sobre/index');
    }
}
