> 好看的图片让系统更有档次。

ULUI提供了各种类型的示例图片，所有图片资源来源 https://pixabay.com ，都是免版税资源，无需授权。具体政策参考：https://pixabay.com/zh/service/license-summary/ 。

使用方法非常简单，只需要增加对应类型的类名即可，比如：`class="ul-demo-view"`，会显示风景图片。

ULUI还提供了n1-n9的编号，用于展示不同的图片。可以使用ULUI提供的内置方法自动追加编号。
```javascript
<script src="//ului.top/cdn/js/jquery-3.7.1.min.js"></script>
<script src="//ului.top/cdn/js/modules/ul-demo.js"></script>
<script>
    $(function () {
        $('.ul-tab').ulDemo();
    });
</script>
```


ul-demo.js的代码如下：

```javascript
{php}echo file_get_contents(app()->getRootPath().'/public/cdn/js/modules/ul-demo.js');{/php}

```