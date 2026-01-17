# Laravel 5.5 → 12.11.1 升级记录

> 把一个老朋友从 5.5 搬到 12.11.1, 过程全程借助 codex, 零手写代码(php多年积灰也够呛能写)。
> 
> 模型使用 gpt-5.2-codex
> 
> Token usage: total=255,170 input=228,065 (+ 4,059,264 cached) output=27,105 (reasoning 12,608)
## 目标

把旧的 `personal-blog` 迁移到新的 `personal-blog-new`，保持功能不变，逐步适配 Laravel 12。

## 过程纪要

### 1) 新建12.x项目模板

选择 Laravel 12.11.1 的全新骨架作为承载点，保持目录结构与默认配置。

### 2) 迁移核心代码

- 路由改为类路由写法
- 控制器、请求、观察者、Handlers 直接迁移并做少量适配
- helpers 使用 `Str::limit()` 和 `Str::random()` 替换旧函数
- `HashIdHelper` 兼容新版本的 `resolveRouteBinding` 签名

### 3) 模型与数据库层

- `$dates` 改为 `$casts`
- topics 表迁移为新的 class-based migration
- 用户表补上 `avatar` 字段
- 工厂/种子升级为 12.x 的 class 结构

### 4) 视图与静态资源

保持原有 `asset()` 方式与 public 资源结构，先保证页面能稳定跑起来：

- views 全量迁移
- public 下 css/js/fonts/uploads 迁移
- resources/assets 迁移（暂不切 Vite）

### 5) 依赖与配置

迁移并补齐配置文件：

- `config/purifier.php`
- `config/hashids.php`

修复：

- Hashids `length` 必须是 int，不能是字符串

## 遇到的问题

1) **sessions 表不存在**
   - 因为 `SESSION_DRIVER=database`，需要运行 `php artisan session:table` + `php artisan migrate`

2) **Hashids 类型错误**
   - 配置里 `length` 误写为字符串，导致 `TypeError`

# codex plan 如下

---

## Migration Plan (Laravel 12.11.1)

## Goals
- Move the current Laravel 5.5 codebase into the Laravel 12.11.1 skeleton in `personal-blog-new`.
- Keep behavior consistent while updating deprecated APIs and packages.
- Establish a stable, repeatable local dev environment.

## Phases
1. Use the existing Laravel 12.11.1 scaffold in `personal-blog-new/`.
2. Port core PHP code: routes, controllers, models, requests, observers, helpers.
3. Migrate database layer: migrations, seeders, factories (class-based).
4. Update dependencies: replace/remove deprecated packages, align with PHP 8.2+.
5. Migrate views and assets; decide on Vite vs. keeping Mix.
6. Validate features: manual checks + tests.

## Key Files to Update
- `routes/web.php`
- `app/Http/Controllers/*`
- `app/Models/*`, `app/Models/Traits/*`
- `app/Observers/*`
- `app/Handlers/*`
- `bootstrap/helpers.php`
- `database/migrations/*`, `database/seeders/*`, `database/factories/*`
- `resources/views/*`, `resources/assets/*`

## Known API Changes
- `str_limit()` -> `Str::limit()`
- `str_random()` -> `Str::random()`
- `$dates` -> `$casts`
- `fideloper/proxy` removed (Laravel 12 has built-in proxies)

## Dependencies to Review
- `mews/purifier`
- `overtrue/laravel-lang`
- `vinkla/hashids`

## Environment Notes
- PHP 8.2+ required for Laravel 12.
- MySQL and Docker compose are available for local dev.

---


