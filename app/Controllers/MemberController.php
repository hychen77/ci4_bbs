<?php
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
 
class MemberController extends BaseController
{
    public function login()
    {
        echo render('login');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/board');
    }
 
    public function loginok()
    {
        $db = db_connect();
        $userid = $this->request->getVar('userid');
        $passwd = $this->request->getVar('passwd');
        $passwd = hash('sha512',$passwd);
        $query = "select * from members where userid='".$userid."' and passwd='".$passwd."'";
        //error_log ('['.__FILE__.']['.__FUNCTION__.']['.__LINE__.']['.date("YmdHis").']'.print_r($query,true)."\n", 3, './php_log_'.date("Ymd").'.log');
        $rs = $db->query($query);
        if($rs){
                $ses_data = [
                    'userid' => $rs->getRow()->userid,
                    'username' => $rs->getRow()->username,
                    'email' => $rs->getRow()->email
                ];
                $this->session->set($ses_data);
                return redirect()->to('/board');
        }else{
            return redirect()->to('/login');
        }
    }
}