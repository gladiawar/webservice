<?php
# Created on 1 Dec 2011
# @author: PL Young
#=======================================================================================================================

class RecoverpwAction extends CAction
{
	public function run()
	{
		$email = strtolower(Yii::app()->request->getPost('em', ''));
				
		$vali = new CEmailValidator();
		if (!$vali->validateValue($email))
		{
            echo ("0Please enter a valid e-mail address.");
			return;
		}
        
        # find the user from e-mail
		$user = User::model()->findByAttributes(array('email'=>$email));
        if (!empty($user))
		{
            $game_name = Yii::app()->name;
            $game_url = Yii::app()->params['URL'];
            $new_pass = SDGAME::createSalt(); // use to make random charas for pw
            $user->password = SDGAME::pwEncode($new_pass, $user->salt);
			
			if (!$user->save())
			{
                echo("0Password recovery failed. Please try again later.");
                return;
			}
			
            $subject = $game_name + " login password recovery";
            $body = <<<EOT
Dear {$user->name}

This is an automated response. A request was made for your login password used with {$game_name}

Your new password is: {$new_pass}

Use this new password to login to the game. You may change the password in your profile section.
For more information, visit {$game_url}

Thank you
EOT;

            # send the email
			$headers="From: ".Yii::app()->params['EMAIL_REPLY']."\r\nReply-To: ".Yii::app()->params['EMAIL_REPLY'];
			if (!mail($user->email,$subject,$body,$headers))
			{
				echo("0System error. Please try again later.");
				return;
			}
			echo ("1");
            return;
		}
        echo("0We do not have a record of that e-mail address. You may register to join this game.");
	}
}
