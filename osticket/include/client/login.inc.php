<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1086507984779984";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getName(), $content->getBody()));
} else {
    $title = __('Sign In');
    $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>
<h1><?php echo Format::display($title); ?></h1>
<p><?php echo Format::display($body); ?></p>
<form action="login.php" method="post" id="clientLogin">
    <?php csrf_token(); ?>
<div style="display:table-row">
    <div class="login-box" style="width: 120px">
    <strong><?php echo Format::htmlchars($errors['login']); ?></strong>
    <div>
        <input id="username" placeholder="<?php echo __('Email or Username'); ?>" type="text" name="luser" size="30" value="<?php echo $email; ?>" class="nowarn">
    </div>
    <div>
        <input id="passwd" placeholder="<?php echo __('Password'); ?>" type="password" name="lpasswd" size="30" value="<?php echo $passwd; ?>" class="nowarn"></td>
    </div>
    <p>
        <input class="btn" type="submit" value="<?php echo __('Sign In'); ?>">
<?php if ($suggest_pwreset) { ?>
        <a style="padding-top:4px;display:inline-block;" href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
<?php } ?>
    </p>
    </div>
    <div class="login-box" style="width: 110px">
    <div>
       <button style="height: 32px;width: 200px"><img src="/osticket/assets/default/images/facebook.png" style="height: 34px;width: 201px;margin-left: -5%;margin-top: -2%" scope="public_profile,email" onlogin="checkLoginState();"></button>
    </div>
    <div style="margin-top: 4%">
    <button scope="public_profile,email" onlogin="checkLoginState();" style="height: 32px;width: 200px"><img src="/osticket/assets/default/images/google.png" style="height: 34px;width: 201px;margin-left: -5%;margin-top: -2%;border-radius: 6px"></button></td>
    </div>
    </div>
    <div style="display:table-cell;padding: 15px;vertical-align:top">
<?php

$ext_bks = array();
foreach (UserAuthenticationBackend::allRegistered() as $bk)
    if ($bk instanceof ExternalAuthentication)
        $ext_bks[] = $bk;

if (count($ext_bks)) {
    foreach ($ext_bks as $bk) { ?>
<div class="external-auth"><?php $bk->renderExternalLink(); ?></div><?php
    }
}
if ($cfg && $cfg->isClientRegistrationEnabled()) {
    if (count($ext_bks)) echo '<hr style="width:70%"/>'; ?>
    <div style="margin-bottom: 5px">
    <?php echo __('Not yet registered?'); ?> <a href="account.php?do=create"><?php echo __('Create an account'); ?></a>
    </div>
<?php } ?>
    </br>
    <div>
    <b><?php echo __("I'm an agent"); ?></b> — </br>
    <a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('sign in here'); ?></a>
    </div>
    </div>
</div>
</form>
<br>
<p>
<?php
if ($cfg->getClientRegistrationMode() != 'disabled'
    || !$cfg->isClientLoginRequired()) {
    echo sprintf(__('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
        '<a href="open.php">', '</a>');
} ?>
</p>
<script type="text/javascript">
    function signlink(){
        alert('<?php echo "all is well" ?>');
    }
</script>