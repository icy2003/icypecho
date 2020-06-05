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
                <div class="error-content">
                    <h3>哦，亲爱的华生</h3>
                    <h3>贝克街可不是这个方向</h3>
                    <h1>回到 <a href="<?php $this->options->siteUrl();?>">贝克街221号B</a></h1>
                </div>
            </div>
        </div>
    </div>

</body>

</html>