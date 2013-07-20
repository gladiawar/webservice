<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class AdvertAction extends CAction
{
	public function run()
	{
        # choose random advert
        $res = Advert::model()->findAll();
        if (!empty($res))
		{
            echo '1';
            $r = rand(0, count($res)-1);
            echo $res[$r]->url;
		}
		else echo '0';
	}
}
