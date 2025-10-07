<?php

namespace App\Controllers;

class Board extends BaseController
{
    public function list()
    {
        return render('board_list');  
        //return view('board_list');
    }

    public function write()
    {
        return render('board_write');  
    }

    public function view()
    {
        return render('board_view');  
    }    
}