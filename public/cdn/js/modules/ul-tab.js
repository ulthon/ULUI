(function(window, $) {
    'use strict';

    /**
     * 核心 Tab 初始化函数
     * @param {HTMLElement} tabElement - Tab 容器的 DOM 元素
     * @param {object} options - 配置选项
     */
    var ulTab = function(tabElement, options) {
        // 默认配置
        var settings = Object.assign({
            itemClass: '.ul-tab-item',
            paneClass: '.ul-tab-pane',
            activeClass: 'ul-this',
            showClass: 'ul-show'
        }, options);

        // 查找当前 tab 实例下的元素，并排除嵌套 tab 中的元素
        var tabItems = Array.from(tabElement.querySelectorAll(settings.itemClass)).filter(function(item) {
            return item.closest('.ul-tab') === tabElement;
        });
        var tabPanes = Array.from(tabElement.querySelectorAll(settings.paneClass)).filter(function(pane) {
            return pane.closest('.ul-tab') === tabElement;
        });

        tabItems.forEach(function(item, index) {
            item.addEventListener('click', function() {
                // 切换选项卡的激活状态
                tabItems.forEach(function(it) { it.classList.remove(settings.activeClass); });
                this.classList.add(settings.activeClass);

                // 切换内容面板的显示状态
                tabPanes.forEach(function(pane) { pane.classList.remove(settings.showClass); });
                if (tabPanes[index]) {
                    tabPanes[index].classList.add(settings.showClass);
                }
            });
        });
    };

    // 暴露到全局作用域
    window.ulTab = ulTab;

    // 如果 jQuery 存在，则注册为插件
    if ($) {
        $.fn.ulTab = function(options) {
            return this.each(function() {
                ulTab(this, options);
            });
        };
    }

})(window, window.jQuery);