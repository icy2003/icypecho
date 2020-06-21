<?php if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
?>

<?php function threadedComments($comments, $options)
{
    $commentClass = '';
    $group = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $group = '博主';
            $commentClass .= ' comment-by-author'; //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $group = '';
            $commentClass .= ' comment-by-user'; //如果是评论作者的添加 .comment-by-user 样式
        }
    }
    ?>

<li id="li-<?php $comments->theId();?>" class="comment-body<?php
if ($comments->levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
    ?>">
    <div id="<?php $comments->theId();?>" class="comment-txt-box" name="<?php $comments->theId();?>">
        <div class="comment-row">
            <div class="comment-avatar">
                <?php echo getPortrait($comments) ?>
            </div>
            <div class="comment-right">
                <strong>
                    <?php $comments->author();?>
                    <span class="layui-badge"><?php echo $group; ?></span>
                    <?php echo getPermalinkFromCoid($comments->parent); ?>
                    <span class="comment-time"><?php $comments->date();?></span>
                </strong>
                <div class="t-s">
                    <p><?php $comments->content();?></p>
                </div>
            </div>
        </div>
        <div class="comment-reply">
            <?php $comments->reply();?>
        </div>
    </div>
    <?php if ($comments->children) {?>
    <div class=" pl-list comment-children">
        <?php $comments->threadedComments($options);?>
    </div>
    <?php }?>
</li>

<?php }?>



<div id="comments">
    <?php $this->comments()->to($comments);?>

    <?php if ($this->allow('comment')): ?>
    <div id="<?php $this->respondId();?>" class="respond">
        <div class="cancel-comment-reply">
            <?php $comments->cancelReply();?>
        </div>
        <form method="post" action="<?php $this->commentUrl()?>" id="comment-form" role="form">
            <?php if ($this->user->hasLogin()): ?>
            <div class="layui-form-item">
                <div class="layui-form-mid layui-word-aux">
                    <?php _e('登录身份: ');?>
                    <a href="<?php $this->options->profileUrl();?>"><?php $this->user->screenName();?></a>
                    <a href="<?php $this->options->logoutUrl();?>" title="Logout"><?php _e('退出');?> &raquo;</a>
                </div>
            </div>
            <div class="layui-form-item">
                <textarea rows="5" cols="30" name="text" id="textarea"
                    placeholder="<?php echo randomWords('placeholder') ?>" class="layui-textarea" required></textarea>
            </div>
            <?php else: ?>
            <div class="layui-form-item">
                <textarea rows="5" cols="30" name="text" id="textarea"
                    placeholder="<?php echo randomWords('placeholder') ?>" class="layui-textarea" required></textarea>
            </div>
            <div class="layui-form-item layui-row layui-col-space5">
                <div class="layui-col-md4">
                    <input type="text" name="author" id="author" class="layui-input" placeholder="* 敢问带佬尊姓带名"
                        value="<?php $this->remember('author');?>" required />
                </div>
                <div class="layui-col-md4">
                    <input type="email" name="mail" id="mail" lay-verify="email" class="layui-input"
                        placeholder="<?php if ($this->options->commentsRequireMail): ?>* <?php endif;?>邮箱会保密，用于接收回复邮件"
                        value="<?php $this->remember('mail');?>"
                        <?php if ($this->options->commentsRequireMail): ?>required<?php endif;?> />
                </div>
                <div class="layui-col-md4">
                    <input type="url" name="url" id="url" lay-verify="url" class="layui-input"
                        placeholder="<?php if ($this->options->commentsRequireURL): ?>* <?php endif;?><?php _e('https://带佬的藏身处');?>"
                        value="<?php $this->remember('url');?>"
                        <?php if ($this->options->commentsRequireURL): ?>required<?php endif;?> />
                </div>
            </div>
            <?php endif;?>
            <div class="layui-inline">
                <button type="submit" class="layui-btn layui-btn-normal"><?php _e('提交评论');?></button>
            </div>
        </form>
    </div>
    <?php if ($comments->have()): ?>
    <br />
    <h3><?php $this->commentsNum(_t('暂无评论'), _t('唉呀 ~ 仅有一条评论'), _t('已有 %d 条评论'));?></h3>
    <br />
    <div class="pinglun">
        <?php if ($this->commentsNum): ?>
        <?php $comments->listComments();?>
        <?php endif;?>
    </div>
    <div class="page-navigator">
        <?php $comments->pageNav('«', '»', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'layui-laypage layui-laypage-molv', 'itemTag' => '', 'currentClass' => 'current'));?>
    </div>
    <?php endif;?>
    <?php else: ?>
    <h3><?php _e('评论已关闭');?></h3>
    <?php endif;?>
</div>