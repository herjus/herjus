<?php 
include 'dbh.class.php';

function fixString($string){
        return $result = ucwords(mb_strtolower($string));
    }
    
class User extends Dbh
{
	public $user_id;
	public $user_first;
	public $user_last;
	public $user_email;
	public $user_gender;
	public $user_uid;
	public $user_wl;
	public $wl_public;
	public $date;

	public function setId($user_id)
	{
		$this->user_id = $user_id;
	}
	public function setFirst($user_first)
	{
		$this->user_first = $user_first;
	}
	public function setLast($user_last)
	{
		$this->user_last = $user_last;
	}
	public function setEmail($user_email)
	{
		$this->user_email = $user_email;
	}
	public function setGender($user_gender)
	{
		$this->user_gender = $user_gender;
	}
	public function setUid($user_uid)
	{
		$this->user_uid = $user_uid;
	}
	public function setWl($user_wl)
	{
		$this->user_wl = $user_wl;
	}
	public function setWlPublic($wl_public)
	{
		$this->wl_public = $wl_public;
	}
	public function setDate($date)
	{
		$this->date = $date;
	}

	public function login($name, $user_pwd)
	{
		$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$name, $name]);

		if($stmt-> rowCount())
		{
			while($row = $stmt->fetch())
			{
				$pwdTest = password_verify($user_pwd, $row['user_pwd']);
				if($pwdTest === false) $login = "pwfalse";
				elseif($pwdTest == true)
				{
					$_SESSION['u_id'] = $row['user_id'];
					$_SESSION['u_first'] = $row['user_first'];
					$_SESSION['u_last'] = $row['user_last'];
					$_SESSION['u_uid'] = $row['user_uid'];
					$_SESSION['u_email'] = $row['user_email'];
					$_SESSION['wl_public'] = $row['wl_public'];
					$_SESSION['date'] = $row['date'];

					$this->user_id = $row['user_id'];
					$this->user_first = $row['user_first'];
					$this->user_last = $row['user_last'];
					$this->user_uid = $row['user_uid'];
					$this->user_email = $row['user_email'];
					$this->user_gender = $row['user_gender'];
					$this->user_wl = $row['user_wl'];
					$this->wl_public = $row['wl_public'];
					$this->date = $row['date'];

					$login = "success";
				}
			}
		}
		else $login = "wronguser".$stmt-> rowCount();
		return $login;
	}
	public function signup($user_first, $user_last, $user_uid, $user_pwd, $user_pwdr, $user_email, $user_gender)
	{
		$this->user_first = $user_first;
		$this->user_last = $user_last;
		$this->user_uid = $user_uid;
		$this->user_email = $user_email;
		$this->user_gender = $user_gender;

		$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_uid, $user_email]);

		if($stmt-> rowCount())
		{	//true = username and/or email are taken
			while($row = $stmt->fetch())
			{
				if(htmlentities($row['user_uid']) === $username)
                {
                	$signup = "usernametaken";
                }
                if(htmlentities($row['user_email']) === $email)
            	{
                	if(!empty($signup)) $signup = "uidemailtaken";
                	else $signup = "emailtaken";
                }
			}
		}
        else 
        {
        	$hashedPwd = password_hash($user_pwd, PASSWORD_DEFAULT);
            $date = date("Y/m/d H:i:s");
        	$sql = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd, user_gender, date) VALUES(?,?,?,?, '$hashedPwd', '$gender', '$date');";
        	$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$user_first, $user_last, $user_email, $user_uid]);
			$signup = "success";
            
            $this->login($this->user_uid, $user_pwd);
        }
        return $signup;
    }
    public function __destruct(){}

    public function changepwd($user_pwd, $user_pwdnew, $user_pwdnewr)
    {
    	if(isset($_SESSION['u_id']))
    	{
    		if($user_pwdnew !== $user_pwdnewr)
			{
				$changepwd = "passwordmm";
			}
			elseif (strlen($user_pwd) <= 7) {
				$changepwd = "passwordshort";
			}
			else
			{
				$id = $_SESSION['u_id'];

		    	$sql = "SELECT * FROM users WHERE user_id='$id'";
				$stmt = $this->connect()->query($sql);

				if($row = $stmt->fetch())
				{
					$pwdTest = password_verify($user_pwd, $row['user_pwd']);
					if($pwdTest == false)
					{
						$changepwd = "pwfalse";
					}
					elseif($pwdTest == true)
					{
						$pwdHashed = password_hash($user_pwdnew, PASSWORD_DEFAULT);
						$sql = "UPDATE users SET user_pwd = '$pwdHashed' WHERE user_id='$id';";
						$stmt = $this->connect()->query($sql);

						$changepwd = "success";
					}
				}
			}
    	}
    	else $changepwd = "not_logged_in";
		return $changepwd;
    }
    public function requestpwd($user_pwd)
    {
    	if(isset($_SESSION['u_id']))
    	{
    		$pwd = $_POST['pwd'];
			$id = $_SESSION['u_id'];
			
	    	$sql = "SELECT * FROM users WHERE user_id='$id';";
			$stmt = $this->connect()->query($sql);
			
			if($row = $stmt->fetch())
			{
				$pwdTest = password_verify($user_pwd, $row['user_pwd']);
				if($pwdTest == false) $requestpwd = "pwfalse";
				elseif($pwdTest == true) $requestpwd = "success&&pwdhash=".$row['user_pwd'];
			}
			else $requestpwd = "usererror";
		}
    	else $requestpwd = "not_logged_in";
		return $requestpwd;
    }
}