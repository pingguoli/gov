<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;

use App\Model\Face;
use App\Model\File;
use App\Model\Payment;
use App\Model\SmsCode;
use App\Model\User;
use App\Support\AliyunSms;
use App\Support\ChunkUpload;
use App\Support\Enum;
use App\Support\FacePlusPlus;
use App\Support\WxNativePay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Web
 */
class RegisterController extends BaseController
{

    /**
     * session 类型
     */
    const KEY_TYPE_FIRST = 'first';

    /**
     * session 类型
     */
    const KEY_TYPE_SECOND = 'second';

    /**
     * session 类型
     */
    const KEY_TYPE_THIRD = 'third';

    /**
     * 图片最大值(单位MB)
     */
    const MAX_IMAGE_SIZE = 2;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 注册发送短信
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendSms(Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'error' => 0,
                'message' => ''
            ];

            $mobile = $request->input('mobile');
            if (empty($mobile)) {
                $data = [
                    'error' => 1,
                    'message' => __('validation.required', ['attribute' => __('Mobile')])
                ];
                return response()->json($data);
            }

            $protocol = $request->input('protocol');
            if (empty($protocol)) {
                $data = [
                    'error' => 1,
                    'message' => __('Please read the agreement carefully and agree')
                ];
                return response()->json($data);
            }

            $user = User::where('mobile', encryptStr($mobile))->where('is_complete', 1)->first();
            if ($user && $user->id) {
                $data = [
                    'error' => 1,
                    'message' => __('Mobile has been registered')
                ];
                return response()->json($data);
            }

            $code = geneSmsCode();
            $aliyunSms = new AliyunSms();
            if (!$aliyunSms->send($mobile, $code)) {
                $data = [
                    'error' => 1,
                    'message' => __('Send failed, please try again later')
                ];
                return response()->json($data);
            }

            if (!SmsCode::send($mobile, $code)) {
                $data = [
                    'error' => 1,
                    'message' => ''
                ];
                return response()->json($data);
            }

