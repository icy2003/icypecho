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
                    <h4><a href="javascript:;" onclick="toWatson()" id="btnText">坚持要向前走</a></h4>
                    <h4 id="showText"></h4>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
function toWatson() {
    var words = [
        '如果我生命的旅程到今夜为止，我也可以问心无愧地视死如归。由于我的存在，伦敦的空气得以清新。',
        '首先要把一切不可能的事实都排除，那其余的，不管多么离奇，多么难以置信，也必然是无可辩驳的事实。',
        '既然在道义上是正当的，那么我要考虑的只有个人风险的问题。如果一个女士迫切需要帮助，一个绅士不应过多考虑个人安危。',
        '你说我们是围绕太阳走，可即使是围着月亮走，这对我和我的工作也不会有什么影响。',
        '如果你对一千个案子的细节了解得如数家珍，而不能破解第一千零一个案子的话，那就怪了。',
        '笨蛋虽笨，但还有更笨的人为他们鼓掌。',
        '了解这件事是比较容易的，可是要说明我怎样了解它的，却不是那么简单。',
        '戴上你的帽子。',
        '广告上用了你的名字。如果用我自己的名字，这些笨蛋侦探中有些人也许就会识破，他们就要从中插手了。',
    ];
    var jokes = [
        '亲爱的华生，告诉过你别再往前了。',
        '这里有两粒药丸，亲爱的，你要不要来一颗？',
        '我原谅你的无知，但请别再继续前进了。',
        '你问我人头？我不放冰箱放哪里？它可是刚从医院弄来的珍贵标本！',
        '啦啦啦啦啦，华生，你不介意我拉小提琴的时候唱歌吧？',
        '没想到吧华生，我还没死呢~',
    ];
    document.getElementById('showText').innerText = words[Math.floor(Math.random() * words.length)];
    document.getElementById('btnText').innerText = jokes[Math.floor(Math.random() * jokes.length)];
}
</script>

</html>