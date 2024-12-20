<?php
namespace phpsdk;

class Library
{
    private $config = [
        'app_id' => '',                 // 商户号（后台获取）
        'host' => 'https://xxx.com/',   // api接口域名，/结尾
        'version' => '1.0',             // 版本号
        'time' => '',                   // 时间戳（秒）
        'key_version' => '',            // 默认为空，risk - 风控、query - 查询
        'lang' => 'cn',                 // 默认为cn，仅支持，cn - 中文、en - 英文

        // 自己的私钥，对应公钥需要绑定至商户后台
        'private_key' => '-----BEGIN PRIVATE KEY-----
xxx
xxx
-----END PRIVATE KEY-----',

        // 商户的公钥，用于响应数据验签
        'platform_public_key' => '-----BEGIN PUBLIC KEY-----
xxx
xxx
-----END PUBLIC KEY-----',
    ];

    private $_class;

    /**
     * Pay constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
        // 默认时间戳
        if(!$this->config['time']){
            $this->config['time'] = time();
        }
    }

    /**
     * 指定操作类
     * @param string $name
     * @return ClassInterface
     */
    public function _class($name = 'open')
    {
        return $this->_class = $this->createClass($name);
    }

    /**
     * 创建操作网关
     * @param string $gateway
     * @return mixed
     */
    protected function createClass($name)
    {
        if (!file_exists(__DIR__ . '/module/'. ucfirst($name) . '.php')) {
            throw new \Exception("Class [$name] is not supported.");
        }
        $gateway_class = __NAMESPACE__ . '\\module\\' . ucfirst($name) ;

        return new $gateway_class($this->config);
    }
}