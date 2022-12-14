<?php
namespace common\widgets;

use common\components\helpers\AppHelper;
use Yii;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alert extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];
    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public $isBackend = false;
    /** @var \yii\web\View $view */
    public $view;


    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';
        $isGuest = Yii::$app->user->isGuest;

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = $this->alertTypes[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

//                    $this->view->registerJs("app.showMessage('".$message."');");

                    $style = $title = '';
                    if ($type === 'error') {
                        $style = '  background-color: #a20e2d;';
                        $title = '????????????!';
                    } else {
                        $title = '??????????????';
                    }

                    echo '
                        <section class="promotion" style="height: 80px;flex-direction: column;display: flex;justify-content: center;'.$style.'">
                            <div class="promotion__title" style="text-align: center;">'.$title.'</div>
                            <div class="promotion__text">'.$message.'</div>
                        </section>                        
                    ';
//                    echo \yii\bootstrap\Alert::widget([
//                        'body' => $message,
//                        'closeButton' => $this->closeButton,
//                        'options' => $this->options,
//                    ]);
                }

                $session->removeFlash($type);
            }
        }
    }
}
