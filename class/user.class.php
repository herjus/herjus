<?php 
include_once 'dbh.class.php';

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
	public $twitter_name;
	public $date;

	public function getWl()
	{
		if(isset($_SESSION['u_id']))
		{
			$id = $_SESSION['u_id'];

			$sql = "SELECT * FROM users WHERE user_id='$id';";
			$stmt = $this->connect()->query($sql);

			while($row = $stmt->fetch())
			{
				if($row['user_wl'] != null) $this->user_wl = json_decode($row['user_wl'], true);
			}
		}
	}
	public function merge($wlencoded)
	{
		$additem = "error";
		$id = $_SESSION['u_id'];

		if(!empty($id))
		{
			if($this->user_wl === null) //signed up users wl is null, but not twitter wl
			{
			 	$json_wl = $wlencoded;
			}
			else 
			{
				$wldecoded = json_decode($wlencoded, true);
				$full_wl = array_merge($this->user_wl, $wldecoded);
				$json_wl = json_encode($full_wl);
			}

			//update new wishlist with new item
			$sql = "UPDATE users SET user_wl = ? WHERE user_id='$id' ;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$json_wl]);
			$additem = "merged";
		}
		else $additem = "not_logged_in";
		return $additem;
	}
	

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
	public function setTwitterName($twitter_name)
	{
		$this->twitter_name = $twitter_name;
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
					if(isset($row['twitter_name'])) $_SESSION['twitter_name'] = $row['twitter_name'];

					$this->user_id = $row['user_id'];
					$this->user_first = $row['user_first'];
					$this->user_last = $row['user_last'];
					$this->user_uid = $row['user_uid'];
					$this->user_email = $row['user_email'];
					$this->user_gender = $row['user_gender'];
					$this->user_wl = $row['user_wl'];
					$this->wl_public = $row['wl_public'];
					$this->twitter_name = $row['twitter_name'];
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
		$signup = "error";
		$this->user_first = $user_first;
		$this->user_last = $user_last;
		$this->user_uid = $user_uid;
		$this->user_email = $user_email;
		$this->user_gender = $user_gender;

		$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_uid, $user_email]);

		if($stmt-> rowCount())
		{	//true = user_uid and/or user_email are taken
			$signup = "resultfound";
			while($row = $stmt->fetch())
			{
				if(htmlentities($row['user_uid']) === $user_uid)
                {
                	$signup = "usernametaken";
                }
                if(htmlentities($row['user_email']) === $user_email)
            	{
                	if($signup == "usernametaken") $signup = "uidemailtaken";
                	else $signup = "emailtaken";
                }
			}
		}
        else 
        {
        	$signup = "signupstartederror";
        	$hashedPwd = password_hash($user_pwd, PASSWORD_DEFAULT);
            $date = date("Y/m/d H:i:s");
            if(isset($_SESSION['twitter_name']) && !empty($_SESSION['twitter_name']))
            {
            	$twitter_name = $_SESSION['twitter_name'];
            	$sql = "UPDATE users SET user_first=?, user_last=?, user_email=?, user_uid=?, user_pwd='$hashedPwd', user_gender='$user_gender' WHERE twitter_name='twitter_name';";
            }
            else
            {
        		$sql = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd, user_gender, date) VALUES(?,?,?,?, '$hashedPwd', '$user_gender', '$date');";
            }
        	$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$user_first, $user_last, $user_email, $user_uid]);
			$signup = "success";
            
            $this->login($this->user_uid, $user_pwd);
        }
        return $signup;
    }
    
    public function twitterHandler($twitter_name)
	{
		$result = "error";

		$sql = "SELECT * FROM users WHERE twitter_name='$twitter_name'";
		$twittersearch = $this->connect()->query($sql);

		if(!$twittersearch->rowCount())//twitter name not found in db
		{
			if(isset($_SESSION['u_uid'])) //connect account to new twitter name
			{
				$result = $this->twConnect($twitter_name);
			}
			else
			{ //sign up and log in new twitter user
				
				$result = $this->twSignup($twitter_name);
			}
		}
		elseif($row = $twittersearch->fetch()) //twitter name found in db
		{
			if(isset($_SESSION['u_uid'])) //signed in
			{
				if(!isset($row['user_uid']) || empty($row['user_uid'])) //twitter account has no uid/signup
				{
					$this->getWl();
					$result = $this->twMerge($row);
					$result .= $this->twLogin($twitter_name);
				}
				else
				{
					$result = "accountAlreadyConnected";
				}
			}
			else
			{
				$result = $this->twLogin($twitter_name);
			}
		}
		
		return $result;
    }
    private function twLogin($twitter_name)
    {
    	$sql = "SELECT * FROM users WHERE twitter_name='$twitter_name'";
		$stmt = $this->connect()->query($sql);
		if($row = $stmt->fetch())
		{
			$_SESSION['u_id'] = $row['user_id'];
	        $_SESSION['twitter_name'] = $row['twitter_name'];

			if(isset($row['user_uid']))
			{
				$_SESSION['u_first'] = $row['user_first'];
				$_SESSION['u_last'] = $row['user_last'];
				$_SESSION['u_uid'] = $row['user_uid'];
				$_SESSION['u_email'] = $row['user_email'];
				$_SESSION['wl_public'] = $row['wl_public'];
			}
			$_SESSION['date'] = $row['date'];

			$login = "success";
		}	
    	else $login = "nouserfound";
    	return $login;
    }
    private function twSignup($twitter_name)
    {
    	$result = "signupError";
    	$date = date("Y/m/d H:i:s");
    	$sql = "INSERT INTO users(twitter_name, date) VALUES('$twitter_name', '$date');";
    	if($this->connect()->query($sql)) 
		{
			$result = "twsignup";
    		$result .= $this->twLogin($twitter_name);
    	}

    	return $result;
    }
    private function twConnect($twitter_name)
    {
    	$connect = "twConnectError";
    	$user_id = $_SESSION['u_id'];
		$date = date("Y/m/d H:i:s");
		$sql = "UPDATE users SET twitter_name='$twitter_name' WHERE user_id='$user_id' ;";
		if($stmt = $this->connect()->query($sql)) $connect = "successful";

		return $connect;
    }
    private function twMerge($row)
    {
    	if($row['user_wl'] !== null) 
		{
			$result = $this->merge($row['user_wl']); //merge twitter and session WL, added in Session ID
		}
		$merge = "mergeError";
		$user_uid = $_SESSION['u_uid'];
		$twitter_name = $row['twitter_name'];
		$sql = "UPDATE users SET twitter_name='$twitter_name' WHERE user_uid='$user_uid' ;";
		if($this->connect()->query($sql)) 
		{
			$sql = "DELETE FROM users WHERE twitter_name='$twitter_name' AND user_uid is NULL;";
			if($this->connect()->query($sql)) 
				{
					$merge = "mergeSuccessful";
				}
		}
		else $merge = "updatefail";

		return $merge;
    }
    public function twDelete()
    {
    	$result = "deletefail";
		$user_id = $_SESSION['u_id'];
		$twitter_name = $_SESSION['twitter_name'];
		$sql = "UPDATE users SET twitter_name=NULL WHERE user_id='$user_id' AND twitter_name='$twitter_name' ;";
		if($this->connect()->query($sql)) 
		{
			unset($_SESSION['twitter_name']);
			$result = "deletedone";
		}

		return $result;
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