<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class ChatChannel extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'chatchannel';
	}
}
