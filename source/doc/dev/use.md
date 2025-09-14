> 注意，组件的css使用了页面root的css变量，如果复制组件的话，需要复制以下内容

```css
{php}echo file_get_contents(app()->getRootPath().'source/scss/_root.scss');{/php}
```
> 注意，组件的scss使用了大量的基础变量，如果打算复制scss的话，还需要复制以下内容

```scss
{php}echo file_get_contents(app()->getRootPath().'source/scss/_common.scss');{/php}
```

## 关于JS

一些组件需要配合js使用，我们推荐您使用顺手的框架实现基本的交互功能，比如jquery,vue,htmx等。

本站使用jQuery封装了一些插件，在相关组件中有介绍，可以直接根据说明使用。

本站主要提供组件样式，js部分也仅是为了展示效果。比如标签页组件，我们只实现了点击切换的功能，如果需要拖拽排序，关闭等功能，需要寻找其他专业的插件来实现。

## 关于图片

ULUI提供了各种类型的示例图片，所有图片资源来源 https://pixabay.com ，都是免版税资源，无需授权。具体政策参考：https://pixabay.com/zh/service/license-summary/ 。

但本站不保证图片的长期有效性，如果您需要长期使用，建议自行下载并托管。