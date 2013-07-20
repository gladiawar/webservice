<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class MessagesAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
		
        $from_lobby = Yii::app()->request->getPost('l', '1'); 		# L = 1:in-lobby, 0:somewhere-else-like-in-stage 
        $msg_in = Yii::app()->request->getPost('m', '');      		# a message that was send by a player
        $chan_in  = intval(Yii::app()->request->getPost('c', '0')); # chanel the message was send to
        
        echo '1'; # always reply with success code
		$user = User::model()->findByPk(Yii::app()->user->id);		
		if (empty($user)) return;
        
        $timestamp = SDGAME::time();
		
        # save any message that player send            
        if (!empty($msg_in))
		{
            # check if may post to the channel if trying to post to a channel            
            if ($chan_in > 0)
			{                
                $channel = ChatChannel::model()->findByPk($chan_in);
                if (!empty($channel))
				{
                    if ($channel->uid1==$user->id || $channel->uid2==$user->id)
					{
                        # right, seems user may post to this channel
                        $msg = new ChatMessage;
				        $msg->message = $user->name . ": " . $msg_in;
        				$msg->timestamp = SDGAME::time();
						$msg->uid = $user->id;
						$msg->uid2 = ($channel->uid1==$user->id?$channel->uid2:$channel->uid1);
						$msg->cid = $channel->id;
						$msg->save();
					}
				}
			}
            # posting to public game channel
            else
			{
				$msg = new ChatMessage;
				$msg->message = $user->name . ": " . $msg_in;
				$msg->timestamp = SDGAME::time();
				$msg->uid = $user->id;
				$msg->uid2 = 0; // does not matter in this case
				$msg->cid = 0;
				$msg->save();				
			}
		}
		
        # query for chat messages to send to the client		
        $res = ChatMessage::model()->findAll(
			array(
				"condition"	=> "timestamp>:ts AND uid!=:uid AND (cid='0' OR uid2=:uid)", 
				"order"		=> 'timestamp',
				"params"	=> array(
								":ts"=>$user->last_chat_refresh,
								":uid"=>$user->id,
								)				
			));

        # send chat messages to the client
        if (!empty($res))
		{
            foreach ($res as $r)
			{
				echo '|';
				if ($r->cid>0) echo '*' . $r->cid . '|'; # private channel
				echo $r->message;
			}
		}
		
        # update session
        $user->last_chat_refresh = $timestamp;
        $user->location = ($from_lobby=='1'?'L':'G');
        $user->save();
	}
}
