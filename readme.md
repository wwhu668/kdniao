# 集成快递鸟 API

目前提供 `查询物流接口`

## 安装

1. 安装包
    >$ composer require wwhu/kdniao

3. 创建配置文件
    >$ php artisan vendor:publish --provider="Wwhu\Kdniao\KdniaoServiceProvider"

3. 在 `config/app.php` 文件 `$providers` 数组中添加服务
    > Wwhu\Kdniao\KdniaoServiceProvider::class,

4. 在 `config/app.php` 文件 `$aliases` 数组中添加别名
    > 'Kdniao' => Wwhu\Kdniao\Facades\Kdniao::class,


## 使用
获取物流对应代号
```php
\Kdniao::getCode('顺丰');// 物流名称须在 `kdniao.php` 配置文件 `codes` 数组中
```

查询物流踪迹

```php
$LogisticCode = '23423422332', // 物流单号
$ShipperCode = 'SF', // \Kdniao::getCode('顺丰'); //物流公司代号

\Kdniao::getOrderTraces($LogisticCode, $ShipperCode);
```
