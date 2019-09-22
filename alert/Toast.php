<?php

namespace uraankhayayaal\materializecomponents\alert;

use Yii;

class Toast extends \yii\base\Widget
{
    public $alertTypes = [
        'error'   => '<i class=\"material-icons red-text small\">error</i>',
        'danger'  => '<i class=\"material-icons orange-text small\">warning</i>',
        'success' => '<i class=\"material-icons green-text small\">done</i>',
        'info'    => '<i class=\"material-icons cyan-text small\">info</i>',
        'warning' => '<i class=\"material-icons yellow-text small\">warning</i>'
    ];

    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        
        $begin = '(function(){';
        $toasts = '';
        $end = '})();';
        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }
            foreach ((array) $flash as $i => $message) {
                $toasts = $toasts . "var toastContent = $('<span>".$message."</span>').add($('".$this->alertTypes[$type]."'));M.toast({html: toastContent});";
            } 
            $session->removeFlash($type);
        }
        $view = $this->getView();
        if($toasts != '') $view->registerJs($begin.$toasts.$end, $view::POS_END);
    }
}
