<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_user;
	
	public function authenticate($user=null)
	{	
		if ($user === null)
		{	
			// e-mail address is used as "username" / login name
	        $model = User::model()->findByAttributes(array('email'=>$this->username));

	        if($model===null)
			{
	            $this->errorCode=self::ERROR_USERNAME_INVALID;
			}
	        else if($model->password!==SDGAME::pwEncode($this->password, $model->salt))
			{
	            $this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
	        else
	        {
	            $this->errorCode=self::ERROR_NONE;
				
				$this->_id = $model->id;		// user id
				$this->_user = $model;
				
				// update login date
				$model->updated = 
					$model->last_game_refresh =
						$model->last_chat_refresh = SDGAME::time();
				$model->location = 'L'; // lobby
				$model->save();
				
				//Yii::app()->session['location'] = 'L';
				//echo Yii::app()->session['location'];				
				//Yii::app()->session->clear() and Yii::app()->session->destroy()
	        }
		}
		else
		{
			$this->errorCode=self::ERROR_NONE;
			
			$this->_id = $user->id;		// user id
			$this->_user = $user;
			
			// update login date
			$user->updated = SDGAME::time();
			$user->save();
		}
		
        return !$this->errorCode;
	}
	
	public function getId() { return $this->_id; }
	public function getUser() { return $this->_user; }
}