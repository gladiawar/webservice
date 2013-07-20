<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class LoginAction extends CAction
{
	public function run()
	{
		$model=new LoginForm;		
		$model->nm = strtolower(Yii::app()->request->getPost('nm', '!'));
		$model->pw = Yii::app()->request->getPost('pw', '!');
		
		if($model->validate() && $model->login())
		{
			$bmplayer = $model->_identity->getUser();
			
			echo "1";
			
			// I need to send session id cause some browsers dont give it to me in unity webplayer www headers
			$sid = Yii::app()->session->getSessionID();
			if (!empty($sid))
			{
				echo "PHPSESSID=".$sid;
			}
			
			echo '|';
			echo $bmplayer->name . "|";
			
			# send player's rank/rating and other infos
			echo $bmplayer->rating. '|';
			echo $bmplayer->wins. '|';
			echo $bmplayer->losses. '|';
			echo $bmplayer->draws. '|';
			echo $bmplayer->quits. '|';
			echo $bmplayer->email_bmchallenge. '|';
			
			# tell client what the player owns, a string containing characters 
			# like "01AB" (0 could mean base game, 1 could be expansion one, etc)
			echo $bmplayer->shop;
								
			return;
		}
		echo "0";
		echo SDGAME::getFirstError($model->errors); // return first error
	}
}
