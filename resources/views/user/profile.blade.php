@extends('user.layouts')
@section('css')
    <link href="/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top: 0px; min-height: 354px;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('successMsg'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{Session::get('successMsg')}}
                    </div>
                @endif
                @if (Session::has('errorMsg'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>{{trans('home.error')}}：</strong> {{Session::get('errorMsg')}}
                    </div>
                @endif
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">{{trans('home.profile')}}</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab">{{trans('home.password')}}</a>
                                        </li>
                                        <li>
                                            <a href="#tab_2" data-toggle="tab">{{trans('home.contact')}}</a>
                                        </li>
                                        <li>
                                            <a href="#tab_3" data-toggle="tab">{{trans('home.ssr_setting')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <form action="{{url('profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.current_password')}}</label>
                                                    <input type="password" class="form-control" name="old_password" id="old_password" autofocus required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.new_password')}}</label>
                                                    <input type="password" class="form-control" name="new_password" id="new_password" required />
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class=" col-md-4">
                                                            <button type="submit" class="btn green">{{trans('home.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab_2">
                                            <form action="{{url('profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label">{{trans('home.wechat')}}</label>
                                                    <input type="text" class="form-control" name="wechat" value="{{$info->wechat}}" id="wechat" required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"> QQ </label>
                                                    <input type="text" class="form-control" name="qq" value="{{$info->qq}}" id="qq" required />
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn green">{{trans('home.submit')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab_3">
                                            <form action="{{url('profile')}}" method="post" enctype="multipart/form-data" class="form-bordered">
                                                <div class="form-group">
                                                    <label class="control-label"> {{trans('home.connection_password')}} </label>
                                                    <input type="text" class="form-control" name="passwd" value="{{$info->passwd}}" id="passwd" required />
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                                </div>
                                                <div class="form-group">
                                                <label for="protocol" class="col-md-3 control-label">协议</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="protocol" id="protocol">
                                                        @foreach ($protocol_list as $protocol)
                                                            <option value="{{$protocol->name}}" @if($protocol->name == $user->protocol) selected @endif>{{$protocol->name}}</option>
                                                        @endforeach
                                                                    var protocol = $('#protocol').val();

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="obfs" class="col-md-3 control-label">混淆</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="obfs" id="obfs">
                                                        @foreach ($obfs_list as $obfs)
                                                            <option value="{{$obfs->name}}" @if($obfs->name == $user->obfs) selected @endif>{{$obfs->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn green"> {{trans('home.submit')}} </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
<script src="/assets/global/plugins/laydate/laydate.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 用户标签选择器
        $('#labels').select2({
            theme: 'bootstrap',
            placeholder: '设置后则可见相同标签的节点',
            allowClear: true
        });

        // 有效期-开始
        laydate.render({
            elem: '#enable_time'
        });

        // 有效期-结束
        laydate.render({
            elem: '#expire_time'
        });

        // ajax同步提交
        function do_submit() {
            var _token = '{{csrf_token()}}';
            var id = '{{Request::get('id')}}';
            var username = $('#username').val();
            var password = $('#password').val();
            var pay_way = $("input:radio[name='pay_way']:checked").val();
            var balance = $('#balance').val();
            var score = $('#score').val();
            var status = $("input:radio[name='status']:checked").val();
            var labels = $('#labels').val();
            var enable_time = $('#enable_time').val();
            var expire_time = $('#expire_time').val();
            var gender = $("input:radio[name='gender']:checked").val();
            var wechat = $('#wechat').val();
            var qq = $('#qq').val();
            var is_admin = $("input:radio[name='is_admin']:checked").val();
            var remark = $('#remark').val();
            var level = $("#level option:selected").val();
            var port = $('#port').val();
            var passwd = $('#passwd').val();
            var method = $('#method').val();
            var transfer_enable = $('#transfer_enable').val();
            var enable = $("input:radio[name='enable']:checked").val();
            var protocol = $('#protocol').val();
            var protocol_param = $('#protocol_param').val();
            var obfs = $('#obfs').val();
            var obfs_param = $('#obfs_param').val();
            var speed_limit_per_con = $('#speed_limit_per_con').val();
            var speed_limit_per_user = $('#speed_limit_per_user').val();
            var vmess_id = $('#vmess_id').val();

            // 用途
            var usage = '';
            $.each($("input:checkbox[name='usage']"), function(){
                if (this.checked) {
                    usage += $(this).val() + ',';
                }
            });
            usage = usage.substring(0, usage.length - 1);

            $.ajax({
                type: "POST",
                url: "{{url('admin/editUser')}}",
                async: false,
                data: {
                    _token:_token,
                    id:id,
                    username: username,
                    password:password,
                    usage:usage,
                    pay_way:pay_way,
                    balance:balance,
                    score:score,
                    status:status,
                    labels:labels,
                    enable_time:enable_time,
                    expire_time:expire_time,
                    gender:gender,
                    wechat:wechat,
                    qq:qq,
                    is_admin:is_admin,
                    remark:remark,
                    level:level,
                    port:port,
                    passwd:passwd,
                    method:method,
                    transfer_enable:transfer_enable,
                    enable:enable,
                    protocol:protocol,
                    protocol_param:protocol_param,
                    obfs:obfs,
                    obfs_param:obfs_param,
                    speed_limit_per_con:speed_limit_per_con,
                    speed_limit_per_user:speed_limit_per_user,
                    vmess_id: vmess_id
                },
                dataType: 'json',
                success: function (ret) {
                    if (ret.status == 'success') {
                        layer.confirm('更新成功，是否返回？', {icon: 1, title:'提示'}, function(index) {
                            window.location.href = '{{url('admin/userList?page=') . Request::get('page')}}';

                            layer.close(index);
                        });
                    } else {
                        layer.msg(ret.message, {time:1000});
                    }
                }
            });

            return false;
        }

    </script>

@endsection