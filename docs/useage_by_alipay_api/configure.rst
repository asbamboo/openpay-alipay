作为支付宝支付的接口处理库使用(配置)
==========================================================

asbamboo/openpay-alipay作为支付宝支付的接口处理库使用时，需要使用asbamboo\\helper\\env\\Env::set("变量名", "变量值") 方法设置必要的环境变量。

应该设置的环境变量名被声明在asbamboo\\openpayAlipay\\Env 类中。

:OPENPAY_ALIPAY_GATEWAY_URI: 请求支付宝接口的网关url。
:OPENPAY_ALIPAY_RSA_PRIVATE: 生成支付宝请求参数sign，使用的秘钥文件（SHA256withRsa）。
:OPENPAY_ALIPAY_RSA_ALIPAY: 验证支付宝响应参数sign，使用的支付宝公钥文件（SHA256withRsa）。
:OPENPAY_ALIPAY_APP_ID: 支付宝应用app_id。

支付宝秘钥说明请查看：https://alipay.open.taobao.com/doc2/detail?treeId=200&articleId=105310&docType=1

环境变量设置示例：

::

    <?php
    use asbamboo\helper\env\Env AS EnvHelper;
    use asbamboo\openpayAlipay\Env AS AlipayEnv;

    ...
    
    // 支付宝网关
    EnvHelper::set(AlipayEnv::ALIPAY_GATEWAY_URI, 'https://openapi.alipaydev.com/gateway.do');
    // 自己生成支付宝rsa私银文件
    EnvHelper::set(AlipayEnv::ALIPAY_RSA_PRIVATE_KEY, dirname(__DIR__) . '/alipay-rsa/app_private_key.pem');
    // 支付宝生成支付宝rsa公银文件
    EnvHelper::set(AlipayEnv::ALIPAY_RSA_ALIPAY_KEY, dirname(__DIR__) . '/alipay-rsa/app_alipay_key.pem');
    // 支付宝app id
    EnvHelper::set(AlipayEnv::ALIPAY_APP_ID, 'xxxxxxxxxxxxxxxxx');

    ...    