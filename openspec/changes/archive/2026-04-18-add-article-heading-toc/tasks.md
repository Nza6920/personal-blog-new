## 1. Topic Detail Template

- [x] 1.1 在 `resources/views/topics/index.blade.php` 中为章节目录预留容器，并补充目录与激活态所需样式
- [x] 1.2 调整正文标题展示结构，确保客户端可以为一级标题注入唯一锚点且无标题时隐藏目录区域

## 2. Frontend Interaction

- [x] 2.1 在文章详情页脚本中扫描 `.topic-body h1`，生成目录项并为标题分配稳定唯一的锚点 `id`
- [x] 2.2 实现目录点击跳转、URL hash 对齐与 `IntersectionObserver` 驱动的当前章节高亮逻辑

## 3. Verification

- [x] 3.1 为详情页补充特性测试，覆盖存在一级标题时的目录渲染和锚点输出
- [x] 3.2 为无一级标题或重复一级标题场景补充验证，确认目录降级与唯一锚点行为符合规格
