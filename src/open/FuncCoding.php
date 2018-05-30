<?php

/**
 * 小程序代码操作
 */

namespace LisaoWx\open;

class FuncCoding {

    private $access_token;
    private $curl;

    /**
     * 初始化
     * @param type $authorizer_access_token 第三方平台获取到的该小程序授权的authorizer_access_token
     */
    public function __construct($authorizer_access_token) {
        $this->access_token = $authorizer_access_token;
        $this->curl = new \lisao\curl\curl('');
    }

    /**
     * 为授权的小程序帐号上传小程序代码
     * @param type $tpl_id 代码库中的代码模版ID
     * @param type $ext 第三方自定义的配置,详情参见微信开放文档
     * @param type $version 代码版本号，开发者可自定义
     * @param type $detail 代码描述，开发者可自定义
     * @return boolean
     * @throws OpenException
     */
    public function setTpl($tpl_id, $ext, $version, $detail) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/commit?access_token=' . $this->access_token);
        $data = [
            'template_id' => $tpl_id,
            'user_version' => $version,
            'ext_json' => json_encode($ext),
            'user_desc' => $detail
        ];

        $post = $this->curl->post(json_encode($data));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

    /**
     * 获取体验小程序的体验二维码
     * @return 小程序二维码图片
     * @throws OpenException
     */
    public function getFuncTestBrCode() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/get_qrcode?access_token=' . $this->access_token);


        $post = $this->curl->get();
        $result = json_decode($post, TRUE);
        if ($result) {
            if ($result['errcode']) {
                throw new OpenException($result['errcode'], $result['errmsg']);
            }
        } else {
            return $post;
        }
    }

    /**
     * 获取授权小程序帐号的可选类目
     * @return array 类目列表
     * @throws OpenException
     */
    public function getFuncCategory() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/get_category?access_token=' . $this->access_token);


        $post = $this->curl->get();
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        //序列化
        $list = $result['category_list'];
        $return_arr = [];
        $isset = function($id, $arr) {
            foreach ($arr as $v) {
                if ($v['id'] == $id) {
                    return TRUE;
                }
            }
            return FALSE;
        };
        //第一级
        foreach ($list as $val) {
            if (!$isset($val['first_id'], $return_arr['first'])) {
                $return_arr['first'][] = [
                    'id' => $val['first_id'],
                    'name' => $val['first_class']
                ];
            }
        }
        //第二级
        foreach ($list as $val) {
            if (!$isset($val['second_id'], $return_arr['second'])) {
                $return_arr['second'][] = [
                    'id' => $val['second_id'],
                    'pid' => $val['first_id'],
                    'name' => $val['second_class']
                ];
            }
        }
        //第三级
        foreach ($list as $val) {
            if (!$isset($val['third_id'], $return_arr['third'])) {
                $return_arr['third'][] = [
                    'id' => $val['third_id'],
                    'pid' => $val['second_id'],
                    'name' => $val['third_class']
                ];
            }
        }

        return $return_arr;
    }

    //是否在数组中存在
    private function isSetInArray($id, $a) {
        
    }

    /**
     * 获取小程序的第三方提交代码的页面配置
     * @return array 页面列表
     * @throws OpenException
     */
    public function getFuncPages() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/get_page?access_token=' . $this->access_token);
        $post = $this->curl->get();
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['page_list'];
    }

    /**
     * 将第三方提交的代码包提交审核
     * @param array $item_list 提交审核项的一个列表（至少填写1项，至多填写5项）参考微信开放平台文档
     * @return int 审核订单id
     * @throws OpenException
     */
    public function commitFunc(array $item_list) {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/submit_audit?access_token=' . $this->access_token);
        $data = [
            'item_list' => $item_list
        ];
        $post = $this->curl->post(json_encode($data, JSON_UNESCAPED_UNICODE));
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return $result['auditid'];
    }

    /**
     * 查询审核状态 
     * @param int $auditid 提交审核时获得的审核id 不填则代表查询最近一次
     * @return array ['status'=>0 , 'reason'=>'拒绝原因']
     * @throws OpenException
     */
    public function selectCommitStatus($auditid = 0) {
        if ($auditid) {
            $this->curl->setUrl('https://api.weixin.qq.com/wxa/get_auditstatus?access_token=' . $this->access_token);

            $data = [
                'auditid' => $auditid
            ];
            $post = $this->curl->post(json_encode($data));
        } else {
            $this->curl->setUrl('https://api.weixin.qq.com/wxa/get_latest_auditstatus?access_token=' . $this->access_token);

            $post = $this->curl->get();
        }



        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return [
            'status' => $result['status'], //审核状态 0=成功 1=拒绝 2=审核中
            'reason' => $result['reason']//拒绝原因
        ];
    }

    /**
     * 发布已通过审核的小程序
     * @return boolean
     * @throws OpenException
     */
    public function releaseFunc() {
        $this->curl->setUrl('https://api.weixin.qq.com/wxa/release?access_token=' . $this->access_token);
      

        $post = $this->curl->post("{}");
        $result = json_decode($post, TRUE);
        if ($result['errcode']) {
            throw new OpenException($result['errcode'], $result['errmsg']);
        }
        return TRUE;
    }

}
