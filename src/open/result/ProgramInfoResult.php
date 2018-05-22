<?php

/**
 * 小程序信息模板
 */

namespace LisaoWx\open\result;

class ProgramInfoResult {

    /**
     * 授权方昵称
     * @var type 
     */
    public $nick_name;

    /**
     * 授权方头像
     * @var type 
     */
    public $head_img;

    /**
     * 授权方公众号（小程序）类型，0代表订阅号(小程序默认为0)，1代表由历史老帐号升级后的订阅号，2代表服务号
     * @var type 
     */
    public $service_type_info;

    /**
     * 授权方认证类型，-1代表未认证(小程序同有)，0代表微信认证（小程序同有），1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
     * @var type 
     */
    public $verify_type_info;

    /**
     * 授权方公众号（小程序）的原始ID
     * @var type 
     */
    public $user_name;

    /**
     * 小程序帐号介绍
     * @var type 
     */
    public $signature;

    /**
     * 公众号（小程序）的主体名称
     * @var type 
     */
    public $principal_name;

    /**
     * 授权方公众号所设置的微信号，可能为空
     * @var type 
     */
    public $alias;

    /**
     * 用以了解以下功能的开通状况（0代表未开通，1代表已开通）
     * open_store:是否开通微信门店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
     * @var type 
     */
    public $business_info;

    /**
     * 二维码图片的URL，开发者最好自行也进行保存
     * @var type 
     */
    public $qrcode_url;

    /**
     * 授权信息
     * @var type 
     */
    public $authorization_info;

    /**
     * 授权方appid
     * @var type 
     */
    public $authorization_appid;

    /**
     * 可根据这个字段判断是否为小程序类型授权
     * @var type 
     */
    public $miniprograminfo; //小程序专有
    /**
     * 小程序已设置的各个服务器域名
     * @var type 
     */
    public $network;

    /**
     * [公众号]
     * 公众号授权给开发者的权限集列表，ID为1到15时
     * 1.消息管理权限 2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。
     * [小程序]
     * 小程序授权给开发者的权限集列表，ID为17到19时分别代表：
     * 17.帐号管理权限 18.开发管理权限 19.客服消息管理权限 请注意： 1）该字段的返回不会考虑小程序是否具备该权限集的权限（因为可能部分具备）。
     * @var type 
     */
    public $func_info;

}
