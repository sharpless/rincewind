<?php
switch ($_SESSION['page']) {
  case 'firstrun':
    include_once TP_PAGESPATH . 'home/PFirstRun.php';
    break;
  case 'source':
    include_once TP_PAGESPATH . 'viewfiles/source2.php';
    break;
  case 'cssp':
    include_once TP_PAGESPATH . 'actions/PCssProcess.php';
    break;
  case 'login':
    include_once TP_PAGESPATH . 'login/PLogin.php';
    break;
  case 'loginp' :
    include_once TP_PAGESPATH . 'login/PLoginProcess.php';
    break;
  case 'logout':
    include_once TP_PAGESPATH . 'login/PLogoutProcess.php';
    break;
  case 'install':
    include_once TP_PAGESPATH . 'install/PRestore.php';
    break;
  case 'installp':
    include_once TP_PAGESPATH . 'install/PRestoreProcess.php';
    break;
  case 'users':
    include_once TP_PAGESPATH . 'admin/PUsersList.php';
    break;
  case 'account':
    include_once TP_PAGESPATH . 'account/PAccountEdit.php';
    break;
  case 'accounteditp':
    include_once TP_PAGESPATH . 'account/PAccountEditProcess.php';
    break;
  case 'createaccount':
    include_once TP_PAGESPATH . 'account/PAccountCreate.php';
    break;    
  case 'createaccountp':
    include_once TP_PAGESPATH . 'account/PAccountCreateProcess.php';
    break;    
  default:
  case 'home':
    include_once TP_PAGESPATH . 'home/PHome.php';
    $_SESSION['page'] = 'home';
    break;
}
?>
