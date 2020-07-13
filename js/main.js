/**
 * @classDescription 模拟Marquee，无间断滚动内容
 * @author Lyc 修改
 * @DOM
 *  	<div id="marquee">
 *  		<ul>
 *   			<li></li>
 *   			<li></li>
 *  		</ul>
 *  	</div>
 * @CSS
 *  	#marquee {overflow:hidden;width:200px;height:50px;}
 * @Usage
 *  	$("#marquee").kxbdMarquee(options);
 * @options
 *		isEqual:true,		//所有滚动的元素长宽是否相等,true,false
 *  	loop:0,				//循环滚动次数，0时无限
 *		direction:"left",	//滚动方向，"left","right","up","down"
 *		scrollAmount:1,		//步长
 *		scrollDelay:20		//时长
 */
(function($) {
    $.fn.kxbdMarquee = function(options) {
        var opts = $.extend({}, $.fn.kxbdMarquee.defaults, options);

        return this.each(function() {
            var $marquee = $(this); //滚动元素容器
            var _scrollObj = $marquee.get(0); //滚动元素容器DOM
            var scrollW = $marquee.width(); //滚动元素容器的宽度
            var scrollH = $marquee.height(); //滚动元素容器的高度
            var $element = $marquee.children(); //滚动元素
            var $kids = $element.children(); //滚动子元素
            var scrollSize = 0; //滚动元素尺寸

            //滚动类型，1左右，0上下
            var _type = (opts.direction == "left" || opts.direction == "right") ? 1 : 0;

            //防止滚动子元素比滚动元素宽而取不到实际滚动子元素宽度
            $element.css(_type ? "width" : "height", 10000);

            //获取滚动元素的尺寸
            if (opts.isEqual) {
                scrollSize = $kids[_type ? "outerWidth" : "outerHeight"]() * $kids.length;
            } else {
                $kids.each(function() {
                    scrollSize += $(this)[_type ? "outerWidth" : "outerHeight"]();
                });
            };

            //滚动元素总尺寸小于容器尺寸，不滚动
            if (scrollSize < (_type ? scrollW : scrollH)) { return; };

            //克隆滚动子元素将其插入到滚动元素后，并设定滚动元素宽度
            $element.append($kids.clone()).css(_type ? "width" : "height", scrollSize * 2);

            var numMoved = 0;

            function scrollFunc() {
                var _dir = (opts.direction == "left" || opts.direction == "right") ? "scrollLeft" : "scrollTop";
                if (opts.loop > 0) {
                    numMoved += opts.scrollAmount;
                    if (numMoved > scrollSize * opts.loop) {
                        _scrollObj[_dir] = 0;
                        return clearInterval(moveId);
                    };
                };

                if (opts.direction == "left" || opts.direction == "up") {
                    var newPos = _scrollObj[_dir] + opts.scrollAmount;
                    if (newPos >= scrollSize) {
                        newPos -= scrollSize;
                    }
                    _scrollObj[_dir] = newPos;
                } else {
                    var newPos = _scrollObj[_dir] - opts.scrollAmount;
                    if (newPos <= 0) {
                        newPos += scrollSize;
                    };
                    _scrollObj[_dir] = newPos;
                };
            };

            //滚动开始
            var moveId = setInterval(scrollFunc, opts.scrollDelay);

            //鼠标划过停止滚动
            $marquee.hover(function() {
                clearInterval(moveId);
            }, function() {
                clearInterval(moveId);
                moveId = setInterval(scrollFunc, opts.scrollDelay);
            });
        });
    };

    $.fn.kxbdMarquee.defaults = {
        isEqual: true, //所有滚动的元素长宽是否相等,true,false
        loop: 0, //循环滚动次数，0时无限
        direction: "left", //滚动方向，"left","right","up","down"
        scrollAmount: 1, //步长
        scrollDelay: 20 //时长

    };

    $.fn.kxbdMarquee.setDefaults = function(settings) {
        $.extend($.fn.kxbdMarquee.defaults, settings);
    };
})(jQuery);

//-------------------functions

/**
 * 设置一个 cookie
 * @param {string} name cookie 键
 * @param {mixed} value cookie 值
 */
function setCookie(name, value) {
    //设置名称为name,值为value的Cookie
    var expdate = new Date(); //初始化时间
    expdate.setTime(expdate.getTime() + 3600 * 1000); //时间单位毫秒
    document.cookie = name + "=" + value + ";expires=" + expdate.toGMTString() + ";path=/";

    //即document.cookie= name+"="+value+";path=/";  时间默认为当前会话可以不要，但路径要填写，因为JS的默认路径是当前页，如果不填，此cookie只在当前页面生效！
}

