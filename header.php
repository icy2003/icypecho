<?php if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
$welcomeMsgs = [
    '有朋自远方来，不亦乐乎',
    '海内存知已，天涯若比邻',
    '同是天涯沦落人，相逢何必曾相识',
    '莫愁前路无知己，天下谁人不识君',
    '劝君更尽一杯酒，西出阳关无故人',
];
$welcomeMsg = $welcomeMsgs[rand(0, count($welcomeMsgs) - 1)];
?>
<!DOCTYPE HTML>
<html class="no-js">

<head>
    <meta charset="<?php $this->options->charset();?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
    'category' => _t('分类 %s 下的文章'),
    'search' => _t('包含关键字 %s 的文章'),
    'tag' => _t('标签 %s 下的文章'),
    'author' => _t('%s 发布的文章'),
), '', ' - ');?><?php $this->options->title();?></title>

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header();?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('vendor/bower/layui/dist/css/layui.css');?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('vendor/bower/smallpop/dist/spop.min.css');?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css');?>?t=<?php echo time(); ?>">
    <link rel="shortcut icon" href="/usr/themes/icypecho/favicon.ico" />
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <script src="<?php $this->options->themeUrl('vendor/bower/layui/dist/layui.js');?>"></script>
    <script src="<?php $this->options->themeUrl('vendor/bower/smallpop/dist/spop.min.js');?>"></script>
    <script src="<?php $this->options->themeUrl('js/main.js');?>"></script>
    <script>
    var _hmt = _hmt || [];
    $(function() {
        var refUrl = document.referrer
        if (refUrl && refUrl.indexOf('icy2003.com') == -1) {
            spop({
                template: '<h4><?php echo $welcomeMsg ?></h4><p>欢迎来自 ' + document.referrer.split('/')[
                    2] + ' 的朋友</p>',
                position: 'bottom-left',
                autoclose: 5000
            });
        }
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?4e461e4233e45db93a5a0435707cd7fc";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    });
    </script>

</head>

<body id="body">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <div class="layui-header header">
        <div class="layui-main header-main">
            <?php if ($this->options->logoUrl): ?>
            <a class="logo" href="<?php $this->options->siteUrl();?>" title="<?php $this->options->title()?>">
                <img src="<?php $this->options->logoUrl()?>" />
            </a>
            <?php else: ?>
            <a class="logo" href="<?php $this->options->siteUrl();?>" title="<?php $this->options->title()?>">
                <?php $this->options->title()?>
            </a>
            <?php endif;?>

            <ul class="layui-nav">
                <li class="layui-nav-item layui-hide-xs <?php if ($this->is('index')): ?>layui-this<?php endif;?>">
                    <a href="<?php $this->options->siteUrl();?>"><?php _e('首页');?></a>
                </li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages);?>
                <?php while ($pages->next()): ?>
                <li
                    class="layui-nav-item layui-hide-xs <?php if ($this->is('page', $pages->slug)): ?>layui-this<?php endif;?>">
                    <a href="<?php $pages->permalink();?>" title="<?php $pages->title();?>"><?php $pages->title();?></a>
                </li>
                <?php endwhile;?>

                <li class="layui-nav-item nav-btn layui-hide-sm">
                    <a href="javascript:;"><i class='layui-icon layui-icon-app'></i></a>
                    <dl class="layui-nav-child">
                        <?php while ($pages->next()): ?>
                        <dd><a href="<?php $pages->permalink();?>"><?php $pages->title();?></a></dd>
                        <?php endwhile;?>
                    </dl>
                </li>
            </ul>
        </div>
    </div>