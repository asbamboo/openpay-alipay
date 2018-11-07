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
EnvHelper::set(AlipayEnv::ALIPAY_APP_ID, '2016090900468991');
/***************************************************************************************************/

/***************************************************************************************************
 * 数据库配置
 ***************************************************************************************************/
if(!$Container->has('db')){
    $DbFactory          = new Factory();
    $Connection         = require __DIR__ . DIRECTORY_SEPARATOR . 'db-connection.php';
    $DbFactory->addConnection($Connection);
    $Container->set('db', $DbFactory);
}
/***************************************************************************************************/