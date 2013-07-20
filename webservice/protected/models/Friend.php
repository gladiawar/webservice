<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class Friend extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'friend';
	}
		
	public function rules()
	{
		return array();
	}
	
	public function relations()
	{
		return array(
			'userinfo'=>array(self::BELONGS_TO, 'User', 'uid2'),
		);
	}
}
