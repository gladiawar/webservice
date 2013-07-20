<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class RegisterAction extends CAction
{
	public function run()
	{
		$model = new User('register');
		$model->email = strtolower(Yii::app()->request->getPost('em', ''));
		$model->name = Yii::app()->request->getPost('nm', '');
		$model->name_lower = strtolower($model->name);
		$model->password = Yii::app()->request->getPost('pw', '');
		        		
		if($model->validate())
		{
			if ($model->save())
        	{
        		echo '1'; // success
				return;
        	}
		}
		
		echo '0';
		echo SDGAME::getFirstError($model->errors); // return first error
	}
}
