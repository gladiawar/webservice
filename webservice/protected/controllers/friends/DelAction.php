<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class DelAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
        $uid = (int)(Yii::app()->request->getPost('u', 0));
		echo '1';
        if ($uid>0)
		{
			$friend = Friend::model()->find("uid1=:id1 AND uid2=:id2", array(":id1"=>Yii::app()->user->id, ":id2"=>$uid));
			if (!empty($friend))
			{
				$friend->delete();
			}
		}
	}
}
