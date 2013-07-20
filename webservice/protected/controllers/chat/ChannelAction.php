<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class ChannelAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated

		$name = strtolower(Yii::app()->request->getPost('u', ''));
		$channel_ids = Yii::app()->request->getPost('n', '');
        
        # player wants to join/create a private channel with another player    
        if (strlen($name)>0)
		{
            # find the player's uid since I work with UIDs and not names
			$user = User::model()->find("name_lower = :n", array(":n"=>$name));
            if (empty($user)) { echo '0'; return; } # not found                
            if ($user->id == Yii::app()->user->id) { echo('0'); return; } # cant PM self
                
            # first check if the channel between the two players dont exist, else create it
            # check for channel(s) where this user and target is in the uids and it is pm_channel 
			$channel = ChatChannel::model()->find("pm_Channel='1' AND ( (uid1=:u1 AND uid2=:u2) OR (uid1=:u2 AND uid2=:u1) )", 
													array(":u1"=>Yii::app()->user->id, ":u2"=>$user->id));
            if (!empty($channel))
			{
                # there is a channel, update its created date so it is fresh and then send it to player
                $channel->created = SDGAME::datetime();
                if ($channel->save())
				{
                	echo '1' . $channel->id;
				}
				else echo '0';
			}
            else
			{
                # create the channel
				$channel = new ChatChannel();
				$channel->created = SDGAME::datetime();
				$channel->pm_channel = '1';
				$channel->uid1 = Yii::app()->user->id;
				$channel->uid2 = $user->id;
				if ($channel->save())
				{
					echo '1' . $channel->id;
				}
				else echo '0';
			}
		}
		
        # player wants the names for channels
        else if (!empty($channel_ids))
		{
			echo '1';
			
			// make sure the ids is is proper format to be used in the SQL
            $cids = explode(',', $channel_ids);
			$sids = '';
			foreach($cids as $id)
			{
				if (strlen($sids)>0) $sids .= ',';
				$sids .= $id;
			}
            $channels = ChatChannel::model()->findAll("id IN (:ids)", array(":ids"=>$sids));
            if (!empty($channels))
			{                 
                foreach($channels as $channel)
                {
                    # find the name it should be, a player name for pm channel
					if ($channel->uid1==Yii::app()->user->id) $uid = $channel->uid2;
					else $uid = $channel->uid1;
					if ($uid > 0)
					{
						$player = User::model()->findByPk($uid);
						if (!empty($player))
						{
							echo '|' . $channel->id . ',' . $player->name;
						}
					}
				}
			}
		}
        else echo '0';
	}
}
