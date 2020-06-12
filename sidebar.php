<?php

use icy2003\php\I;
use icy2003\php\iapis\Ip;
use icy2003\php\iapis\Meteorology;
use icy2003\php\ihelpers\Arrays;
use icy2003\php\ihelpers\Json;
use icy2003\php\ihelpers\Request;
use icy2003\php\ihelpers\Strings;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$hour = date('H');
if ($hour >= 3 && $hour < 6) {
    $hourText = '凌晨';
} elseif ($hour >= 6 && $hour < 8) {
    $hourText = '早上';
} elseif ($hour >= 8 && $hour < 11) {
    $hourText = '上午';
} elseif ($hour >= 11 && $hour < 13) {
    $hourText = '中午';
} elseif ($hour >= 13 && $hour < 17) {
    $hourText = '下午';
} elseif ($hour >= 17 && $hour < 19) {
    $hourText = '傍晚';
} elseif ($hour >= 19 && $hour < 23) {
    $hourText = '晚上';
} else {
    $hourText = '深夜';
}

if ($_COOKIE['icy2003Location'] && $_COOKIE['icy2003Weather']) {
    $weatherInfo = Json::decode($_COOKIE['icy2003Weather']);
    $ipLocation = $_COOKIE['icy2003Location'];
} else {
    $ip = (new Request)->getRemoteIP();
    // $ip = '153.19.50.62';
    $ipInfo = (new Ip)->fetchAttribution($ip);
    $ipLocation = I::get($ipInfo->toArray(), 'city', '江西省赣州市');
    // $ipLocation = '广东省广州市';
    $meteorology = new Meteorology();
    $meteorology->fetchProvinces();
    $provinces = $meteorology->toArray();
    $provinceCode = $cityCode = '';
    foreach ($provinces as $province) {
        if (Strings::isContains($ipLocation, $province['name'])) {
            $provinceCode = $province['code'];
            break;
        }
    }
    $meteorology->fetchCities($provinceCode);
    $cities = $meteorology->toArray();
    foreach ($cities as $city) {
        if (Strings::isContains($ipLocation, $city['city'])) {
            $cityCode = $city['code'];
            break;
        }
    }
    $meteorology->fetchWeather($cityCode);
    $weatherInfo = Arrays::columns1($meteorology->getResult(), [
        'info' => 'weather.info',
        'temperature' => 'weather.temperature',
        'warning' => 'warn.issuecontent',
    ]);

    $meteorology->fetch7Days($cityCode);
    $sevenDays = $meteorology->toArray();
    $weatherInfo['tomorrow'] = [
        'day' => [
            'info' => I::get($sevenDays, '1.day.weather.info'),
            'temperature' => I::get($sevenDays, '1.day.weather.temperature'),
        ],
        'night' => [
            'info' => I::get($sevenDays, '1.night.weather.info'),
            'temperature' => I::get($sevenDays, '1.night.weather.temperature'),
        ],
    ];
}
?>
<script>
if (!getCookie('icy2003Weather') || !getCookie('icy2003Location')) {
    setCookie('icy2003Location', '<?php echo $ipLocation ?>')
    setCookie('icy2003Weather', '<?php echo Json::encode($weatherInfo) ?>')
}
</script>
<div class="sidebar layui-col-md3 layui-col-lg3">
    <div class="weather">
        <h3 class="title-sidebar"><i class="layui-icon layui-icon-tree"></i><?php echo $ipLocation ?></h3>
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <?php if (!empty($weatherInfo['info'])): ?>
                <li class="layui-this">今天</li>
                <li>明天</li>
                <?php else: ?>
                <li class="layui-this">天气</li>
                <?php endif?>
                <li>疫情</li>
            </ul>
            <div class="layui-tab-content" style="height: 2em;">
                <?php if (!empty($weatherInfo['info'])): ?>
                <div class="layui-tab-item layui-show">
                    实时：
                    <?php echo $weatherInfo['info'] ?> <?php echo $weatherInfo['temperature'] ?> ℃
                    <div id="scroll">
                        <ul>
                            <li>
                                <?php if ($weatherInfo['warning'] != 9999): ?>
                                <?php echo $weatherInfo['warning']; ?>
                                <?php else: ?>
                                你若安好便是晴天
                                <?php endif;?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <p>白天：
                        <?php echo $weatherInfo['tomorrow']['day']['info'] ?>
                        <?php echo $weatherInfo['tomorrow']['day']['temperature'] ?> ℃
                    </p>
                    <p>夜间：
                        <?php echo $weatherInfo['tomorrow']['night']['info'] ?>
                        <?php echo $weatherInfo['tomorrow']['night']['temperature'] ?> ℃
                    </p>
                </div>
                <?php else: ?>
                <div class="layui-tab-item layui-show">
                    <p>天气获取失败或在国外</p>
                    <p>如在国外，请查看：<a href="https://darksky.net/" target="_blank"
                            rel="noopener noreferrer">这里</a></p>
                </div>
                <?php endif?>
                <div class="layui-tab-item">
                    <a href="https://voice.baidu.com/act/newpneumonia/newpneumonia" target="_blank"
                        rel="noopener noreferrer">疫情实时大数据报告</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clock">
        <h3 class="title-sidebar"><i class="layui-icon layui-icon-date"></i><?php echo $hourText ?>好，<span id="copyDate"
                data-clipboard-text="">现在时间</span>
        </h3>
        <div id="clock">&nbsp;</div>
    </div>
    <div class="component">
        <form class="layui-form" id="search" method="post" action="<?php $this->options->siteUrl();?>" role="search">
            <div class="layui-inline input" style="width: 60%">
                <input type="text" id="s" name="s" class="layui-input" required lay-verify="required"
                    placeholder="<?php _e('输入关键字搜索');?>" />
            </div>
            <div class="layui-inline">
                <div class="layui-btn-group">
                    <button class="layui-btn layui-btn-sm layui-btn-primary" title="搜索文章标题">
                        <i class="layui-icon layui-icon-search"></i>
                    </button>
                    <a href="<?php $this->options->siteUrl();?>goodluck?<?php echo rand(0, 99) ?>"
                        class="layui-btn layui-btn-sm layui-btn-primary" title="华生，来试试手气吧">
                        <i class="layui-icon layui-icon-release"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
    <div class="column">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe705;</i><?php _e('栏目分类');?></h3>
        <ul class="layui-row">
            <?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
            <?php while ($categorys->next()): ?>
            <?php if ($categorys->levels === 0): ?>
            <li class="layui-col-md12 layui-col-xs12">
                <a href="<?php echo $categorys->permalink; ?>" title="<?php echo $categorys->name; ?>">
                    <?php echo $categorys->name; ?>
                </a>
            </li>
            <?php endif;?>
            <?php endwhile;?>
        </ul>
    </div>
    <div class="tags">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe66e;</i>标签云</h3>
        <div id="tag-cloud">
            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags);?>
            <?php while ($tags->next()): ?>
            <a class="layui-btn layui-btn-xs layui-btn-primary"
                style="color: rgb(<?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>)"
                href="<?php $tags->permalink();?>" title='<?php $tags->name();?>'><?php $tags->name();?></a>
            <?php endwhile;?>
        </div>
    </div>
    <?php
