<?php
include 'dbh.class.php';

class Wishlist extends Dbh
{
	public $user_wl;
	public $wl_public;

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
	public function addItem($name, $url, $price, $priority, $comment)
	{
		$this->getWl();

		$id = $_SESSION['u_id'];
		if(!empty($id))
		{
			if($this->user_wl == null) $this->user_wl = array();

			$wlitem = array('name' => $name, 'url' => $url, 'price' => $price, 'priority' => $priority, 'comment' => $comment, 'date' => date("Y/m/d H:i:s"));

			array_push($this->user_wl, $wlitem);
			$json_wl = json_encode($this->user_wl);

			//update new wishlist with new item
			$sql = "UPDATE users SET user_wl = ? WHERE user_id='$id' ;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$json_wl]);
			$additem = "added";
		}
		else $additem = "not_logged_in";
		return $additem;
	}
	public function deleteItem($date)
	{
		$wl = $this->user_wl;
		if(isset($_SESSION['u_id']))
		{
			$deleteitem = "404";
			$id = $_SESSION['u_id'];
			$deldate = htmlentities($date);

			for($i = 0; $i < count($this->user_wl);$i++)
			{
				$wlitem = $this->user_wl[$i];
			    $wldate = $wlitem['date'];

				if($wldate == $deldate)
				{
					unset($this->user_wl[$i]);
					$this->user_wl = array_values($this->user_wl);
					$i = count($this->user_wl);
					$json_wl = json_encode($this->user_wl);
					$sql = "UPDATE users SET user_wl = ? WHERE user_id='$id' ;";
					$stmt = $this->connect()->prepare($sql);
					$stmt->execute([$json_wl]);
			        $deleteitem = "deleted";
		        }
			}
		}
		else $deleteitem = "not_logged_in";
		return $deleteitem;
	}
	public function changeVisibility($changeVisibility)
	{
		if(isset($_SESSION['u_id']))
		{
			$id = $_SESSION['u_id'];
			if($changeVisibility == "public")
			{
				$sql = "UPDATE users SET wl_public=1 WHERE user_id='$id';";
				$stmt = $this->connect()->query($sql);
				$_SESSION['wl_public'] = true;
				$visibility = "public";
			}
			elseif($changeVisibility == "private")
			{
				$sql = "UPDATE users SET wl_public=0 WHERE user_id='$id';";
				$stmt = $this->connect()->query($sql);
				$_SESSION['wl_public'] = false;
				$visibility = "private";
			}
		}
		else $visibility = "not_logged_in";

		return $visibility;
	}
	public function getPublicWl($uid)
	{

		$sql = "SELECT * FROM users WHERE user_uid='$uid';";
		$stmt = $this->connect()->query($sql);

		while($row = $stmt->fetch())
		{
			if($row['user_wl'] != null)
			{
				if($row['wl_public']) $this->user_wl = json_decode($row['user_wl'], true);
				else
				{
					$this->wl_public = false;
				 	return "user_not_public";
				}

			}
		}
	}
}
