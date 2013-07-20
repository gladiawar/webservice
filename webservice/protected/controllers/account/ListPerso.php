<?php

class ListPerso extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isGuest) { echo '!'; return; }

		try
		{
			$connexion = new PDO('mysql:host=localhost;dbname=gladiawar', "root", "plout");
		}
		catch (Exception $e)
		{
			echo "0|server";
			return ;
		}
		$rqt = $connexion->prepare("SELECT name, class, `level` FROM `character` WHERE id_player=:id");
		$rqt->execute(array('id'=>Yii::app()->user->id));
        echo '1';
		while ($ligne = $rqt->fetch(PDO::FETCH_OBJ))
			echo '|'.$ligne->name."/".$ligne->class."/".$ligne->level;
    }
}
?>