<?php

class CreatePerso extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isGuest) { echo '!'; return; }

		$class = Yii::app()->request->getPost('class', '');
		$name = Yii::app()->request->getPost('name', '');
        $command = Yii::app()->db->createCommand()
                ->select('COUNT(id)')
                ->from('character')
                ->where('id_player=:id', array(':id' => Yii::app()->user->id))
                ->queryRow();
		$num = 0;
		foreach ($command as $val)
			$num = $val;
		if ($num > 2)
		{
			echo '0';
			return ;
		}
		$command3 = Yii::app()->db->createCommand()
                ->select('COUNT(id)')
                ->from('character')
                ->where('name=:name', array('name' => $name))
                ->queryRow();
		$num = 0;
		foreach ($command3 as $val)
			$num = $val;
		if ($num > 0)
		{
			echo '0';
		}
		else
		{
			$endurance = 0;
			$strength = 0;
			$agility = 0;
			switch ($class)
			{
			case "1":
				$endurance = 50;
				$strength = 50;
				$agility = 50;
				break;
			case "2":
				$endurance = 80;
				$strength = 30;
				$agility = 30;
				break;
			default:
				$endurance = 30;
				$strength = 60;
				$agility = 60;
				break;
			}
			
			$command2 = Yii::app()->db->createCommand()->insert('character', array(
						'id' => '',
						'name' => $name,
						'id_player' => Yii::app()->user->id,
						'class' => $class,
						'endurance' => $endurance,
						'strength' => $strength,
						'agility' => $agility,
						'level' => 1,
						'xp' => 0,
						'money' => 0));
			echo '1';
		}
    }
}
?>