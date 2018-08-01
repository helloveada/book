<?php
namespace App\Http\Controllers\Service;
use App\Entity\TempPhone;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use App\Models\M3Result;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;


class ValidateController extends Controller
{
    public function create(){
        $validateCode = new ValidateCode();
        return $validateCode->doimg();
    }

    public function sendSMS(Request $request)
    {
        //测试手机号 17000204093
        $result = new M3Result;
        $phone = $request->input('phone',null);
        if($phone == ''){
            $result->status = 1;
            $result->message = '手机号不能为空';
            return $result->toJson();
        }
        if(strlen($phone) != 11 & $phone['0'] != 1){
            $result->status = 2;
            $result->message = '手机号格式不正确';
            return $result->toJson();
        }

        $charset = '0123456789';//随机因子
        $code = '';
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, 6)];
        }

        $sendTemplateSMS = new SendTemplateSMS;
        $result = $sendTemplateSMS->sendTemplateSMS($phone,array($code,60),1);
        if($result->status == 0){
            $tmpPhone = TempPhone::where('phone',$phone)->first();
            if($tmpPhone == null){
                $tmpPhone = new TempPhone();
            }
            $tmpPhone->phone = $phone;
            $tmpPhone->code = $code;
            $tmpPhone->deadline = date('Y-m-d H:i:s',time()+60*60);
            $tmpPhone->save();
        }
        return $result->toJson();
    }


}
