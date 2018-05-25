<?php

/**
 * 第三方平台，小程序接口
 */

namespace LisaoWx\open;

class OpenFunc {

    private $access_token;
    private $curl;

    /**
     * 初始化
     * @param string $auth_access_token 被授权的小程序access_token
     * @throws OpenException
     */
    public function __construct($auth_access_token) {

        $this->curl = new \lisao\curl\curl('');
        if (!$auth_access_token) {
            throw new OpenException('-1', '授权的小程序access_token不可为空');
        }
        $this->access_token = $auth_access_token;
    }

    /**
     * 获取小程序服务域名
     * @return array
     * @throws OpenException
     */
    public function getServiceDomain() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/modify_domain?access_token=' . $this->access_token);
        $post = $this->curl->post(json_encode([
            'action' => 'get'
        ]));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return [
            'requestdomain' => $result['requestdomain'],
            'wsrequestdomain' => $result['wsrequestdomain'],
            'uploaddomain' => $result['uploaddomain'],
            'downloaddomain' => $result['downloaddomain']
        ];
    }

    /**
     * 设置覆盖小程序服务域名（常用）
     * @param array $arr
     * @return boolean
     * @throws OpenException
     */
    public function setServiceDomain(array $arr) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/modify_domain?access_token=' . $this->access_token);
        $data = [
            'action' => 'set'
        ];
        if ($arr['requestdomain']) {
            $data['requestdomain'] = $arr['requestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 删除小程序服务域名
     * @param array $arr
     * @return boolean
     * @throws OpenException
     */
    public function delServiceDomain(array $arr) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/modify_domain?access_token=' . $this->access_token);
        $data = [
            'action' => 'delete'
        ];
        if ($arr['requestdomain']) {
            $data['requestdomain'] = $arr['requestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        if ($arr['wsrequestdomain']) {
            $data['wsrequestdomain'] = $arr['wsrequestdomain'];
        }
        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 设置覆盖小程序业务域名
     * @param array $url
     * @return boolean
     * @throws OpenException
     */
    public function setBusinessDomain(array $url) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/setwebviewdomain?access_token=' . $this->access_token);
        $data = [
            'action' => 'set',
            'webviewdomain' => $url
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 获取小程序业务域名
     * @return array
     * @throws OpenException
     */
    public function getBusinessDomain() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/setwebviewdomain?access_token=' . $this->access_token);
        $data = [
            'action' => 'get'
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['webviewdomain'];
    }

    /**
     * 删除小程序业务域名
     * @param array $url
     * @return boolean
     * @throws OpenException
     */
    public function delBusinessDomain(array $url) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/setwebviewdomain?access_token=' . $this->access_token);
        $data = [
            'action' => 'delete',
            'webviewdomain' => $url
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 添加小程序体验账号
     * @param string $wxid
     * @return string 返回人员对应的唯一字符串
     * @throws OpenException
     */
    public function addTestUser($wxid) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/bind_tester?access_token=' . $this->access_token);
        $data = [
            'wechatid' => $wxid
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['userstr'];
    }

    /**
     * 删除小程序体验账号
     * @param type $userstr 返回人员对应的唯一字符串
     * @param type $wxid 微信id
     * @return boolean
     * @throws OpenException
     */
    public function delTestUser($userstr = '', $wxid = '') {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/unbind_tester?access_token=' . $this->access_token);
        if ($userstr) {
            $data = [
                'userstr' => $userstr
            ];
        } else {
            $data = [
                'wechatid' => $wxid
            ];
        }

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 获取小程序体验账号列表
     * @return array
     * @throws OpenException
     */
    public function getTestUser() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/memberauth?access_token=' . $this->access_token);
        $data = [
            'action' => 'get_experiencer'
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['members'];
    }

}
