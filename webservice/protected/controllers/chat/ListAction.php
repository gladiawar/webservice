<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class ListAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated

        echo '1';

        # find players online in past 2 minutes
        $check_t = SDGAME::time() - 120; # 2 minutes
		$players = User::model()->findAll("last_chat_refresh >= :t", array(":t"=>$check_t));
		$check_t = SDGAME::time() - 60; # 1 minute
		foreach($players as $p)
		{
            $st = '0'; # check if player is - 0:offline, 1:online, 2:bussy, 3:unknown
            if ($p->last_chat_refresh >= $check_t)
			{
                $st = '1'; # is online
                if ($p->location != 'L') $st = '2'; # not in lobby
                    
			}
            echo '|' . $p->id . ',' . $st . ',' . $p->name;
		}
	}
}
