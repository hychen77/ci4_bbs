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
        if(!isset($_SESSION['userid'])){
            echo "<script>alert('로그인하십시오.');location.href='/login'</script>";
            exit;
        }
        return render('board_write');  
    }

    public function save()
    {
        if(!isset($_SESSION['userid'])){
            echo "<script>alert('로그인하십시오.');location.href='/login'</script>";
            exit;
        }
        $db = db_connect();
        $bid=$this->request->getVar('bid');//bid값이 있으면 수정이고 아니면 등록이다.
        $subject=$this->request->getVar('subject');
        $content=$this->request->getVar('content');

        if($bid){
            $query = "select * from board where bid=".$bid;
            $rs = $db->query($query);
            if($_SESSION['userid']==$rs->getRow()->userid){
                $sql="update board set subject='".$subject."', content='".$content."' where bid=".$bid;
                $rs = $db->query($sql);
                return $this->response->redirect(site_url('/boardView/'.$bid));
            }else{
                echo "<script>alert('본인이 작성한 글만 수정할 수 있습니다.');location.href='/login';</script>";
                exit;
            }
        }

        $sql="insert into board (userid,subject,content) values ('".$_SESSION['userid']."','".$subject."','".$content."')";
        $rs = $db->query($sql);
        return $this->response->redirect(site_url('/board'));
    }

    public function view($bid = null)
    {
        $db = db_connect();
        $query = "select * from board where bid=".$bid;
        $rs = $db->query($query);
        $data['view'] = $rs->getRow();

        return render('board_view', $data);  
    }  

    public function modify($bid = null)
    {
        $db = db_connect();
        $query = "select * from board where bid=".$bid;
        $rs = $db->query($query);
        if($_SESSION['userid']==$rs->getRow()->userid){
            $data['view'] = $rs->getRow();
            return render('board_write', $data);  
        }else{
            echo "<script>alert('본인이 작성한 글만 수정할 수 있습니다.');location.href='/login';</script>";
            exit;
        }
       
    }

    public function delete($bid = null)
    {

        $db = db_connect();
        $query = "select * from board where bid=".$bid;
        $rs = $db->query($query);
        if($_SESSION['userid']==$rs->getRow()->userid){
            $query = "delete from board where bid=".$bid;
            $rs = $db->query($query);
            return $this->response->redirect(site_url('/board'));
        }else{
            echo "<script>alert('본인이 작성한 글만 삭제할 수 있습니다.');location.href='/login';</script>";
            exit;
        }
    }    
}