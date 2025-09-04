ul-tab是一个典型的交互组建，纯css样式是没有意义的。ului库提供了一个基本的jquery插件来实现tab的交互功能，用户也可以根据自己的需求来编写js代码实现交互功能。

如果是基本的交互功能，无论是vue、htmx等前端框架，还是原生js，都能很容易地编写。

对于ului来说，可以通过以下方式来实现tab的交互功能。

1. 引入jquery和ului的js文件
2. 选中tab组件的最外层容器并调用ulTab方法

```html
<script src="//ului.top/cdn/js/jquery-3.7.1.min.js"></script>
<script src="//ului.top/cdn/js/modules/ul-tab.js"></script>
<script>
    $(function () {
        $('.ul-tab').ulTab();
    });
</script>
```

ul-tab.js的代码如下：

```javascript
{php}echo file_get_contents(app()->getRootPath().'/public/cdn/js/modules/ul-tab.js');{/php}

```