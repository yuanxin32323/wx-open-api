<?php

/**
 * 第三方开放平台配置
 */

namespace LisaoWx\open\config;

use LisaoWx\open\OpenException;

class OpenConfig {

    protected $AppId;
    protected $AppSecret;
    protected $ComponentAccessToken;
    protected $curl;

    public function __construct($AppId, $AppSecret, $ComponentAccessToken = '') {
        $this->AppId = $AppId;
        $this->AppSecret = $AppSecret;
        $this->ComponentAccessToken = $ComponentAccessToken;
        $this->curl = new \lisao\curl\curl('');
    }

    public function setAppId($AppId) {
        $this->AppId = $AppId;
        return $this;
    }

    public function setAppSecret($AppSecret) {
        $this->AppSecret = $AppSecret;
        return $this;
    }

    public function setComponentAccessToken($ComponentAccessToken) {
        $this->ComponentAccessToken = $ComponentAccessToken;
    }

    public function getAppId() {
        return $this->AppId;
    }

    public function getAppSecret() {
        return $this->AppSecret;
    }

    public function getComponentAccessToken() {
        return $this->ComponentAccessToken;
    }

    /**
     * 生成AccessToken
     * @param string $component_verify_ticket 微信后台推送的ticket，此ticket会定时推送
     */
    public function createAccessToken($component_verify_ticket) {
        $this->curl->setUrl('https://api.weixin.qq.com/cgi-bin/component/api_component_token');

        $post = $this->curl->post(json_encode([
            'component_appid' => $this->AppId,
            'component_appsecret' => $this->AppSecret,
            'component_verify_ticket' => $component_verify_ticket
        ]));
        $result = json_decode($post, true);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        $this->ComponentAccessToken = $result['component_access_token'];
        return $result;
    }

}
