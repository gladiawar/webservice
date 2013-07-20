<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class MainController extends CController
{
	public function actions()
	{
		return array(

			# CHAT AND PLAYERS
			'msgs'=>'application.controllers.chat.MessagesAction',
			'cpm'=>'application.controllers.chat.ChannelAction',
			'listp'=>'application.controllers.chat.ListAction',
			
			# FRIENDS
			'delf'=>'application.controllers.friends.DelAction',
			'addf'=>'application.controllers.friends.AddAction',
			'listf'=>'application.controllers.friends.ListAction',
								
			# ACCOUNTS RELATED
			'logout'=>'application.controllers.account.LogoutAction',
			'login'=>'application.controllers.account.LoginAction',
			'reg'=>'application.controllers.account.RegisterAction',
			'rpw'=>'application.controllers.account.RecoverpwAction',
			'cpw'=>'application.controllers.account.ChangepwAction',
			'settings'=>'application.controllers.account.SettingsAction',
			'listp'=>'application.controllers.account.ListPerso',
			'createp'=>'application.controllers.account.CreatePerso',

			# MISC
			'aimg'=>'application.controllers.common.AdvertAction',
			'news'=>'application.controllers.common.NewsAction',
			
		);
	}

	public function actionVer()
	{
		echo '1' . Yii::app()->params['VERSION'];
	}

	public function actionIndex()
	{
		echo '0';
	}

	public function actionError()
	{
		echo '0';
	    if($error=Yii::app()->errorHandler->error) echo $error['message'];
	}
}