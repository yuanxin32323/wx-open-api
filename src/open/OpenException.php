<?php

/*
 * 错误调试
 */

namespace LisaoWx\open;

class OpenException extends \Exception {

    private $msg; //错误信息
    private $error_code; //错误代码
    private $info = [
        50001 => '接口未授权',
        85001 => '微信号不存在或微信号设置为不可搜索',
        85002 => '小程序绑定的体验者数量达到上限',
        85003 => '微信号绑定的小程序体验者达到上限',
        85004 => '微信号已经绑定',
        85006 => '标签格式错误',
        85007 => '页面路径错误',
        85008 => '类目填写错误',
        85009 => '已经有正在审核的版本',
        85010 => 'tem_list有项目为空',
        85011 => '标题填写错误',
        85012 => '无效的审核id',
        85013 => '无效的自定义配置',
        85014 => '无效的模版编号',
        85015 => '该账号不是小程序账号',
        85016 => '域名数量超过限制',
        85017 => '没有新增域名，请确认小程序已经添加了域名或该域名是否没有在第三方平台添加',
        85018 => '域名没有在第三方平台设置',
        85019 => '没有审核版本',
        85020 => '审核状态未满足发布',
        85021 => '状态不可变',
        85022 => 'action非法',
        85023 => '审核列表填写的项目数不在1-5以内',
        85043 => '模版错误',
        85044 => '代码包超过大小限制',
        85045 => 'ext_json有不存在的路径',
        85046 => 'tabBar中缺少path',
        85047 => 'pages字段为空',
        85048 => 'ext_json解析失败',
        85077 => '小程序类目信息失效（类目中含有官方下架的类目，请重新选择类目）',
        85085 => '近7天提交审核的小程序数量过多，请耐心等待审核完毕后再次提交',
        86000 => '不是由第三方代小程序进行调用',
        86001 => '不存在第三方的已经提交的代码',
        86002 => '小程序还未设置昵称、头像、简介。请先设置完后再重新提交。',
        87011 => '现网已经在灰度发布，不能进行版本回退',
        87012 => '该版本不能回退，可能的原因：1:无上一个线上版用于回退 2:此版本为已回退版本，不能回退 3:此版本为回退功能上线之前的版本，不能回退',
        89019 => '业务域名无更改，无需重复设置',
        89020 => '尚未设置小程序业务域名，请先在第三方平台中设置小程序业务域名后在调用本接口',
        89021 => '请求保存的域名不是第三方平台中已设置的小程序业务域名或子域名',
        89029 => '业务域名数量超过限制',
        89231 => '个人小程序不支持调用setwebviewdomain 接口',
    ];

    public function __construct(string $error_code = '', string $message = "") {
        parent::__construct($message);
        $this->msg = $message;
        $this->error_code = $error_code;
    }

    /**
     * 获取错误信息
     * @return type
     */
    public function get_error_msg() {
        return $this->info[$this->error_code] ?: $this->msg;
    }

    /**
     * 获取错误代码
     * @return type
     */
    public function get_error_code() {
        return $this->error_code;
    }

}
