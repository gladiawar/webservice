<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class AddAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
		
		$name = strtolower(Yii::app()->request->getPost('u', ''));
        
        if (strlen($name)>0)
		{
            # find the player's uid since I work with UIDs and not names
			$user = User::model()->find("name_lower = :n", array(":n"=>$name));
            if (empty($user)) { echo '0'; return; } # not found                
            $uid = $user->id;
            if ($uid == Yii::app()->user->id) { echo '0'; return; } # cant add self
            
            # check if not allready in friend list (friend are not two way, other person MUST add seperatly)
			$friend = Friend::model()->find("uid1=:id1 AND uid2=:id2", array(":id1"=>Yii::app()->user->id, ":id2"=>$uid));
			if (empty($friend))
			{
				# not found, add
				$friend = new Friend;
				$friend->uid1 = Yii::app()->user->id;
				$friend->uid2 = $uid;
				$friend->save();
			}
			
			echo '1' . $uid . ',' . $user->name;
		}
		else echo '0';
	}
}
