<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class User extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'user';
	}
	
	public function rules()
	{
		return array(
			// rules used with register
			array('name, password, email', 'required', 'on'=>'register'),
			array('name', 'length', 'min'=>5, 'max'=>15, 'on'=>'register', 'message'=>'Please enter a public name of between 5 and 15 characters. Only letters and numbers allowed.'),
			array('password', 'length', 'min'=>5, 'max'=>15, 'on'=>'register', 'message'=>'Please enter a password of between 5 and 15 characters.'),
			array('email', 'length', 'max'=>128, 'on'=>'register'),
			array('email', 'email', 'on'=>'register', 'message'=>'Please enter a valid e-mail address. This is important to retrieve your password if you forget it.'),
			array('email', 'unique', 'on'=>'register', 'message'=>'That e-mail address is in use. Use password recovery if you forgot your password.'),
			array('name_lower', 'unique', 'on'=>'register', 'message'=>'That public name is in use, please choose another one.'),
			array('name', 'match', 'pattern'=>'/^[\w\.-]+$/', 'on'=>'register', 'message'=>'Please enter a public name of between 5 and 15 characters. Only letters and numbers allowed.'),
		);
	}
	
	public function beforeSave()
	{
		if ($this->scenario === 'register' && $this->isNewRecord && isset($this->password))
		{
			$this->created = SDGAME::time();
			$this->salt = SDGAME::createSalt();
			$this->password = SDGAME::pwEncode($this->password, $this->salt);
		}
		return parent::beforeSave();		
	}		
}
