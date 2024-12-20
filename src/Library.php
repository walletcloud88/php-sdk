<?php
namespace phpsdk;

class Library
{
    private $config = [
        'app_id' => 'n9ju2hz36v8owi5c',                 // 商户号（后台获取）
        'host' => 'https://testapiv1.walletcloudpro.com/',        // api接口域名，/结尾
        'version' => '1.0',             // 版本号
        'time' => '',                   // 时间戳（秒）
        'key_version' => '',            // 默认为空，risk - 风控、query - 查询
        'lang' => 'cn',                 // 默认为cn，仅支持，cn - 中文、en - 英文

        // 自己的私钥，对应公钥需要绑定至商户后台
        'private_key' => '-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDyZ7T5XrIlekqk
KcTeiyBkyXMXmz9oPJkW6r9Y3CDGnkII8Qk3P5WUZj0WKZLLdupySZUY/o5HntNg
Jpj+SU4gJdgM4oVclPm2JF/moSTkIRjqR5bBEIl41r1nnuyTWx4lAVbj40BXXnrj
PWMFhOO2jFsXdazMbSeUfJA/Ok8EFmyfEvgUMOftxKo76xO39rplSY4QsFEdxWJ+
E2J0CsaxyGdqjBrJOwKqMW4qrQMm/QQpFUvZqVZs6WzLF4agUZdgtBkDRf4L44N4
ALJyBAhbmiRBrZU/35wAOATDfDS2vCZe1k/HQHCF0P+vHfTs9WhZJnJj1bL/XQIM
JYgjv67DAgMBAAECggEABIb7Ukz6dsi57Cb7jkx65mb8x0wW+xNmqI7p0/cIha0e
/pvB2E5PtN3T9j4Ah9xItKm7JyRZ8+x7dihCYz1rQB500ojIhNojb8tuHxiTX89e
b8G2hxSP/LnF/9FwCbCB9572yHrOENOq5+OVndzFg/tLGD0SZR8ExjktWID2SNU5
E9oJUKIxBG2Ngxvbsp0vNKfZTWDtSJB40c0WKsRVpNvdW5h7feJ02HLuYxC6VHEo
COLUVq+MqCGlnDXdvL3wIFmy/unjV5SNHUUj7ewkjeXK6Yq1AbkQj/waz8/iUzwW
cjqz5dN1E6EbibFNYOorMNBW9QDeRmpGJUHtt+vzwQKBgQD8ADu2B5qiO73dE3Fq
8jQ8wzMKkOBAfncj29Z1lvXEqZHKspBhaPR0jq5jPEc7mJfuM/lQbYX6FVYg6+6F
EbiooIVMxn8nKCZ7YIUsgyENyusndo99Eg8UC86sUki7OPwG6KFJiwssf4vtoLfk
pICtJDyi/x6AktH2/TvVi6rkFQKBgQD2QH1/ZjThl43sz4JGX4KHSZsfr96RJaGd
h+eZO+5wNr9Z50jh394+2/oVY7T2/3GI+zP8x1ngl4MJZEoQEgL/1znPdKTnUITV
g8TkqkUuAfhwYjQmT66Wy0dL6RuaTY8/msb8Fdv6mDfb7Zh0NiU7a2QAeNShAVfk
rC2tL/5FdwKBgQCqZhH6PVwPlWwGAG6xzUMLT0bFPz+T/K/dHHsAmmpnZ+4AbQv6
AjlCU3SR/6F/J+icFqLgAp8Ugrbxnfd0HY6K37gjORmjxZ93z8VdWvHP3MVzstTF
0p9Fg9JlbWJmztqEZWsiSpXsqfZZYVLXlXC5IwaphO8AK8c0RvndpQqSHQKBgQCg
04mjFOtgkoycpwHcWDB1jvsC/OeNQFiG++WkTGHzY64hV05gRsdtoll4csATuM07
u2Q+qSvn5Mwt7BP63uiaksQs229/qzS2BfMnrJS18Y+CRoDsrInH7kdIKpxecF0o
GzvuE5Cx34xL1KcG7v3uCrsrG78y0B/JNzI1s+yLDQKBgQCpvY470aQWfwTs+7eq
g8VM199esPqY8RtVdLqhEYjVu24MagtnvL5U3IAmtRSNJrZHMZUwCM8SRrWXnV0D
zn4wcMRn6KCqMbVUGyEdABeacLM331EJQxXAFvdsRH+aSlGFplSrrBVs4MFEIkpi
K9MhcJ1mweP8rixPkPMPXRUCdg==
-----END PRIVATE KEY-----',

        // 商户的公钥，用于响应数据验签
        'platform_public_key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoC4UX20Yqs1qT6IOlKSp
wQntX6iYSUYsChFhfoULQZZpYDLGaBrIvEaAVCpGzG3rBGy6F0914ml/YioRS9CV
eBE4Y+2C2iquDHu6pfSG2Cspf0VbSY1Tu09/JFFlHgpVkpdhDv33GgApriBBMb7p
XORyuZwLpIb90M6NBPlP5OHRAHE/wVd/UGhvmOE5CmoNnGLZCdm8jdrD9CS+PLHn
UD8Hr2x2q6hHgc5O/0JB3bwgMJWlL2588w1U7DKI3VSAjssk4Qu+RdoKG7dXDYGB
u+uKKoDob9wl/JePDpCvfbKEOIZlf1q723n1kYRxTfMAfEJl1TTsQzEpC1PvtmTe
/QIDAQAB
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