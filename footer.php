<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
$links = include 'data/links.php';
?>

<div class="footer">
    <div class="layui-col-md12 layui-col-xs12 t-copy">
        <span class="layui-breadcrumb">
            <span>&copy; <?php echo date('Y'); ?>
                <a href="<?php $this->options->siteUrl();?>"><?php $this->options->title();?></a>
            </span>
            <span>
                <a href="http://typecho.org/" target="_blank" rel="nofollow">Typecho 提供技术支持</a>
            </span>
        </span>
    </div>
    <div class="layui-col-md12 layui-col-xs12 t-copy">
        <span class="layui-breadcrumb">
            <span>
                <?php Uptime_Plugin::show();?>
            </span>
        </span>
    </div>
</div>

<?php $this->footer();?>
</body>
</html>