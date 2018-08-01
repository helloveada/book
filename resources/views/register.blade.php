@extends('master')

@section('title', '注册')

@section('content')
    <div class="weui_cells_title">注册方式</div>
    <div class="weui_cells weui_cells_radio">
        <label class="weui_cell weui_check_label" for="x11">
            <div class="weui_cell_bd weui_cell_primary">
                <p>手机号注册</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x11" checked="checked">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
        <label class="weui_cell weui_check_label" for="x12">
            <div class="weui_cell_bd weui_cell_primary">
                <p>邮箱注册</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x12">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name="phone"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone_cfm'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name='phone_code'/>
            </div>
            <p class="bk_important bk_phone_code_send">发送验证码</p>
            <div class="weui_cell_ft">
            </div>
        </div>
    </div>
    <div class="weui_cells weui_cells_form" style="display: none;">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="" name='email'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email'>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email_cfm'/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="请输入验证码" name='validate_code'/>
            </div>
            <div class="weui_cell_ft">
                <img src="/service/validate/create" class="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onRegisterClick();">注册</a>
    </div>
    <a href="/login" class="bk_bottom_tips bk_important">已有帐号? 去登录</a>
@endsection

@section('my-js')
<script type="text/javascript">
    $(function(){
        $('#x12').next().hide();
        $('input:radio[name=register_type]').click(function(event) {
            $('input:radio[name=register_type]').attr('checked', false);
            $(this).attr('checked', true);
            if($(this).attr('id') == 'x11') {
                $('#x11').next().show();
                $('#x12').next().hide();
                $('.weui_cells_form').eq(0).show();
                $('.weui_cells_form').eq(1).hide();
            } else if($(this).attr('id') == 'x12') {
                $('#x12').next().show();
                $('#x11').next().hide();
                $('.weui_cells_form').eq(1).show();
                $('.weui_cells_form').eq(0).hide();
            }
        });
    });


    $('.bk_validate_code').click(function () {
        $(this).attr('src', '/service/validate/create?random=' + Math.random());
    });
    var enable = true;
    $('.bk_phone_code_send').click(function(){
        if(enable == false){
            return;
        }
        var phone = $('input[name=phone]').val();

        if(phone == ''){
            $('.bk_toptips').show();
            $('.bk_toptips span').html('手机号不能为空');
            setTimeout(function(){$('.bk_toptips span').hide()},2000);
            return;
        }

        if(phone.length != 11 || phone[0] != 1){
            $('.bk_toptips').show();
            $('.bk_toptips span').html('手机号格式错误');
            setTimeout(function(){$('.bk_toptips span').hide()},2000);
            return;
        }
        $(this).removeClass('bk_important');
        $(this).addClass('bk_summary');
        enable = false;
        var num = 60;
        var interval = window.setInterval(function(){
            $('.bk_phone_code_send').html(--num + 's 重新发送');
            if(num  == 0){
                $('.bk_phone_code_send').removeClass('bk_summary');
                $('.bk_phone_code_send').addClass('bk_important');
                enable = true;
                window.clearInterval(interval);
                $('.bk_phone_code_send').html('重新发送');
            }
        },1000);

        $.ajax({
            url:'/service/validate/send',
            dataType:'json',
            data:{phone:phone},
            success:function(responseData){
                if(responseData == null){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function(){$('.bk_toptips span').hide()},2000);
                    return;
                }
                $('.bk_toptips').show();
                $('.bk_toptips span').html(responseData.message);
                setTimeout(function(){$('.bk_toptips span').hide()},2000);
                return;
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    })

</script>
@endsection
