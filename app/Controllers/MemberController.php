<?php
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
 
class MemberController extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function loginjoin()
    {
        return view('login_join');
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
 
    public function loginok()
    {
        $db = db_connect();//디비연결
        $userid = $this->request->getVar('userid');//변수
        $passwd = $this->request->getVar('passwd');//변수
        $passwd = hash('sha512',$passwd);//암호화
        $query = "select * from members where userid='".$userid."' and passwd='".$passwd."'";
        error_log ('['.__FILE__.']['.__FUNCTION__.']['.__LINE__.']['.date("YmdHis").']'.print_r($query,true)."\n", 3, './php_log_'.date("Ymd").'.log');//로그를 남긴다.
        $rs = $db->query($query);
        if($rs){//사용자가 맞으면
                $ses_data = [
                    'userid' => $rs->getRow()->userid,
                    'username' => $rs->getRow()->username,
                    'email' => $rs->getRow()->email
                ];
                $this->session->set($ses_data);//해당 사용자의 데이타를 배열에 담아서 세션에 저장한다.
                return redirect()->to('/board');//이동한다.
        }else{
            return redirect()->to('/login');
        }
    }

    public function loginjoinok()
    {
        $db = db_connect();//디비연결
        $userid = $this->request->getVar('userid');//변수
        $username = $this->request->getVar('username');//변수        
        $passwd = $this->request->getVar('passwd');//변수
        $email = $this->request->getVar('email');//변수
        $passwd = hash('sha512',$passwd);//암호화
        
        
        
        
        $query = "select * from members where userid='".$userid."'";
        error_log ('['.__FILE__.']['.__FUNCTION__.']['.__LINE__.']['.date("YmdHis").']'.print_r($query,true)."\n", 3, './php_log_'.date("Ymd").'.log');//로그를 남긴다.
        $rs = $db->query($query);
        $result = $rs->getResult();
        $total = count($result);//전체 게시물수


        if($total > 0){//userid 있다면 
            echo "<script>alert('사용할 수 없는 ID 입니다.');location.href='/login_join'</script>";
            //return redirect()->to('/login_join');
        }
        else{


        $sql="insert into members (userid,username,passwd,email) values ('".$userid."','".$username."','".$passwd."','".$email."')";
        $rs = $db->query($sql);
        echo "<script>alert('회원가입 되었습니다.');location.href='/login'</script>";
        }

    }

}