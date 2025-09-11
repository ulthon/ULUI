
本栅格系统是基于 Flexbox 的响应式 12 列布局系统，旨在快速、轻松地创建各种页面布局。

#### 1. 基础栅格

通过 `.ul-row` 和 `.ul-col-*` 组合来创建基础的栅格布局。列（`.ul-col-*`）必须是行（`.ul-row`）的直接子元素。

- `.ul-row`: 行容器。
- `.ul-col-*`: 定义列宽，`*` 的取值范围为 1 到 12。

**示例：**
```html
<!-- 三个等宽的列 -->
<div class="ul-row">
    <div class="ul-col-4">...</div>
    <div class="ul-col-4">...</div>
    <div class="ul-col-4">...</div>
</div>
```

#### 2. 响应式栅格

系统预设了多个响应式断点（如 `xs`, `sm`, `md`, `lg`），允许您为不同屏幕尺寸指定不同的列宽。

- `.ul-col-{breakpoint}-*`: 在特定断点及以上宽度生效。

**示例：**
```html
<!-- 在小屏幕(sm)上每行2个，中等屏幕(md)上每行3个 -->
<div class="ul-row">
    <div class="ul-col-sm-6 ul-col-md-4">响应式列</div>
    <div class="ul-col-sm-6 ul-col-md-4">响应式列</div>
    <div class="ul-col-sm-6 ul-col-md-4">响应式列</div>
</div>
```

#### 3. 列偏移

使用 `.ul-col-offset-*` 或响应式的 `.ul-col-offset-{breakpoint}-*` 可以将列向右偏移指定的列数。

**示例：**
```html
<div class="ul-row">
    <div class="ul-col-4">...</div>
    <!-- 在中等屏幕(md)及以上向右偏移4列 -->
    <div class="ul-col-4 ul-col-offset-md-4">...</div>
</div>
```

#### 4. 列间距

在行容器 `.ul-row` 上添加 `.ul-col-space-*` 类来为该行下的所有列创建水平间距。

**示例：**
```html
<!-- 列之间有 16px 的间距 -->
<div class="ul-row ul-col-space-16">
    <div class="ul-col-4">...</div>
    <div class="ul-col-4">...</div>
    <div class="ul-col-4">...</div>
</div>
```

#### 5. Flex 布局与对齐

由于栅格基于 Flexbox，您可以在 `.ul-row` 上使用 Flex 对齐类来控制列的排列方式。

- `.ul-justify-start`: 从开始处对齐（默认）
- `.ul-justify-center`: 居中对齐
- `.ul-justify-end`: 从结尾处对齐
- `.ul-justify-space-between`: 两端对齐，项目之间的间隔都相等
- `.ul-justify-space-around`: 每个项目两侧的间隔相等

**示例：**
```html
<!-- 列在行内水平居中 -->
<div class="ul-row ul-justify-center">
    <div class="ul-col-3">...</div>
    <div class="ul-col-3">...</div>
</div>
```