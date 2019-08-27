<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Support;

/**
 * 默认类型
 * Class Enum
 * @package App\Support
 */
class Enum
{
    /**
     * 国籍列表
     * @var array
     */
    public static $nationality = [
        'AF' => 'Afghanistan', // 阿富汗
        'AX' => 'Aland Islands', // 奥兰群岛
        'AL' => 'Albania', // 阿尔巴尼亚
        'DZ' => 'Algeria', // 阿尔及利亚
        'AS' => 'American Samoa', // 美属萨摩亚
        'AD' => 'Andorra', // 安道尔
        'AO' => 'Angola', // 安哥拉
        'AI' => 'Anguilla', // 安圭拉
        'AG' => 'Antigua and Barbuda', // 安提瓜和巴布达
        'AR' => 'Argentina', // 阿根廷
        'AM' => 'Armenia', // 亚美尼亚
        'AW' => 'Aruba', // 阿鲁巴
        'AU' => 'Australia', // 澳大利亚
        'AT' => 'Austria', // 奥地利
        'AZ' => 'Azerbaijan', // 阿塞拜疆
        'BD' => 'Bangladesh', // 孟加拉
        'BH' => 'Bahrain', // 巴林
        'BS' => 'Bahamas', // 巴哈马
        'BB' => 'Barbados', // 巴巴多斯
        'BY' => 'Belarus', // 白俄罗斯
        'BE' => 'Belgium', // 比利时
        'BZ' => 'Belize', // 伯利兹
        'BJ' => 'Benin', // 贝宁
        'BM' => 'Bermuda', // 百慕大
        'BT' => 'Bhutan', // 不丹
        'BO' => 'Bolivia', // 玻利维亚
        'BA' => 'Bosnia and Herzegovina', // 波斯尼亚和黑塞哥维那
        'BW' => 'Botswana', // 博茨瓦纳
        'BV' => 'Bouvet Island', // 布维岛
        'BR' => 'Brazil', // 巴西
        'BN' => 'Brunei', // 文莱
        'BG' => 'Bulgaria', // 保加利亚
        'BF' => 'Burkina Faso', // 布基纳法索
        'BI' => 'Burundi', // 布隆迪
        'KH' => 'Cambodia', // 柬埔寨
        'CM' => 'Cameroon', // 喀麦隆
        'CA' => 'Canada', // 加拿大
        'CV' => 'Cape Verde', // 佛得角
        'CF' => 'Central African Republic', // 中非
        'TD' => 'Chad', // 乍得
        'CL' => 'Chile', // 智利
        'CX' => 'Christmas Islands', // 圣诞岛
        'CC' => 'Cocos (keeling) Islands', // 科科斯（基林）群岛
        'CO' => 'Colombia', // 哥伦比亚
        'KM' => 'Comoros', // 科摩罗
        'CD' => 'Congo (Congo-Kinshasa)', // 刚果（金）
        'CG' => 'Congo', // 刚果
        'CK' => 'Cook Islands', // 库克群岛
        'CR' => 'Costa Rica', // 哥斯达黎加
        'CI' => 'Cote D\'Ivoire', // 科特迪瓦
        'CN' => 'China', // 中国
        'HR' => 'Croatia', // 克罗地亚
        'CU' => 'Cuba', // 古巴
        'CZ' => 'Czech', // 捷克
        'CY' => 'Cyprus', // 塞浦路斯
        'DK' => 'Denmark', // 丹麦
        'DJ' => 'Djibouti', // 吉布提
        'DM' => 'Dominica', // 多米尼加
        'Ti' => 'East mor', // 东帝汶
        'EC' => 'Ecuador', // 厄瓜多尔
        'EG' => 'Egypt', // 埃及
        'GQ' => 'Equatorial Guinea', // 赤道几内亚
        'ER' => 'Eritrea', // 厄立特里亚
        'EE' => 'Estonia', // 爱沙尼亚
        'ET' => 'Ethiopia', // 埃塞俄比亚
        'FO' => 'Faroe Islands', // 法罗群岛
        'FJ' => 'Fiji', // 斐济
        'FI' => 'Finland', // 芬兰
        'FR' => 'France', // 法国
        'FX' => 'MetropolitanFrance', // 法国大都会
        'GF' => 'French Guiana', // 法属圭亚那
        'PF' => 'French Polynesia', // 法属波利尼西亚
        'GA' => 'Gabon', // 加蓬
        'GM' => 'Gambia', // 冈比亚
        'GE' => 'Georgia', // 格鲁吉亚
        'DE' => 'Germany', // 德国
        'GH' => 'Ghana', // 加纳
        'GI' => 'Gibraltar', // 直布罗陀
        'GR' => 'Greece', // 希腊
        'GD' => 'Grenada', // 格林纳达
        'GP' => 'Guadeloupe', // 瓜德罗普岛
        'GU' => 'Guam', // 关岛
        'GT' => 'Guatemala', // 危地马拉
        'GG' => 'Guernsey', // 根西岛
        'GW' => 'Guinea-Bissau', // 几内亚比绍
        'GN' => 'Guinea', // 几内亚
        'GY' => 'Guyana', // 圭亚那
        'HT' => 'Haiti', // 海地
        'HN' => 'Honduras', // 洪都拉斯
        'HU' => 'Hungary', // 匈牙利
        'IS' => 'Iceland', // 冰岛
        'IN' => 'India', // 印度
        'ID' => 'Indonesia', // 印度尼西亚
        'IR' => 'Iran', // 伊朗
        'IQ' => 'Iraq', // 伊拉克
        'IE' => 'Ireland', // 爱尔兰
        'IM' => 'Isle of Man', // 马恩岛
        'IL' => 'Israel', // 以色列
        'IT' => 'Italy', // 意大利
        'JM' => 'Jamaica', // 牙买加
        'JP' => 'Japan', // 日本
        'JE' => 'Jersey', // 泽西岛
        'JO' => 'Jordan', // 约旦
        'KZ' => 'Kazakhstan', // 哈萨克斯坦
        'KE' => 'Kenya', // 肯尼亚
        'KI' => 'Kiribati', // 基里巴斯
        'KR' => 'Korea (South)', // 韩国
        'KD' => 'Korea (North)', // 朝鲜
        'KW' => 'Kuwait', // 科威特
        'KG' => 'Kyrgyzstan', // 吉尔吉斯斯坦
        'LO' => 'Laos', // 老挝
        'LV' => 'Latvia', // 拉脱维亚
        'LB' => 'Lebanon', // 黎巴嫩
        'LS' => 'Lesotho', // 莱索托
        'LR' => 'Liberia', // 利比里亚
        'LY' => 'Libya', // 利比亚
        'LI' => 'Liechtenstein', // 列支敦士登
        'LT' => 'Lithuania', // 立陶宛
        'LU' => 'Luxembourg', // 卢森堡
        'MK' => 'Macedonia', // 马其顿
        'MW' => 'Malawi', // 马拉维
        'MY' => 'Malaysia', // 马来西亚
        'MG' => 'Madagascar', // 马达加斯加
        'MV' => 'Maldives', // 马尔代夫
        'ML' => 'Mali', // 马里
        'MT' => 'Malta', // 马耳他
        'MH' => 'Marshall Islands', // 马绍尔群岛
        'MQ' => 'Martinique', // 马提尼克岛
        'MR' => 'Mauritania', // 毛里塔尼亚
        'MU' => 'Mauritius', // 毛里求斯
        'YT' => 'Mayotte', // 马约特
        'MX' => 'Mexico', // 墨西哥
        'MF' => 'Micronesia', // 密克罗尼西亚
        'MD' => 'Moldova', // 摩尔多瓦
        'MC' => 'Monaco', // 摩纳哥
        'MN' => 'Mongolia', // 蒙古
        'ME' => 'Montenegro', // 黑山
        'MS' => 'Montserrat', // 蒙特塞拉特
        'MA' => 'Morocco', // 摩洛哥
        'MZ' => 'Mozambique', // 莫桑比克
        'MM' => 'Myanmar', // 缅甸
        'NA' => 'Namibia', // 纳米比亚
        'NR' => 'Nauru', // 瑙鲁
        'NP' => 'Nepal', // 尼泊尔
        'NL' => 'Netherlands', // 荷兰
        'NC' => 'New Caledonia', // 新喀里多尼亚
        'NZ' => 'New Zealand', // 新西兰
        'NI' => 'Nicaragua', // 尼加拉瓜
        'NE' => 'Niger', // 尼日尔
        'NG' => 'Nigeria', // 尼日利亚
        'NU' => 'Niue', // 纽埃
        'NF' => 'Norfolk Island', // 诺福克岛
        'NO' => 'Norway', // 挪威
        'OM' => 'Oman', // 阿曼
        'PK' => 'Pakistan', // 巴基斯坦
        'PW' => 'Palau', // 帕劳
        'PS' => 'Palestine', // 巴勒斯坦
        'PA' => 'Panama', // 巴拿马
        'PG' => 'Papua New Guinea', // 巴布亚新几内亚
        'PE' => 'Peru', // 秘鲁
        'PH' => 'Philippines', // 菲律宾
        'PN' => 'Pitcairn Islands', // 皮特凯恩群岛
        'PL' => 'Poland', // 波兰
        'PT' => 'Portugal', // 葡萄牙
        'PR' => 'Puerto Rico', // 波多黎各
        'QA' => 'Qatar', // 卡塔尔
        'RE' => 'Reunion', // 留尼汪岛
        'RO' => 'Romania', // 罗马尼亚
        'RW' => 'Rwanda', // 卢旺达
        'RU' => 'Russian Federation', // 俄罗斯联邦
        'SH' => 'Saint Helena', // 圣赫勒拿
        'KN' => 'Saint Kitts-Nevis', // 圣基茨和尼维斯
        'LC' => 'Saint Lucia', // 圣卢西亚
        'VG' => 'Saint Vincent and the Grenadines', // 圣文森特和格林纳丁斯
        'SV' => 'El Salvador', // 萨尔瓦多
        'WS' => 'Samoa', // 萨摩亚
        'SM' => 'San Marino', // 圣马力诺
        'ST' => 'Sao Tome and Principe', // 圣多美和普林西比
        'SA' => 'Saudi Arabia', // 沙特阿拉伯
        'SN' => 'Senegal', // 塞内加尔
        'SC' => 'Seychelles', // 塞舌尔
        'SL' => 'Sierra Leone', // 塞拉利昂
        'SG' => 'Singapore', // 新加坡
        'RS' => 'Serbia', // 塞尔维亚
        'SK' => 'Slovakia', // 斯洛伐克
        'SI' => 'Slovenia', // 斯洛文尼亚
        'SB' => 'Solomon Islands', // 所罗门群岛
        'SO' => 'Somalia', // 索马里
        'ZA' => 'South Africa', // 南非
        'ES' => 'Spain', // 西班牙
        'LK' => 'Sri Lanka', // 斯里兰卡
        'SD' => 'Sudan', // 苏丹
        'SR' => 'Suriname', // 苏里南
        'SZ' => 'Swaziland', // 斯威士兰
        'SE' => 'Sweden', // 瑞典
        'CH' => 'Switzerland', // 瑞士
        'SY' => 'Syria', // 叙利亚
        'TJ' => 'Tajikistan', // 塔吉克斯坦
        'TZ' => 'Tanzania', // 坦桑尼亚
        'TH' => 'Thailand', // 泰国
        'TT' => 'Trinidad and Tobago', // 特立尼达和多巴哥
        'TL' => 'Timor-Leste', // 东帝汶
        'TG' => 'Togo', // 多哥
        'TK' => 'Tokelau', // 托克劳
        'TO' => 'Tonga', // 汤加
        'TN' => 'Tunisia', // 突尼斯
        'TR' => 'Turkey', // 土耳其
        'TM' => 'Turkmenistan', // 土库曼斯坦
        'TV' => 'Tuvalu', // 图瓦卢
        'UG' => 'Uganda', // 乌干达
        'UA' => 'Ukraine', // 乌克兰
        'AE' => 'United Arab Emirates', // 阿拉伯联合酋长国
        'UK' => 'United Kingdom', // 英国
        'US' => 'United States', // 美国
        'UY' => 'Uruguay', // 乌拉圭
        'UZ' => 'Uzbekistan', // 乌兹别克斯坦
        'VN' => 'Vanuatu', // 瓦努阿图
        'VA' => 'Vatican City', // 梵蒂冈
        'VE' => 'Venezuela', // 委内瑞拉
        'VM' => 'Vietnam', // 越南
        'WF' => 'Wallis and Futuna', // 瓦利斯群岛和富图纳群岛
        'EH' => 'Western Sahara', // 西撒哈拉
        'YE' => 'Yemen', // 也门
        'YU' => 'Yugoslavia', // 南斯拉夫
        'ZM' => 'Zambia', // 赞比亚
        'ZW' => 'Zimbabwe', // 津巴布韦
    ];

    /**
     * 学历列表
     * @var array
     */
    public static $education = [
        1 => 'Grades 1-3', // 小学1—3年级
        2 => 'Grades 3-6', // 小学3—6年级
        3 => 'junior high school', // 初中
        4 => 'senior high school', // 高中
        5 => 'junior college', // 大专
        6 => 'undergraduate', // 本科
        7 => 'postgraduate', // 研究生
        8 => 'doctor and above', // 博士及以上
    ];
}