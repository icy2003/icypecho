<?php if (!defined('__TYPECHO_ROOT_DIR__')) {
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
?>
<div class="sidebar layui-col-md3 layui-col-lg3">
    <div class="component">
        <form class="layui-form" id="search" method="post" action="<?php $this->options->siteUrl();?>" role="search">
            <div class="layui-inline input">
                <input type="text" id="s" name="s" class="layui-input" required lay-verify="required"
                    placeholder="<?php _e('输入关键字搜索');?>" />
            </div>
            <div class="layui-inline">
                <button class="layui-btn layui-btn-sm layui-btn-primary"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
    <div class="clock">
        <h3 class="title-sidebar"><i class="layui-icon layui-icon-date"></i><?php echo $hourText ?>好，<span id="copyDate" data-clipboard-text="">现在时间</span>
        </h3>
        <div id="clock"></div>
    </div>
    <div class="column">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe705;</i><?php _e('栏目分类');?></h3>
        <ul class="layui-row layui-col-space5">
            <?php $this->widget('Widget_Metas_Category_List')
    ->parse('<li class="layui-col-md12 layui-col-xs6"><a href="{permalink}"><i class="layui-icon">&#xe63c;</i> {name}<span class="layui-badge layui-bg-gray">{count}</span></a></li>');?>
        </ul>
    </div>
    <div class="tags">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe66e;</i>标签云</h3>
        <div>
            <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags);?>
            <?php while ($tags->next()): ?>
            <a class="layui-btn layui-btn-xs layui-btn-primary"
                style="color: rgb(<?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>, <?php echo (rand(0, 255)); ?>)"
                href="<?php $tags->permalink();?>" title='<?php $tags->name();?>'><?php $tags->name();?></a>
            <?php endwhile;?>
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
    var timestr = year + "年" + month + "月" + day + "日 " + check(hour) +
        ":" + check(minutes) + ":" + check(second) + " " + weekday;
    $('#copyTimestamp').attr('data-clipboard-text', Math.round(date / 1000));
    $('#copyDate').attr('data-clipboard-text', timestr);
    clockDiv.html(timestr);
    setTimeout('displayTime()', 1000);
}
$(function() {
    displayTime();
    new ClipboardJS('#copyDate').on('success', function(e) {
        layui.layer.msg('华生，你发现了盲点：成功复制了当前时间！');
        e.clearSelection();
    });
});
</script>