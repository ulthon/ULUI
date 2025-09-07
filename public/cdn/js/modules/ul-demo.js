
(function(window, $) {
    'use strict';

    // 核心函数
    var ulDemo = function(targetElem) {
        if (typeof window.DEMO_INDEX === 'undefined') {
            window.DEMO_INDEX = 0;
        }

        var elements = (targetElem instanceof jQuery ? targetElem[0] : targetElem).querySelectorAll('[class*="ul-demo"]');
        
        elements.forEach(function(el) {
            // 检查是否已经有 n* 类的编号，避免重复添加
            if (!/n\d+/.test(el.className)) {
                el.classList.add('n' + ((window.DEMO_INDEX % 9) + 1));
                window.DEMO_INDEX++;
            }
        });
    };

    // 暴露到全局作用域
    window.ulDemo = ulDemo;

    // 如果 jQuery 存在，则注册为插件
    if ($) {
        $.fn.ulDemo = function() {
            return this.each(function() {
                ulDemo(this);
            });
        };
    }

})(window, window.jQuery);
