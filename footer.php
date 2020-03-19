<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="footer">
    <div class="layui-col-md12 t-copy">
        <span class="layui-breadcrumb">
            <span>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a></span>
            <span class="layui-hide-xs"><a href="http://typecho.org/" target="_blank" rel="nofollow">Typecho 提供技术支持</a></span>
        </span>
    </div>
</div>

<?php $this->footer(); ?>
</body>
</html>
