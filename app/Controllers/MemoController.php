<?php

namespace App\Controllers;
use App\Models\BoardModel;//사용할 모델을 반드시 써줘야한다.

class MemoController extends BaseController
{
    public function memo_write()
    {
        if(!isset($_SESSION['userid'])){
            return "login";
            exit;
        }
       
        $db = db_connect();
        $memo=$this->request->getVar('memo');
        $bid=$this->request->getVar('bid');
        $file_table_id=$this->request->getVar('file_table_id');

        $sql="INSERT INTO memo
            (bid, userid, memo, status)
            VALUES(".$bid.", '".$_SESSION['userid']."', '".$memo."', 1)";
        $rs = $db->query($sql);
        $insertid=$db->insertID();
        //error_log ('['.__FILE__.']['.__FUNCTION__.']['.__LINE__.']['.date("YmdHis").']'.print_r($file_table_id,true)."\n", 3, './php_error_'.date("Ymd").'.log');
        if(!empty($file_table_id)){//첨부한 파일이 있는 경우에만
            $uq="update file_table set bid=".$bid.", memoid=".$insertid." where fid=".$file_table_id;
            $uqs = $db->query($uq);
            $fquery="select * from file_table where status=1 and fid=".$file_table_id;
            $rs2 = $db->query($fquery);
            $imgarea = "<img src='/uploads/".$rs2->getRow()->filename."' style='max-width:90%'>";
        }else{
            $imgarea="";
        }

        $return_data = "<div class=\"card mb-4\" id=\"memo_".$insertid."\" style=\"max-width: 100%;margin-top:20px;\">
                <div class=\"row g-0\">
                    <div class=\"col-md-12\">
                    <div class=\"card-body\">
                    <p class=\"card-text\">".$imgarea."<br>".$memo."</p>
                    <p class=\"card-text\"><small class=\"text-muted\">".$_SESSION['userid']." / now</small></p>
                    <p class=\"card-text\" style=\"text-align:right\"><a href=\"javascript:;\" onclick=\"memo_modify(".$insertid.")\"><button type=\"button\" class=\"btn btn-secondary btn-sm\">수정</button></a>&nbsp;<a href=\"javascript:;\" onclick=\"memo_del(".$insertid.")\"><button type=\"button\" class=\"btn btn-secondary btn-sm\">삭제</button></a></p>
                    </div>
                </div>
                </div>
            </div>";
        return $return_data;
    }

    public function save_image_memo()
    {
        $db = db_connect();

        if(!isset($_SESSION['userid'])){
            $retun_data = array("result"=>"fail", "data"=>"login");
            return json_encode($retun_data);
            exit;
        }
       
        $file = $this->request->getFile('savefile');
            if($file->getName()){
                $filename = $file->getName();
                //$filepath = WRITEPATH. 'uploads/' . $file->store();
                $newName = $file->getRandomName();
                $filepath = $file->store('memo/', $newName);
            }

            if(isset($filepath)){
                $sql2="INSERT INTO file_table
                        (bid, userid, filename, type)
                        VALUES('', '".$_SESSION['userid']."', '".$filepath."', 'memo')";
                $rs2 = $db->query($sql2);
                $insertid=$db->insertID();                
            }

        $retun_data = array("result"=>"success", "fid"=>$insertid, "savename"=>$filepath);
        return json_encode($retun_data);
    }
}