            return response()->json($data);
        }

        return redirect()->route('register');
    }

    /**
     * 注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function first()
    {
        return frontendView('register.first');
    }

    /**
     * 注册第一步
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveFirst(Request $request)
    {
        $validate = [
            'mobile' => 'required|min:11|max:11',
            'sms_code' => 'required',
            'protocol' => 'required',
        ];

        if (!empty(config('site.other.captcha'))) {
            $validate['captcha'] = 'required|captcha';
        }

        $this->validate($request, $validate, [
            'protocol.required' => __('Please read the agreement carefully and agree')
        ], [
            'mobile' => __('Mobile'),
            'sms_code' => __('SMS Code'),
            'captcha' => __('Captcha')
        ]);

        $mobile = $request->input('mobile');

        // 验证短信验证码
        $smsCode = $request->input('sms_code');
        if (!SmsCode::verify($mobile, $smsCode)) {
            return back()->withErrors(['sms_code' => __('SMS Verification Code incorrect or expired')])->withInput();
        }

        // 重新提交第一步时需要清除之前所有session信息
        $this->delSessionKey();

        $user = User::where('mobile', encryptStr($mobile))->first();
        if ($user && $user->id) {
            // 已存在数据
            if ($user->is_complete) {
                return back()->with('error', __('Mobile has been registered'))->withInput();
            }

            return $this->redirectStep($user);
        } else {
            $user = new User();
            $key = User::generateCode();
            $data = [
                'code' => $key,
                'mobile' => $mobile,
                'step' => 1
            ];
            $user->fill($data);
            if (!$user->save()) {
                return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
            }

            return $this->redirectStep($user);
        }
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function second(Request $request, $key)
    {
        $code = $this->decryptKey($key, self::KEY_TYPE_FIRST);
        if (empty($code)) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        $user = User::where('code', $code)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __('Your request is not allowed. Please refresh and try again.'))->withInput();
        }

        $prev = route('register');
        return frontendView('register.second', compact('user', 'prev'));
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSecond(Request $request, $key)
    {
        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_FIRST);
        if (empty($hasCode) || $hasCode != $code) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        $this->validate($request, [
            'nickname' => 'required|min:1|max:50',
            'name' => 'required|min:1|max:50',
            'id_card' => 'required|size:18',
            'sex' => 'required|numeric',
            'email' => 'required|email',
            'birthday' => 'required|min:1|max:50',
            'nationality' => 'required|min:1|max:50',
            'address' => 'required|max:255',
            'education' => 'required|numeric',
        ], [], [
            'nickname' => __('Nickname'),
            'name' => __('Username'),
            'id_card' => __('ID Card'),
            'sex' => __('Sex'),
            'email' => __('E-mail'),
            'birthday' => __('Birthday'),
            'nationality' => __('Nationality'),
            'address' => __('Address'),
            'education' => __('Education'),
        ]);

        $data = $request->only(['nickname', 'name', 'id_card', 'sex', 'email', 'birthday', 'nationality', 'address', 'education']);
        // 验证身份证号码
        if (User::hasIdCard($data['id_card'], $id)) {
            return back()->withErrors(['id_card' => __('validation.unique', ['attribute' => __('ID Card')])])->withInput();
        }
        // 验证邮箱
        if (User::hasEmail($data['email'], $id)) {
            return back()->withErrors(['email' => __('validation.unique', ['attribute' => __('E-mail')])])->withInput();
        }
        // 验证国籍
        if (!array_key_exists($data['nationality'], Enum::$nationality)) {
            return back()->withErrors(['nationality' => __('validation.in', ['attribute' => __('Nationality')])])->withInput();
        }
        // 验证学历
        if (!array_key_exists($data['education'], Enum::$education)) {
            return back()->withErrors(['education' => __('validation.in', ['attribute' => __('Education')])])->withInput();
        }

        $data['step'] = 2;
        $user->fill($data);
        if (!$user->save()) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        return $this->redirectStep($user);
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function third(Request $request, $key)
    {
        $code = $this->decryptKey($key, self::KEY_TYPE_SECOND);
        if (empty($code)) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        $user = User::where('code', $code)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __('Your request is not allowed. Please refresh and try again.'))->withInput();
        }

        $prevKey = $this->encryptKey($user->code, self::KEY_TYPE_FIRST);
        $prev = route('register.second', ['key' => $prevKey]);
        return frontendView('register.third', compact('user', 'prev', 'key'));
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveThird(Request $request, $key)
    {
        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_SECOND);
        if (empty($hasCode) || $hasCode != $code) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        $this->validate($request, [
            'img' => 'required',
            'id_card_type' => 'required'
        ], [], [
            'img' => '照片',
            'id_card_type' => '证件类型'
        ]);
        $data = $request->only(['img', 'id_card_type', 'id_card_face', 'id_card_nation', 'house_img', 'passport_img']);

        if (empty($data['img']) || !File::hashExists($data['img'])) {
            return back()->withErrors(['img' => '照片不存在'])->withInput();
        }

        // 验证证件类型
        if (empty($data['id_card_type']) || !in_array($data['id_card_type'], [1, 2, 3])) {
            return back()->withErrors(['id_card_type' => __('validation.in', ['attribute' => '证件类型'])])->withInput();
        }

        switch ($data['id_card_type']) {
            case 1:
                if (empty($data['id_card_face']) || !File::hashExists($data['id_card_face'])) {
                    return back()->withErrors(['id_card_face' => '身份证头像面不存在'])->withInput();
                }
                if (empty($data['id_card_nation']) || !File::hashExists($data['id_card_nation'])) {
                    return back()->withErrors(['id_card_nation' => '身份证国徽面不存在'])->withInput();
                }
                unset($data['house_img']);
                unset($data['passport_img']);
                break;
            case 2:
                if (empty($data['house_img']) || !File::hashExists($data['house_img'])) {
                    return back()->withErrors(['house_img' => '户口照片不存在'])->withInput();
                }
                unset($data['id_card_face']);
                unset($data['id_card_nation']);
                unset($data['passport_img']);
                break;
            case 3:
                if (empty($data['passport_img']) || !File::hashExists($data['passport_img'])) {
                    return back()->withErrors(['id_card_face' => '护照照片不存在'])->withInput();
                }
                unset($data['id_card_face']);
                unset($data['id_card_nation']);
                unset($data['house_img']);
                break;
        }

        $data['step'] = 3;
        $user->fill($data);
        if (!$user->save()) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        return $this->redirectStep($user);
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function last(Request $request, $key)
    {
        $code = $this->decryptKey($key, self::KEY_TYPE_THIRD);
        if (empty($code)) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        $user = User::where('code', $code)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __('Your request is not allowed. Please refresh and try again.'))->withInput();
        }

        $isVerify = false;
        $isPayment = false;
        if ($user->id_card_type == 1) {
            if (Face::verify($user)) {
                $isVerify = true;
            } else if (Payment::hasNoUsed($user)) {
                $isPayment = true;
            }
        }
        $prevKey = $this->encryptKey($user->code, self::KEY_TYPE_SECOND);
        $prev = route('register.third', ['key' => $prevKey]);

        return frontendView('register.last', compact('user', 'prev', 'key', 'isVerify', 'isPayment'));
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveLast(Request $request, $key)
    {
        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_THIRD);
        if (empty($hasCode) || $hasCode != $code) {
            return redirect()->route('register')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id || $user->is_complete) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'password' => __('Password'),
            'password_confirmation' => __('Confirm Password'),
        ]);

        if ($user->id_card_type == 1) {
            // 检查是否验证身份证
            if (!Face::verify($user)) {
                return back()->withErrors(['check_id_card' => '身份证验证未通过'])->withInput();
            }
        }

        $data = $request->only(['password']);
        $data['password'] = bcrypt($data['password']);
        $data['step'] = 4;
        $data['is_complete'] = 1;
        $data['type'] = 1;
        $data['register_time'] = time();
        $user->fill($data);
        if (!$user->save()) {
            return back()->with('error', __(':attribute failed', ['attribute' => __('Register')]))->withInput();
        }

        // 注册成功删除临时session
        $this->delSessionKey();

        return redirect()->route('login')->with('success', __(':attribute success', ['attribute' => __('Register')]));
    }

    /**
     * 上传预处理
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function preProcess(Request $request, $key)
    {
        if (!$this->decryptKey($key, self::KEY_TYPE_SECOND)) {
            return response()->json(['error' => __('Your request is not allowed. Please refresh and try again.')]);
        }

        $fileName = $request->input('file_name');
        $fileSize = $request->input('file_size');
        $fileHash = $request->input('file_hash');
        $type = $request->input('type');

        $chunkUpload = new ChunkUpload();
        $res = $chunkUpload->setType($type)
            ->setMaxSize(self::MAX_IMAGE_SIZE)
            ->preProcess($fileName, $fileSize, $fileHash);
        if ($res === false) {
            return response()->json(['error' => $chunkUpload->getMessage()]);
        }

        return response()->json($res);
    }

    /**
     * 分片上传图片
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveChunk(Request $request, $key)
    {
        if (!$this->decryptKey($key, self::KEY_TYPE_SECOND)) {
            return response()->json(['error' => __('Your request is not allowed. Please refresh and try again.')]);
        }

        $fileName = $request->input('file_name');
        $subDir = $request->input('sub_dir');
        $uploadBasename = $request->input('upload_basename');
        $type = $request->input('type');
        $chunkIndex = $request->input('chunk_index');
        $chunkTotal = $request->input('chunk_total');
        $uploadExt = $request->input('upload_ext');
        $file = $request->file('file');

        $chunkUpload = new ChunkUpload();
        $res = $chunkUpload->setType($type)
            ->setFileSubDir($subDir)
            ->setMaxSize(self::MAX_IMAGE_SIZE)
            ->setOrigName($fileName)
            ->saveChunk($file, $chunkIndex, $chunkTotal, $uploadBasename, $uploadExt);
        if ($res === false) {
            return response()->json(['error' => $chunkUpload->getMessage()]);
        }

        return response()->json($res);
    }

    /**
     * 注册支付
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(Request $request, $key)
    {
        $json = [
            'error' => 0,
            'message' => '',
            'pay' => 0,
            'code' => '',
            'image' => ''
        ];

        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_THIRD);
        if (empty($hasCode) || $hasCode != $code) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        if (Payment::hasNoUsed($user)) {
            $json['pay'] = 1;
            $json['message'] = '您有已经支付过并未验证身份证的支付单,验证中...';
            return response()->json($json);
        }

        $outTradeNo = Payment::newOutTradeNo();
        $totalFee = $this->getRegisterTotalFee();
        $description = '注册验证身份证';

        $paymentData = [
            'user_id' => $user->id,
            'code' => $user->code,
            'out_trade_no' => $outTradeNo,
            'total_fee' => $totalFee,
            'description' => $description,
            'payment_method' => 'wxpay_native',
        ];
        if ($totalFee <= 0) {
            $paymentData['status'] = 1;
        }
        $status = Payment::create($paymentData);
        if (!$status) {
            $json['error'] = 1;
            $json['message'] = '暂时无法支付,请重试或联系客服';
            return response()->json($json);
        }

        if ($totalFee <= 0) {
            $json['pay'] = 1;
            $json['message'] = '无需支付,验证中...';
            return response()->json($json);
        }

        $wxpay = new WxNativePay();
        $result = $wxpay->setOutTradeNo($outTradeNo)
            ->setTotalFee($totalFee * 100)
            ->setBody($description)
            ->setNotifyUrl(route('wxpay.notify'))
            ->pay();

        if (!$result) {
            $json['error'] = 1;
            $json['message'] = '暂时无法支付,请重试或联系客服';
            return response()->json($json);
        }
        $json['code'] = $outTradeNo;
        $json['image'] = QrCode::size(300)->generate($result);

        return response()->json($json);
    }

    /**
     * 验证是否已经支付
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPayment(Request $request, $key)
    {
        $json = [
            'error' => 0,
            'message' => '',
            'pay' => 0,
        ];

        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');
        $outTradeNo = $request->input('out_trade_no');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_THIRD);
        if (empty($hasCode) || $hasCode != $code) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        $payment = Payment::where('out_trade_no', $outTradeNo)->first();
        if ($payment && $payment->id && $payment->status && $payment->payment_time) {
            $json['pay'] = 1;
        }

        return response()->json($json);
    }

    /**
     * 验证身份证
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $key)
    {
        $json = [
            'error' => 0,
            'message' => '',
            'verify' => 0,
        ];

        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key, self::KEY_TYPE_THIRD);
        if (empty($hasCode) || $hasCode != $code) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->first();
        if (!$user || !$user->id) {
            $json['error'] = 1;
            $json['message'] = __('Your request is not allowed. Please refresh and try again.');
            return response()->json($json);
        }

        // 检查用户是否已经包含验证的信息
        if (Face::verify($user)) {
            $json['verify'] = 1;
        } else {
            // 验证是否已经支付过
            $payment = Payment::hasNoUsed($user);
            if (!$payment) {
                $json['error'] = 1;
                $json['message'] = '请先支付';
                return response()->json($json);
            }

            // 验证 face++
            $face = Face::add($user, $payment);
            if (!$face) {
                $json['error'] = 1;
                $json['message'] = '暂时无法识别, 请稍后重试';
                return response()->json($json);
            }

            $facePlus = new FacePlusPlus();
            $cards = $facePlus->verifyIdCard($user->id_card_face);
            if ($cards === false) {
                $json['error'] = 1;
                $json['message'] = '暂时无法识别, 请稍后重试';
                Log::notice($facePlus->getMessage());
                return response()->json($json);
            }

            $faceResult = $facePlus->getResult();
            $status = -1;
            if (!empty($cards)) {
                foreach ($cards as $card) {
                    if (!is_array($card) || !array_key_exists('id_card_number', $card) || !array_key_exists('side', $card)) {
                        continue;
                    }
                    if ($card['side'] == 'front' && $card['id_card_number'] == $user->id_card) {
                        $status = 1;
                        break;
                    }
                }
            }

            $face->status = $status;
            $face->verify_time = time();
            $face->remark = $faceResult;
            if (!$face->save()) {
                $json['error'] = 1;
                $json['message'] = '暂时无法识别, 请稍后重试';
                return response()->json($json);
            }
            $json['verify'] = $status;
        }

        return response()->json($json);
    }

    /**
     * 获取注册支付金额
     * @return float|int
     */
    private function getRegisterTotalFee()
    {
        $totalFee = config('site.register.money');
        return is_numeric($totalFee) && $totalFee > 0 ? $totalFee : 0;
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectStep(User $user)
    {
        if ($user->is_complete) {
            return redirect()->route('login');
        }

        $step = intval($user->step);
        $step < 0 and $step = 1;

        switch ($step) {
            case 1:
                $key = $this->encryptKey($user->code, self::KEY_TYPE_FIRST);
                return redirect()->route('register.second', ['key' => $key]);
                break;
            case 2:
                $key = $this->encryptKey($user->code, self::KEY_TYPE_SECOND);
                return redirect()->route('register.third', ['key' => $key]);
                break;
            case 3:
                $key = $this->encryptKey($user->code, self::KEY_TYPE_THIRD);
                return redirect()->route('register.last', ['key' => $key]);
                break;
            default:
                return redirect()->route('login');
        }
    }

    /**
     * 加密访问key
     * @param $key
     * @param $type
     * @return null|string
     */
    private function encryptKey($key, $type = self::KEY_TYPE_FIRST)
    {
        if (!in_array($type, [self::KEY_TYPE_FIRST, self::KEY_TYPE_SECOND, self::KEY_TYPE_THIRD])) {
            return null;
        }
        if (!($encryptKey = $this->getSessionKey($type))) {
            $encryptKey = encryptTempStr($key);
            $this->setSessionKey($encryptKey, $type);
        }

        return $encryptKey;
    }

    /**
     * 解密访问key
     * @param $key
     * @param $type
     * @return bool|string
     */
    private function decryptKey($key, $type = self::KEY_TYPE_FIRST)
    {
        $origKey = decryptTempStr($key);
        if (empty($origKey) || !($hasKey = $this->getSessionKey($type)) || $hasKey != $key) {
            return false;
        }

        return $origKey;
    }

    /**
     * 存储session信息
     * @param $value
     * @param string $type
     * @param bool $isCover
     */
    private function setSessionKey($value, $type = self::KEY_TYPE_FIRST, $isCover = true)
    {
        if ($isCover || !Session::has('register.key.' . $type)) {
            Session::put('register.key.' . $type, $value);
        }
    }

    /**
     * 获取存储的session信息
     * @param string $type
     * @return null|string
     */
    private function getSessionKey($type = self::KEY_TYPE_FIRST)
    {
        if (Session::has('register.key.' . $type)) {
            return Session::get('register.key.' . $type);
        }

        return null;
    }

    /**
     * 删除存储的session信息
     * @param null $type
     */
    private function delSessionKey($type = null)
    {
        $full = [self::KEY_TYPE_FIRST, self::KEY_TYPE_SECOND, self::KEY_TYPE_THIRD];
        if ($type === null) {
            foreach ($full as $key) {
                Session::forget('register.key.' . $key);
            }
        } else if (in_array($type, $full)) {
            Session::forget('register.key.' . $type);
        }
    }
}
