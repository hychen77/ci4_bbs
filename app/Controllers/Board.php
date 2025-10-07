<?php

namespace App\Controllers;

use App\Models\BoardModel;//사용할 모델을 반드시 써줘야한다.

class Board extends BaseController
{
    public function list()
    {
        $db = db_connect();
        $query = "select * from board order by bid desc";
        $rs = $db->query($query);
        $data['list'] = $rs->getResult();//결과값 저장
        // $boardModel = new BoardModel();
        // $data['list'] = $boardModel->orderBy('bid', 'DESC')->findAll();

        return render('board_list', $data);//view에 리턴        
        //return render('board_list');  
        //return view('board_list');
    }

    public function write()
    {
        return render('board_write');  
    }

    public function view($bid = null)
    {
        $db = db_connect();
        $query = "select * from board where bid=".$bid;
        $rs = $db->query($query);
        $data['view'] = $rs->getRow();

        return render('board_view', $data);  
    }  
}