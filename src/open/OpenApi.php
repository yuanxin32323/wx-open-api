<?php

/**
 * 开放平台api
 */

namespace LisaoWx\open;

use LisaoWx\open\config\OpenConfig;
use LisaoWx\open\result\AuthInfoResult;
use LisaoWx\open\result\ProgramInfoResult;

class OpenApi {

    protected $config;
    private $curl;

    /**
     * 初始化
     * @param OpenConfig $config
     */
    public function __construct(OpenConfig &$config) {
        $this->config = $config;
        $this->curl = new \lisao\curl\curl('');
        if (!$config->getComponentAccessToken()) {
            throw new OpenException('-1', 'access_token不可为空');
        }
    }

    /**
     * 创建授权链接
     * @param type $callback_url 回调地址
     * @param type $is_mobile 是否生成移动端授权链接
     * @param type $auth_type 要授权的帐号类型：1则商户点击链接后，手机端仅展示公众号、2表示仅展示小程序，3表示公众号和小程序都展示。如果为未指定，则默认小程序和公众号都展示。第三方平台开发者可以使用本字段来控制授权的帐号类型。
     * @return string 授权链接
     */
    public function createAuthUrl($callback_url, $is_mobile = false, $auth_type = 3) {
        $pre_auth_code = $this->createPreAuthCode();
        if ($is_mobile) {
            $url = "https://mp.weixin.qq.com/safe/bindcomponent?action=bindcomponent&auth_type={$auth_type}&no_scan=1&component_appid=" . $this->config->getAppId() . "&pre_auth_code={$pre_auth_code}&redirect_uri=" . $callback_url . "#wechat_redirect";
        } else {
            $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=" . $this->config->getAppId() . "&pre_auth_code={$pre_auth_code}&redirect_uri={$callback_url}&auth_type={$auth_type}";
        }
        return $url;
    }

    /**
     * 获取预授权码
     * @return string 预授权码
     * @throws OpenException
     */
    private function createPreAuthCode() {
        $this->curl->setUrl('https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=' . $this->config->getComponentAccessToken());
        $post = $this->curl->post(json_encode([
            'component_appid' => $this->config->getAppId(),
        ]));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['pre_auth_code'];
    }

    /**
     * 获取授权信息
     * @param type $auth_code 授权code,会在授权成功时返回给第三方平台，详见第三方平台授权流程说明
     * @return AuthInfoResult 公众号或小程序的授权信息
     * @throws OpenException 
     */
    public function getAuthInfo($auth_code) {
        $this->curl->setUrl('https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=' . $this->config->getComponentAccessToken());

        $post = $this->curl->post(json_encode([
            'component_appid' => $this->config->getAppId(),
            'authorization_code' => $auth_code
        ]));
        $result = json_decode($post, true);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }

        $obj = new AuthInfoResult();
        $obj->authorizer_appid = $result['authorization_info']['authorizer_appid'];
        $obj->authorizer_access_token = $result['authorization_info']['authorizer_access_token'];
        $obj->expires_in = $result['authorization_info']['expires_in'];
        $obj->authorizer_refresh_token = $result['authorization_info']['authorizer_refresh_token'];
        $obj->func_info = $result['authorization_info']['func_info'];
        return $obj;
    }

    /**
     * 获取（刷新）授权公众号或小程序的接口调用凭据（令牌）
     * @param type $app_id 授权方appid
     * @param type $authorizer_refresh_token 授权方的刷新令牌，刷新令牌主要用于第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌
     * @return array authorizer_access_token expires_in authorizer_refresh_token
     * @throws OpenException
     */
    public function refreshToken($app_id, $authorizer_refresh_token) {
        $this->curl->setUrl('https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=' . $this->config->getComponentAccessToken());
        
        $post = $this->curl->post(json_encode([
            'component_appid' => $this->config->getAppId(),
            'authorizer_appid' => $app_id,
            'authorizer_refresh_token' => $authorizer_refresh_token
        ]));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result;
    }

    /**
     * 获取授权方的帐号基本信息
     * @param type $app_id 授权方appid
     * @return ProgramInfoResult
     * @throws OpenException
     */
    public function getAppInfo($app_id) {

        $this->curl->setUrl('https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=' . $this->config->getComponentAccessToken());
        $post = $this->curl->post(json_encode([
            'component_appid' => $this->config->getAppId(),
            'authorizer_appid' => $app_id
        ]));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        $obj = new ProgramInfoResult();
        $obj->nick_name = $result['authorizer_info']['nick_name'];
        $obj->head_img = $result['authorizer_info']['head_img'];
        $obj->service_type_info = $result['authorizer_info']['service_type_info'];
        $obj->verify_type_info = $result['authorizer_info']['verify_type_info'];
        $obj->user_name = $result['authorizer_info']['user_name'];
        $obj->signature = $result['authorizer_info']['signature'];
        $obj->principal_name = $result['authorizer_info']['principal_name'];
        $obj->business_info = $result['authorizer_info']['business_info'];
        $obj->qrcode_url = $result['authorizer_info']['qrcode_url'];
        $obj->authorization_info = $result['authorizer_info']['authorization_info'];
        $obj->authorization_appid = $result['authorizer_info']['authorization_appid'];
        $obj->miniprograminfo = $result['authorizer_info']['MiniProgramInfo'];
        $obj->network = $result['authorizer_info']['network'];
        $obj->func_info = $result['authorizer_info']['func_info'];
        $obj->alias = $result['authorizer_info']['alias'];

        return $obj;
    }

}
