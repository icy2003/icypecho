<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">

<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?> ~ 个人博客</title>

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('layui/css/layui.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>?t=<?php echo time(); ?>">
    <script src="<?php $this->options->themeUrl('vendor/bower/layui/dist/layui.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>
</head>

<body>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <div class="layui-header header">
        <div class="layui-main">
            <?php if ($this->options->logoUrl): ?>
            <a class="logo" href="<?php $this->options->siteUrl(); ?>">
                <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
            </a>
            <?php else: ?>
            <a class="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
            <?php endif; ?>

            <ul class="layui-nav">
                <li class="layui-nav-item layui-hide-xs <?php if($this->is('index')): ?>layui-this<?php endif; ?>">
                    <a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                </li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                <li
                    class="layui-nav-item layui-hide-xs <?php if($this->is('page', $pages->slug)): ?>layui-this<?php endif; ?>">
                    <a href="<?php $pages->permalink(); ?>"
                        title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                </li>
                <?php endwhile; ?>

                <li class="layui-nav-item nav-btn layui-hide-sm">
                    <a href="javascript:;"><i class='layui-icon layui-icon-more'></i></a>
                    <dl class="layui-nav-child">
                        <?php while($pages->next()): ?>
                        <dd><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></dd>
                        <?php endwhile; ?>
                    </dl>
                </li>
            </ul>
        </div>
    </div>