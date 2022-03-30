# layui-ul

### 介绍
ulthon扩展的layui样式库.

如今移动端有很多丰富的ui库,但是pc端好用的ui库有那么少,layui本身也很好用,但是样式库实在是太少.

这个项目里面会集成很多设计好的样式库,引用样式,复制可用.


### 主要用处

- 实现原始的样式组件库(而不是vue/angular之类的组件主题)
- 收藏主流的JS插件
- 使用了部分layui的样式,但是大部分组件不依赖layui.
- 依赖layui的部分也很容易替换掉(使用layui的按钮/颜色之类样式).
- 不限制开发终端,只要支持css的都可以使用(vue,angular,uni,小程序都可以)

### 使用说明

只需要引入文件即可:
```
//layui.ulthon.com/cdn/layui-ul.css

比如:
<link rel="stylesheet" href="//layui.ulthon.com/cdn/layui-ul.css">
```
> 最近刚刚做了一个vue+elementui的项目,使用了这个样式库,没有任何不适

全部文档网站 http://layui.ulthon.com/

### 部分组件展示

[![gmyXDS.png](https://z3.ax1x.com/2021/05/03/gmyXDS.png)](https://imgtu.com/i/gmyXDS)
[![gmyINd.png](https://z3.ax1x.com/2021/05/03/gmyINd.png)](https://imgtu.com/i/gmyINd)
[![gmyH3t.png](https://z3.ax1x.com/2021/05/03/gmyH3t.png)](https://imgtu.com/i/gmyH3t)

### 收藏组件

[![gm6rqS.png](https://z3.ax1x.com/2021/05/03/gm6rqS.png)](https://imgtu.com/i/gm6rqS)

### 开发说明

本站是一个基于ulthon_admin的官网项目,有关样式的代码在`source/scss`目录下.

关于样式组件,目前开始使用`scss`重构开发.

推荐使用vscode开发,安装`Live Sass Compiler`扩展并启用以下配置:
在项目目录下创建配置文件`.vscode/settings.json`;
```
{
    "liveSassCompile.settings.formats": [
        {
            "format": "compressed",
            "extensionName": ".min.css",
            "savePath": "/public/cdn/"
        },
        {
            "format": "expanded",
            "extensionName": ".css",
            "savePath": "/public/cdn/"
        },
    ]
}
```

#### 运行站点

本站是基于ulthon_admin开发的,它是ThinkPHP6的项目,你需要掌握相关基础才行.实际上是一个CMS站点.

> 如果你只希望修改组件样式的话,只关注`source/scss`目录下的文件就可以了

```
git clone https://gitee.com/ulthon/layui-ul.git

cd layui-ul

composer install

php think migrate:run

php think seed:run

php think run

```
此时可以访问:127.0.0.1:8000



### 参与贡献

1.  在issue提交你想要的样式截图,过段时间没准就有了

