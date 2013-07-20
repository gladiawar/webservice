<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class LoginForm extends CFormModel
{
	public $nm; // login account name (email in this case)
	public $pw;	// login password
	public $_identity;

	// -----------------------------------------------------------------------------------------------------------------

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->nm,$this->pw);
			$res = $this->_identity->authenticate();
			if(!$res)
			{
				if ($res == CUserIdentity::ERROR_USERNAME_INVALID) $this->addError('nm','Invalid E-mail.');
				else $this->addError('pw','Invalid Password.');
			}
		}
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->nm,$this->pw);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity, 0);
			return true;
		}
		else return false;
	}

	// -----------------------------------------------------------------------------------------------------------------

	public function rules()
	{
		return array(
			array('nm, pw', 'required'),
			array('pw', 'authenticate'),
		);
	}

	// -----------------------------------------------------------------------------------------------------------------
}
