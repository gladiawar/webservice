<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class SettingsAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
		
        $email_notify = intval(Yii::app()->request->getPost('email_notify', '-1'));
        
        if ($email_notify>=0)
		{
			$user = User::model()->findByPk(Yii::app()->user->id);
            $user->email_bmchallenge = ($email_notify==1?'1':'0');
			$user->save();
			echo("1");
		}
        else echo("0Failed to save settings.");
	}
}
