<?php

use icy2003\php\I;
use icy2003\php\iapis\QQ;
use icy2003\php\ihelpers\Arrays;
use icy2003\php\ihelpers\Strings;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

// 统计阅读数
function get_post_view($archive)
{
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}

// 获取附件图片
function thumb($obj)
{
    ob_start();
    $obj->title();
    $title = ob_get_contents();
    ob_end_clean();
    $title = Strings::partAfter($title, '】') ?: $title;
    if ($obj->hidden) {
        return $title;
    } else {
        $attach = $obj->attachments(1)->attachment;
        if (isset($attach->isImage) && $attach->isImage == 1) {
            return "<img src='{$attach->url}' class='img-full'>";
        } else {
            return $title;
        }
    }
}

// 留言加@
function getPermalinkFromCoid($coid)
{
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    if (empty($row)) {
        return '';
    }

    return '<a href="#comment-' . $coid . '">@' . $row['author'] . '</a>';
}

// 主题设置
function themeConfig($form)
{
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', null, null, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 可以在网站标题前加上一个 LOGO'));
    $form->addInput($logoUrl);
}

function motto()
{
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('slug = ?', 'motto')
    );
    $poems = $result[0]['text'];
    $poems = explode("~", $poems); /* ~ 为分隔符*/
    return trim($poems[rand(0, count($poems) - 1)]);
}

function getPortrait($comments, $size = 40)
{
    if ($comments->options->commentsAvatar && 'comment' == $comments->type) {
        $rating = $comments->options->commentsAvatarRating;
        $plugged = false;
        $comments->pluginHandle(__CLASS__)->trigger($plugged)->gravatar($size, $rating, '', $comments);
        if (!$plugged) {
            $url = Typecho_Common::gravatarUrl($comments->mail, $size, $rating, '', $comments->request->isSecure());
            if ($qqNumber = Strings::partBefore($comments->mail, '@qq.com')) {
                $qq = new QQ($qqNumber);
                $qq->fetchInfo(['spec' => 1]);
                $url = $qq->getResult('portrait');
            }
            $maps = Arrays::column(include './data/links.php', 'portrait', 'email');
            if( $temp = I::get($maps, $comments->mail)){
                $url = $temp;
            }
            return '<img class="avatar" src="' . $url . '" alt="' .
            $comments->author . '" width="' . $size . '" height="' . $size . '" />';
        }
    }
}