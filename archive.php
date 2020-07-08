<?php if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
?>
<?php $this->need('header.php');?>

<div class="layui-container">
    <div class="layui-row layui-col-space15 main">
        <div class="map">
            <span class="layui-breadcrumb">
                <a href="<?php $this->options->siteUrl();?>"><?php _e('首页');?></a>
                <a><cite>
                        <?php $this->archiveTitle(array(
    'category' => _t('分类 %s 下的文章'),
    'search' => _t('包含关键字 %s 的文章'),
    'tag' => _t('标签 %s 下的文章'),
    'author' => _t('%s 发布的文章'),
), '', '');?>
                    </cite></a>
            </span>
        </div>
        <div class="layui-col-md9 layui-col-lg9">
            <fieldset class="layui-elem-field">
                <legend><?php echo randomWords('motto') ?></legend>
                <div class="layui-field-box">
                    <?php echo $this->getDescription() ? $this->getDescription() : $this->archiveTitle(null, '(*￣０￣)ノ[ ', ' ]'); ?>
                </div>
            </fieldset>
            <?php if ($this->have()): ?>
            <?php while ($this->next()): ?>
            <div class="title-article list-card">
                <div class="list-pic">
                    <a href="<?php $this->permalink()?>" title="<?php $this->title()?>">
                        <?php echo thumb($this); ?>
                    </a>
                </div>
                <a href="<?php $this->permalink()?>">
                    <h3><?php $this->title()?></h3>
                </a>
                <div class="list-introduction"><?php echo excerpt($this); ?></div>
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
            <?php else: ?>
            <div class="post">
                <h2 class="post-title"><?php _e('没有找到内容');?></h2>
            </div>
            <?php endif;?>
        </div>

        <?php $this->need('sidebar.php');?>

    </div>
</div>

<?php $this->need('footer.php');?>