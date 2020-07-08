<?php
/**
 * icypecho 模板
 *
 * @package Icypecho
 * @author icy2003
 * @version 0.0
 * @link https://www.icy2003.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');
?>

<div class="layui-container">
    <div class="layui-row layui-col-space15 main">
        <div class="layui-col-md9 layui-col-lg9">
            <?php while ($this->next()): ?>
            <div class="title-article list-card">
                <div class="list-pic">
                    <a href="<?php $this->permalink()?>" title="<?php $this->title()?>">
                        <?php echo thumb($this); ?>
                    </a>
                </div>
                <a href="<?php $this->permalink()?>">
                    <h3><?php $this->title()?></h3>
                    <div class="list-introduction"><?php echo excerpt($this, 200, '...'); ?></div>
                </a>
                <div class="title-msg">
                    <span><i class="layui-icon layui-icon-read"></i> <?php $this->category(',');?></span>
                    <span><i class="layui-icon layui-icon-date"></i> <?php $this->date();?> </span>
                    <span class="layui-hide-xs"><i class="layui-icon layui-icon-fire"></i>
                        <?php get_post_view($this);?></span>
                    <span class="layui-hide-xs"><i class="layui-icon layui-icon-dialogue"></i>
                        <?php $this->commentsNum('%d');?>条</span>
                </div>
            </div>
            <?php endwhile;?>
            <div class="page-navigator">
                <?php $this->pageNav('«', '»', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'layui-laypage layui-laypage-molv', 'itemTag' => '', 'currentClass' => 'current'));?>
            </div>
        </div>

        <?php $this->need('sidebar.php');?>

    </div>
</div>

<?php $this->need('footer.php');?>