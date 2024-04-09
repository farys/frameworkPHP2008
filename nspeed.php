<?php
class nSpeed
{

function loadModel($name)
{
         include('app/models/'.$name.'.class.php');
         return ($model = new $name);
}
private function loadController($name)
{
         if(!file_exists('app/controllers/'.$name.'.class.php')) $name = self::$sDefaultController;
         include('app/controllers/'.$name.'.class.php');
         return ($controller = new $name);
}

function loadClass($name)
{
         include('nspeed/'.$name.'.class.php');
}
function run()
{
         include('nspeed/access.class.php');
         include('nspeed/timer.class.php');
         include('nspeed/controller.class.php');
         include('nspeed/table.class.php');
         include('nspeed/view.class.php');
         include('nspeed/template.class.php');
         //session zawarte w nSpeed_Access

         $timer = new nSpeed_Timer;

         //oddzielanie czlonow adresu
         $sCommands=explode('/',substr($_SERVER['REQUEST_URI'],strlen(self::$sRoot)));
         $sParameters=count($sCommands)-1;

         if(!$sCommands[0]) $sCommands[0] = self::$sDefaultController;

         $cAccess = new nSpeed_Access;
         $cController = self::loadController($sCommands[0]);

         if(!$cAccess->isControllerAllowed($cController))
         {
                                 unset($cController);
                                 $cController = self::loadController(self::$sDefaultController);
         }
         if(!$cController->sDefaultAction) $cController->sDefaultAction = self::$sDefaultAction;
         if(!isset($sCommands[1]) || !$sCommands[1]) $sCommands[1] = $cController->sDefaultAction;
         
         $view = new nSpeed_View;
         $cController->view =& $view;
         //oddzielanie parametrów
         if($tmp = strpos($sCommands[$sParameters],'.html')) $cController->aParameters = explode(',',substr($sCommands[$sParameters],0,$tmp));
         $timer->start();
         if(!($sView = $cController->{$sCommands[1].'Action'}())) return true;
         $timeKontroler = $timer->stop();

         $view->render($sView.'.thtml');

}

static $sRoot;
static $sDefaultController;
static $sDefaultAction;
static $sErrorPage;
static $sDefaultView;
static $aDefaultViewParameters = array();
}
include_once('cfg/main.php');
?>