<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class ListAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated

		$friends = Friend::model()->with('userinfo')->findAll("uid1=:id1", array(":id1"=>Yii::app()->user->id));
        if (!empty($friends))
		{
			echo '1';
			$check_t = SDGAME::time() - 90; # 1.5 minutes
			foreach($friends as $f)
			{
				$p = $f->userinfo;
				$st = '0'; # check if player is - 0:offline, 1:online, 2:bussy, 3:unknown
	          	if ($p->last_chat_refresh >= $check_t)
				{
                	$st = '1'; # is online
                	if ($p->location != 'L') $st = '2'; # not in lobby				
				}
				echo '|' . $p->id . ',' . $st . ',' . $p->name;
			}
		}
		else echo '0';
	}
}
