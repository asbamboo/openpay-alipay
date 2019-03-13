作为支付宝支付的接口处理库使用
==================================
asbamboo/openpay-alipay作为支付宝支付的接口处理库使用示例
-------------------------------------------------------------

::

    <?php 

        use asbamboo\openpayAlipay\alipayApi\Client;

        ... 

        $alipay_response    = Client::request('TradePrecreate', $request_data);

        if( $AlipayResponse->get('code') == TradePrecreateResponse::CODE_SUCCESS && empty($AlipayResponse->get('sub_code'))

            // 请求成功。
            
        )
            
        ... 

如示例中所示 Client::request 接受两个参数:
-------------------------------------------

#. 第一个参数时接口的名称
    * 去掉支付宝接口名称前缀 "alipay."
    * 以点（"."）分隔接口名称，每个段的首字母大写。
    * 去除接口名称中的点(".")
    * 如alipay.trade.precreate(统一收单线下交易预创建)，在asbamboo/openpay-alipay中接口名称为 TradePrecreate。

#. 第二个参数为请求的参数（alipay文档中biz_content那部分的参数），array 类型 key 为参数的名称，value为参数的值。各个接口对应的参数，请参考 https://docs.open.alipay.com/


如示例所示 Client::request 方法有返回值 $alipay_response：
-------------------------------------------------------------------------------
$alipay_response asbamboo\\openpayAlipay\\alipayApi\\response\\ResponseInterface 实例。

Client::request 将支付宝的响应值转换为一个 asbamboo\\openpayAlipay\\alipayApi\\response\\ResponseInterface 实例返回。在 alipay-api/response目录下编写了各个接口的响应值转换类，响应值类名的规则时，请求接口名+后缀Response。如示例中的响应值转换类为 TradePrecreateResponse.

$alipay_response 使用 get 方法获取各个响应值。如示例所示，使用 $AlipayResponse->get('code') 判断接口响应的状态码。
