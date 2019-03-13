asbamboo/openpay-alipay
===========================

asbamboo/openpay-alipay 是 `asbamboo/openpay`_ 的一个支付渠道扩展模块。`查看文档`_

安装
---------------------

请根据 `asbamboo/openpay`_ 的说明: https://github.com/asbamboo/openpay/blob/master/docs/install.rst 将asbamboo/openpay-alipay 应用到你的项目上。

参数配置
------------------------

asbamboo\\openpayAlipay\\Env 类中声明的几个常量，是使用 asbamboo//openpay-alipay 必须配置的环境变量。通过asbamboo\\helper\\env\\Env::set("变量名", "变量值") 方法进行设置。

:OPENPAY_ALIPAY_GATEWAY_URI: 请求支付宝接口的网关url。
:OPENPAY_ALIPAY_RSA_PRIVATE: 生成支付宝请求参数sign，使用的秘钥文件（SHA256withRsa）。
:OPENPAY_ALIPAY_RSA_ALIPAY: 验证支付宝响应参数sign，使用的支付宝公钥文件（SHA256withRsa）。
:OPENPAY_ALIPAY_APP_ID: 支付宝应用app_id。

支付宝秘钥说明请查看：https://alipay.open.taobao.com/doc2/detail?treeId=200&articleId=105310&docType=1


需要在 config/openpay-config.php 中配置环境变量：

::

    <?php
    use asbamboo\database\Factory;
    use asbamboo\helper\env\Env AS EnvHelper;
    use asbamboo\openpayAlipay\Env AS AlipayEnv;
    /***************************************************************************************************
     * 环境参数配置
     ***************************************************************************************************/
    // 支付宝网关
    EnvHelper::set(AlipayEnv::ALIPAY_GATEWAY_URI, 'https://openapi.alipaydev.com/gateway.do');
    // 自己生成支付宝rsa私银文件
    EnvHelper::set(AlipayEnv::ALIPAY_RSA_PRIVATE_KEY, dirname(__DIR__) . '/alipay-rsa/app_private_key.pem');
    // 支付宝生成支付宝rsa公银文件
    EnvHelper::set(AlipayEnv::ALIPAY_RSA_ALIPAY_KEY, dirname(__DIR__) . '/alipay-rsa/app_alipay_key.pem');
    // 支付宝app id
    EnvHelper::set(AlipayEnv::ALIPAY_APP_ID, 'xxxxxxxxxxxxxxxxx');
    /***************************************************************************************************/

使用asbamboo/openpay-alipay模块后,交易支付（trade.pay）接口将支持如下渠道（channel字段）
-------------------------------------------------------------------------------------------------------

:ALIPAY_APP: 支付宝APP支付(手机app支付的服务端参数生成接口)
:ALIPAY_PC: 支付宝PC电脑端支付
:ALIPAY_QRCD: 支付宝扫码支付（买家手机扫商户）


.. _asbamboo/openpay: http://www.github.com/asbamboo/openpay
.. _查看文档: docs/index.rst