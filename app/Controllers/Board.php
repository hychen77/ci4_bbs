<?php

namespace App\Controllers;

class Board extends BaseController
{
    public function list()
    {
        $db = db_connect();
        $query = "select * from board order by bid desc";
        $rs = $db->query($query);
        $data['list'] = $rs->getResult();//결과값 저장
        return render('board_list', $data);//view에 리턴        
        //return render('board_list');  
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