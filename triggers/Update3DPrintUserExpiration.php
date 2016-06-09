<?php
$user = $this->wire('users')->get('lab_user_ufid='.$charge->lab_charge_ufid);
$user->of(false);
$user->lab_user_expiration_date = time()+(60*24*60*60);
$user->save();
$user->of(true);
?>
