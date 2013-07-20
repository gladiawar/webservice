<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class LogoutAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
		echo '1';
		Yii::app()->user->logout();
	}
}
