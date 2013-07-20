<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class ChangepwAction extends CAction
{
	public function run()
	{
		if (Yii::app()->user->isGuest) { echo '!'; return; } // must be authenticated
		
        $old_pw = Yii::app()->request->getPost('a', '');
        $password = Yii::app()->request->getPost('b', '');
        
        if (strlen($old_pw)<1){echo("0You did not provide your old password."); return;}
        if (strlen($password)<5 or strlen($password)>15){echo("0Please enter a new password of between 5 and 15 characters."); return;}
        
		$model = User::model()->findByPk(Yii::app()->user->id);
		if($model->password!==SDGAME::pwEncode($old_pw, $model->salt))
		{
			$user->password = SDGAME::pwEncode($password, $model->salt);
			$user->save();
        	echo('1');
		}
		else{echo("0Your old password was invalid"); return;}
	}
}
