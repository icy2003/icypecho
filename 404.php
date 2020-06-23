<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php $this->options->charset();?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>404 - <?php $this->options->title();?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/404.css');?>">
</head>

<body>
    <div id="page-wrapper">
        <div class="page-blank-wrap">
            <div class="site-error">
                <h1 class="headline"><img src="<?php $this->options->themeUrl('img/404.gif');?>" alt="404"></h1>
                <h1>哦，亲爱的华生，你要去哪？</h1>
                <div class="error-content">
                    <h3>1. <a href="<?php $this->options->siteUrl();?>" title="去首页">贝克街 221B</a></h3>
                    <h3>2. <a href="javascript:history.back(-1)" title="返回上一页">苏格兰场</a></h3>
                    <h3>3. <a href="<?php $this->options->siteUrl();?>goodluck?<?php echo rand(0, 99) ?>" title="随机跳转">去探险</a></h3>
                </div>
            </div>
        </div>
    </div>

</body>

</html>