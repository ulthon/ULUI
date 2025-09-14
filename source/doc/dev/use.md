> 注意，组件的css使用了页面root的css变量，如果复制组件的话，需要复制以下内容

```css
{php}echo file_get_contents(app()->getRootPath().'source/scss/_root.scss');{/php}
```
> 注意，组件的scss使用了大量的基础变量，如果打算复制scss的话，还需要复制以下内容

```scss
{php}echo file_get_contents(app()->getRootPath().'source/scss/_common.scss');{/php}
```