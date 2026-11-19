<?php
// app/Controllers/TutorialController.php

class TutorialController extends BaseController
{
    public function index()
    {
        $this->view('tutorial/index');
    }
}
