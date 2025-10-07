<?php

namespace App\Controllers;

class Board extends BaseController
{
    public function list()
    {
        return view('board_list');
    }
}
