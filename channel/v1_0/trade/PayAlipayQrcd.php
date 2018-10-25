<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\PayRequest;
use asbamboo\openpay\apiStore\parameter\v1_0\trade\PayResponse;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradePrecreateResponse;
use asbamboo\openpayAlipay\exception\ResponseFormatException;

/**
 * openpay[trade.pay] 渠道:支付宝扫码支付
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
class PayAlipayQrcd implements PayInterface
{
    /**
     * 支付宝扫码支付
     *
     * @var string
     */
    const NAME  = 'ALIPAY_QRCD';
    const LABEL = '支付宝扫码支付';

    /**
     *
     * @param PayRequest $PayRequest
     * @return PayResponse
     */
    public function execute(PayRequest $PayRequest) : PayResponse
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $PayRequest->getOutTradeNo(),
                'total_amount'      => bcdiv($PayRequest->getTotalFee(), 100, 2), //聚合接口接收的单位是分，支付宝的单位是元
                'subject'           => $PayRequest->getTitle(),
                'notify_url'        => EnvHelper::get(Env::ALIPAY_QRCD_NOTIFY_URL),
            ];
            $alipay_params          = json_decode((string) $PayRequest->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }

            $AlipayResponse = Client::request('TradePrecreate', $request_data);
            if(     $AlipayResponse->get('code') != TradePrecreateResponse::CODE_SUCCESS
                ||  $AlipayResponse->get('sub_code') != null
            ){
                $Exception                      = new Api3NotSuccessResponseException('支付宝返回的响应值表示这次业务没有处理成功。');
                $ApiResponseParams              = new ApiResponseParams();
                $ApiResponseParams->code        = $AlipayResponse->get('code');
                $ApiResponseParams->msg         = $AlipayResponse->get('msg');
                $ApiResponseParams->sub_code    = $AlipayResponse->get('sub_code');
                $ApiResponseParams->sub_msg     = $AlipayResponse->get('sub_msg');
                $Exception->setApiResponseParams($ApiResponseParams);
                throw $Exception;
            }
            $PayResponse                            = new PayResponse();
            $PayResponse->_redirect_data['qr_code'] = $AlipayResponse->get('qr_code');
            return $PayResponse;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::getName()
     */
    public function getName() : string
    {
        return self::NAME;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::getLabel()
     */
    public function getLabel() : string
    {
        return self::LABEL;
    }
}