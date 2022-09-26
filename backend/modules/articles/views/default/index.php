<?
use \backend\components\helpers\MenuHelper;

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/blocks',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ARTICLES;

?>
<div class="old_lr_articles_module-default-index">
    <h1><?php echo $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?php echo $this->context->action->id ?>".
        The action belongs to the controller "<?php echo get_class($this->context) ?>"
        in the "<?php echo $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?php echo __FILE__ ?></code>
    </p>
</div>
