(function($) {
    'use strict';

    $.fn.ulTab = function(options) {
        // 默认配置
        var settings = $.extend({
            itemClass: '.ul-tab-item',
            paneClass: '.ul-tab-pane',
            activeClass: 'active',
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
                var $currentItem = $(this);
                var index = $tabItems.index($currentItem);

                // 切换选项卡的激活状态
                $currentItem.addClass(settings.activeClass).siblings().removeClass(settings.activeClass);

                // 切换内容面板的显示状态
                if ($tabPanes.length > index) {
                    $tabPanes.eq(index).addClass(settings.showClass).siblings().removeClass(settings.showClass);
                }
            });
        });
    };

})(jQuery);