$links = include 'data/links.php';
?>
    <div class="friends">
        <h3 class="title-sidebar"><i class="layui-icon layui-icon-link"></i><a
                href="https://www.icy2003.com/link.html">申请友链</a></h3>
        <div class="layui-breadcrumb" lay-separator="">
            <?php foreach ($links as $link): ?>a
            <a class="tip" href="<?php echo I::get($link, 'href') ?>" target="_blank" rel="noopener noreferrer"
                title="<?php echo I::get($link, 'title') ?>"><?php echo I::get($link, 'name') ?></a>
            <?php endforeach;?>
        </div>
    </div>
</div>
<script>
function check(val) {
    if (val < 10) {
        return ("0" + val);
    } else {
        return (val);
    }
}

function displayTime() {
    var clockDiv = $("#clock");
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hour = date.getHours();
    var minutes = date.getMinutes();
    var second = date.getSeconds();
    var dayArray = new Array(7);
    dayArray[0] = "周日";
    dayArray[1] = "周一";
    dayArray[2] = "周二";
    dayArray[3] = "周三";
    dayArray[4] = "周四";
    dayArray[5] = "周五";
    dayArray[6] = "周六";
    var weekday = dayArray[date.getDay()];
    var timestr = year + " 年 " + month + " 月 " + day + " 日 " + check(hour) +
        ":" + check(minutes) + ":" + check(second) + " " + weekday;
    $('#copyTimestamp').attr('data-clipboard-text', Math.round(date / 1000));
    $('#copyDate').attr('data-clipboard-text', timestr);
    clockDiv.html(timestr);
    setTimeout('displayTime()', 1000);
}

$(function() {
    // 时间
    displayTime();
    new ClipboardJS('#copyDate').on('success', function(e) {
        layui.layer.msg('华生，你发现了盲点：成功复制了当前时间！');
        e.clearSelection();
    });

    // 天气预报-滚动通告
    $('#scroll').hover(function() {
        layer.tips($(this).find('li').first().text(),
            this, {
                time: 0,
                tips: 3
            });
    }, function() {
        layer.closeAll()
    })
    $("#scroll").kxbdMarquee({
        isEqual: false
    });
});
</script>