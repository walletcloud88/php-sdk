### 基础参数配置
```
// 基础配置，包括公共传参
$config = [
        'app_id' => '',                 // 商户号（后台获取）
        'host' => 'https://xxx.com/',    // api接口域名，/结尾
        'version' => '1.0',             // 版本号
        'time' => '',                   // 时间戳（秒）
        'key_version' => '',            // 默认为空，risk - 风控、query - 查询
        'lang' => 'cn',                 // 默认为cn，仅支持，cn - 中文、en - 英文

        // 自己的私钥，对应公钥需要绑定至商户后台
        'private_key' => '-----BEGIN PRIVATE KEY-----
XXXXX
XXXXX
-----END PRIVATE KEY-----',

        // 商户的公钥，用于响应数据验签
        'platform_public_key' => '-----BEGIN PUBLIC KEY-----
XXXX
XXXX
-----END PUBLIC KEY-----',
    ]
```
* RSA公私钥获取平台：https://www.metools.info/code/c80.html
* 密钥长度：2048 bit 
* 密钥格式：PKCS#8
* 私钥密码：无

### 初始化接口
```
$library = new \phpsdk\Library($config);
```

### 使用例子
```
// 地址验证接口，具体参数，参考文档
$data = [
    "coin" => "trx",
    "address" => "TKB8uYE5sdC5ExuWNtZxVa8MK8HH6E96Ud",
];
$result = $library->_class("Address")->verifyAddress($data);

```