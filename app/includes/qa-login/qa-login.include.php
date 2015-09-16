<div class="qalogin"></div>
<input type="hidden" name="webernets" value="<?php echo $app->crypter->encrypt($app->user->email); ?>" class="webernets hide" />
<input type="hidden" name="distancetothesun" value="<?php echo $app->crypter->encrypt($app->user->sessiontoken); ?>" class="distancetothesun hide" />