<?php

    namespace App\Http\Controllers;


    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class IndexController extends Controller
    {
        public function login(Request $request)
        {
            //post请求
            if ($request->isMethod('post')) {
                $username = $request->username;
                $passwd = $request->passwd;

                //匹配用户名只能允许字母和数字
                if (!preg_match("/^[a-z\d]*$/i", $username)) {
                    return response()->json(['code' => 1001, 'data' => [], 'message' => '不合法的用户名']);
                }

                //查询数据库
                $user = DB::select("select * from user where username = '$username'");

                //对比密码
                if (!empty($user) && $user[0]->passwd == md5($passwd)) {
                    return response()->json(['code' => 0, 'data' => [], 'message' => '登录成功']);
                }

                return response()->json(['code' => 1002, 'data' => [], 'message' => '用户名或密码错误']);
            }
        }
    }