/**
 * 获取一个 cookie
 * @param {string}} name cookie 键
 */
function getCookie(name) {
    //判断document.cookie对象里面是否存有cookie
    if (document.cookie.length > 0) {
        var c_start = document.cookie.indexOf(name + "=")
            //如果document.cookie对象里面有cookie则查找是否有指定的cookie，如果有则返回指定的cookie值，如果没有则返回空字符串
        if (c_start != -1) {
            c_start = c_start + name.length + 1
            c_end = document.cookie.indexOf(";", c_start)
            if (c_end == -1) c_end = document.cookie.length
            return unescape(document.cookie.substring(c_start, c_end))
        }
    }
    return null;
}

/**
 * 获取 API 接口返回
 * @param {string} route 路由
 * @param {array} data 参数
 * @param {callback} succ 成功回调
 */
function apiGet(route, data, succ) {
    $.ajax({
        url: 'https://api.icy2003.com/' + route,
        type: 'get',
        data: data,
        success: succ
    })
}

$(document).ready(function() {
    layui.use(['layer', 'element', 'util'], function() {
        var $ = layui.$,
            layer = layui.layer,
            util = layui.util;

        $(".nav-btn").on('click', function() {
            $('.nav-btn dl').toggleClass('layui-show');
        });

        // 1. class="tip" 添加 tip 提示
        // 2. bubble 添加 tip 气泡
        $('.tip').each(function() {
            var bubble = $(this).attr('bubble')
            if (this.title && bubble != undefined) {
                if (bubble == '') {
                    bubble = 'layui-icon-reply-fill'
                }
                $(this).append('<i class="layui-icon ' + bubble + '" style="position: relative;top: -0.5em;color: DeepSkyBlue;"></i>')
                $(this).css("background-color", "LemonChiffon")
            }
        })

        // 3. tip 显示和隐藏
        $(".tip").mouseover(function() {
            if ($.trim(this.title) != '') {
                this.Title = this.title;
                this.title = "";
                layer.tips(this.Title, this, {
                    tips: 3,
                    time: 0,
                });
            }
        }).mouseout(function() {
            if (this.Title != null) {
                this.title = this.Title;
            }
            layer.closeAll()
        })


        // 1. 添加 note 属性，会在侧边出现一个备注
        $('[note]').each(function(index) {
            var note = '<pre>' + $(this).attr('note') + '</pre>',
                switchValue = $(this).attr('switch')
            if (undefined == switchValue) {
                switchValue = 1
            }
            $(this).prepend(`<span class="note" id="note_index_` + index + `">
        <i class="layui-icon layui-icon-reduce-circle" switch="` + switchValue + `"></i>` + note + `</span>`)

            // 2. 默认可选开和关
            if (0 == switchValue) {
                $(this).find('span').css({ "visibility": "hidden" })
                $(this).find('i').addClass("layui-icon-add-circle").removeClass("layui-icon-reduce-circle")
            }
        })

        // 3. 备注展开和隐藏，默认展开
        $('[note] i').click(function() {
            if (1 == $(this).attr('switch')) {
                $(this).parent().css({ "visibility": "hidden" })
                $(this).attr('switch', 0)
                $(this).addClass("layui-icon-add-circle").removeClass("layui-icon-reduce-circle")
            } else {
                $(this).parent().css({ "visibility": "visible" })
                $(this).attr('switch', 1)
                $(this).addClass("layui-icon-reduce-circle").removeClass("layui-icon-add-circle")
            }
        })

        // 4. 鼠标滑过置顶
        $('.note').mouseover(function() {
            $(this).css({ 'z-index': 999 })
        }).mouseout(function() {
            $(this).css({ 'z-index': 1 })
        })

        // 1. class="clipboard" 添加复制文本按钮
        $('.clipboard').each(function() {
            var text = $(this).html().replace(/<[^>]+>/g, "").replace(/(^\s*)|(\s*$)/g, "")
            $(this).prepend('<div style="height: 0"><button type="button" class="layui-btn layui-btn-primary layui-btn layui-btn-sm clipboardBtn" style="position: absolute; right: 0;" data-clipboard-text="' + text + '" data-clipboard-action="copy">复制</button></div>')
        })

        // 2. 背景颜色改变
        var clipboardBackgroundColor = 'none';
        $('.clipboard').mouseover(function() {
            clipboardBackgroundColor = $(this).css('background-color')
            $(this).css('background-color', 'AliceBlue')
        }).mouseout(function() {
            $(this).css('background-color', clipboardBackgroundColor)
        })

        // contents 目录

        var contents = $('.contents')
        if (contents) {
            contents.prepend('<span class="contents-title" switch="1">关闭</span>')
            $('.contents-title').click(function() {
                if (1 == $(this).attr('switch')) {
                    $('.contents ul').hide()
                    $(this).attr('switch', 0)
                    $(this).text('展开')
                } else {
                    $('.contents ul').show()
                    $(this).attr('switch', 1)
                    $(this).text('关闭')
                }
            })
        }

        // tab 框

        $('[tabs]').each(function() {
            $(this).addClass('layui-tab layui-tab-card')
            var tabs = $(this).attr('tabs').split('|'),
                tabString = '',
                contents = $(this).html().split('==='),
                contentString = ''
            $(this).html('')
            tabs.forEach(function(tab, index) {
                if (0 == index) {
                    tabString += '<li class="layui-this">' + tab + '</li>'
                } else {
                    tabString += '<li>' + tab + '</li>'
                }
            })
            contents.forEach(function(content, index) {
                if (0 == index) {
                    contentString += '<div class="layui-tab-item layui-show">' + content + '</div>'
                } else {
                    contentString += '<div class="layui-tab-item">' + content + '</div>'
                }
            })
            $(this).prepend(`<ul class="layui-tab-title">` + tabString + `</ul>
<div class="layui-tab-content">` + contentString + `</div>`)
        })

        // class="clipboardBtn" 复制成功弹窗
        new ClipboardJS('.clipboardBtn').on('success', function(e) {
            layer.msg('成功复制文本！');
            e.clearSelection();
        });

        // 文章图片点击预览(如果为pc端才生效)
        var device = layui.device();
        if (!(device.weixin || device.android || device.ios)) {
            $(".text img").click(function() {
                $.previewImage(this.src);
            });
            $.previewImage = function(src) {
                var img = new Image(),
                    index = layer.load(2, { time: 0, scrollbar: false, shade: [0.02, '#000'] });
                img.style.background = '#fff', img.style.display = 'none';
                img.src = src;
                document.body.appendChild(img), img.onerror = function() {
                    layer.close(index);
                }, img.onload = function() {
                    layer.open({
                        type: 1,
                        shadeClose: true,
                        success: img.onerror,
                        content: $(img),
                        title: false,
                        area: img.width > 1140 ? '1140px' : img.width,
                        closeBtn: 1,
                        skin: 'layui-layer-nobg',
                        end: function() {
                            document.body.removeChild(img);
                        }
                    });
                };
            };
        }

        // 右下角工具箱（返回顶部）
        util.fixbar({
            css: {
                bottom: '15%',
            }
        });

        // 如果是微信浏览器，给出温馨提示
        if (device.weixin) {
            layer.open({
                title: '微信浏览器部分功能不支持哦',
                btn: [],
                offset: 'rt',
                content: '点右上角“...”后“在浏览器打开”获得更好体验'
            });
        }

        // 失去获取焦点时修改标题栏
        var title = document.title
        window.onblur = function() {
            document.title = "∑(っ°Д°;)っ页面崩溃了……"
        }
        window.onfocus = function() {
            document.title = title
        }

        // console 艺术字
        console.log(`%c
    _         ___ ___ ___ ___
   |_|___ _ _|_  |   |   |_  |  ___ ___ _____
   | |  _| | |  _| | | | |_  |_|  _| . |     |
   |_|___|_  |___|___|___|___|_|___|___|_|_|_|
         |___|
   `, 'color: #4fbddf')

        // textarea 自适应高度
        autosize($('textarea'));

        // 防止 iframe 嵌套
        if (window.self.location !== window.top.location) {
            window.top.location = window.self.location;
        }

        // 监听所有锚点链接实现平滑移动
        $('a[href^="#"]').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var hash = decodeURI(this.hash),
                    $target = $(hash);
                if ($target.length) {
                    var targetOffset = $target.offset().top;
                    $('html,body').stop(true).animate({
                            scrollTop: targetOffset
                        },
                        1000);
                    return false;
                }
            }
        })
    });

})