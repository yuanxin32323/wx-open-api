<?php

/**
 * 小程序代码模板库
 */

namespace LisaoWx\open;

class FuncCodeTpl {

    private $access_token;
    private $curl;

    /**
     * 初始化
     * @param type $component_access_token 第三方平台的access_token
     */
    public function __construct($component_access_token) {
        $this->access_token = $component_access_token;
        $this->curl = new \lisao\curl\curl();
    }

    /**
     * 获取草稿箱内的所有代码列表
     * @return array 草稿列表
     * @throws OpenException
     */
    public function getDraftList() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/gettemplatedraftlist?access_token=' . $this->access_token);
        $data = [
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['draft_list'];
    }

    /**
     * 获取模板库内的所有代码列表
     * @return type 模板库列表
     * @throws OpenException
     */
    public function getTplList() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/gettemplatelist?access_token=' . $this->access_token);
        $data = [
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['template_list'];
    }

    /**
     * 添加草稿到模板库
     * @param type $draft_id 草稿ID，本字段可通过“ 获取草稿箱内的所有临时代码草稿 ”接口获得
     * @return boolean
     * @throws OpenException
     */
    public function addTpl($draft_id) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/addtotemplate?access_token=' . $this->access_token);
        $data = [
            'draft_id' => $draft_id
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 删除模板库中的模板
     * @param string $tpl_id 模板id
     * @return boolean
     * @throws OpenException
     */
    public function delTpl($tpl_id) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/deletetemplate?access_token=' . $this->access_token);
        $data = [
            'template_id' => $tpl_id
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

}
