(function($) {
    $.fn.ulTab = function(options) {
        // 默认配置
        var settings = $.extend({
            itemClass: '.ul-tab-item',
            paneClass: '.ul-tab-pane',
            activeClass: 'ul-this',
            showClass: 'ul-show'
        }, options);

        return this.each(function() {
            var $tab = $(this);

            // 查找当前 tab 实例下的元素，并排除嵌套 tab 中的元素
            var $tabItems = $tab.find(settings.itemClass).filter(function() {
                return $(this).closest('.ul-tab').is($tab);
            });
            var $tabPanes = $tab.find(settings.paneClass).filter(function() {
                return $(this).closest('.ul-tab').is($tab);
            });

            $tabItems.on('click', function() {
                var $this = $(this);
                // 获取当前点击项在符合条件的集合中的索引
                var index = $tabItems.index($this);

                // 切换选项卡的激活状态
                $this.addClass(settings.activeClass).siblings().removeClass(settings.activeClass);

                // 切换内容面板的显示状态
                $tabPanes.eq(index).addClass(settings.showClass).siblings().removeClass(settings.showClass);
            });
        });
    };
})(jQuery);