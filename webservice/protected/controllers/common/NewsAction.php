<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class NewsAction extends CAction
{
	public function run()
	{
        $res = News::model()->findAll(array('order'=>'dt desc'));
        if (!empty($res))
		{
            echo '1';
            foreach($res as $r)
			{
                echo SDGAME::formatedDateFromDT($r->dt, true,true, false,false) . '^';
                echo $r->msg . '|';
			}
		} 
		else echo '0';
	}
}
