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

        $file = $this->request->getFile('upfile');//첨부한 파일의 정보를 가져온다.
        if($file->getName()){//파일 정보가 있으면 저장한다.
            $filename = $file->getName();//기존 파일명을 저장할때 필요하다. 여기서는 사용하지 않는다.
            //$filepath = WRITEPATH. 'uploads/' . $file->store(); 매뉴얼에 나와있는 파일 저장 방법이다.여기서는 안쓴다.
            $newName = $file->getRandomName();//서버에 저장할때 파일명을 바꿔준다.
            $filepath = $file->store('board/', $newName);//CI4의 store 함수를 이용해 저장한다.
        }

        $sql="insert into board (userid,subject,content) values ('".$_SESSION['userid']."','".$subject."','".$content."')";
        $rs = $db->query($sql);
        $insertid=$db->insertID();
        if($file->getName()){
            $sql2="INSERT INTO file_table
                    (bid, userid, filename, type)
                    VALUES('".$insertid."', '".$_SESSION['userid']."', '".$filepath."','board')";
            $rs2 = $db->query($sql2);                
        }
        return $this->response->redirect(site_url('/board'));
    }

    public function view($bid = null)
    {
        $db = db_connect();
        $query = "select b.*,f.filename from board b
        left join file_table f on b.bid=f.bid where f.type='board' and b.bid=".$bid;
        $rs = $db->query($query);
        $data['view'] = $rs->getRow();
        //error_log ('['.__FILE__.']['.__FUNCTION__.']['.__LINE__.']['.date("YmdHis").']'.print_r($data,true)."\n", 3, './php_log_'.date("Ymd").'.log');//로그를 남긴다.
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
            $query3 = "select * from file_table where type='board' and bid=".$bid;//파일 테이블에서 파일 경로를 가져온다.
            $rs3 = $db->query($query3);
            if(unlink('uploads/'.$rs3->getRow()->filename)){//삭제한다.
                $query4 = "delete from file_table where type='board' and bid=".$bid;
                $rs4 = $db->query($query4);
                $query2 = "delete from board where bid=".$bid;
                $rs2 = $db->query($query2);
            }
            return $this->response->redirect(site_url('/board'));
        }else{
            echo "<script>alert('본인이 작성한 글만 삭제할 수 있습니다.');location.href='/login';</script>";
            exit;
        }
    }   
}