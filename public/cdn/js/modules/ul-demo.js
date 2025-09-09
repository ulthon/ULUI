
(function($) {
    'use strict';

    $.fn.ulDemo = function() {
        if (typeof window.DEMO_INDEX === 'undefined') {
            window.DEMO_INDEX = 0;
        }

        return this.each(function() {
            var $container = $(this);
            // 查找容器自身或其后代中包含'ul-demo'类名的元素
            var $elements = $container.find('[class*="ul-demo"]').addBack('[class*="ul-demo"]');

            $elements.each(function() {
                var $el = $(this);
                // 检查是否已经有 n* 类的编号，避免重复添加
                if (!/n\d+/.test($el.attr('class'))) {
                    $el.addClass('n' + ((window.DEMO_INDEX % 9) + 1));
                    window.DEMO_INDEX++;
                }
            });
        });
    };

})(jQuery);
