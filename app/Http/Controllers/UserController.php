<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Validator;

class UserController extends Controller
{
    /**
     * Chuyển hướng người dùng sang  OAuth Provider.
     * OAuth Provider có thể là facebook, github, google
     * @return response social
     */
    public function redirectToProvider($social)
    {
        return Socialite::driver($social)->redirect();
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    public function handleProviderCallback($social)
    {
        // đăng nhập mxh
        $user     = Socialite::driver($social)->user();
        $authUser = $this->findOrCreateUser($user);
        // đăng nhập
        Auth::login($authUser);
        return back()->with('message', 'Đăng nhập thành công');
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    private function findOrCreateUser($user)
    {
        $authUser = User::where('social_id', $user->id)->first();
        if ($authUser)
        {
            return $authUser;
        } else
        {
            return User::create([
                'name'      => $user->name,
                'email'     => $user->email,
                'password'  => '',
                'social_id' => $user->id,
                'ruler'     => 0,
                'status'    => 0,
                'avatar'    => $user->avatar,
            ]);
        }
    }

    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
            return redirect('/');
        }
    }

    /**
     * đăng ký tài khoản
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $this->validate($request,
            [
                'name'        => 'required|min:2|max:255',
                'email'       => 'required|email|unique:users,email',
                'password'    => 'required|min:6|max:255',
                're_password' => 'required|same:password',
            ],
            [
                'name.required'        => 'họ và tên không được bỏ trống',
                'name.min'             => 'độ dài tối thiếu từ 2 đến 255 ký tự',
                'name.max'             => 'độ dài tối đa 255 ký tự',
                'email.required'       => 'email không được bỏ trống',
                'email.email'          => 'nhập không đúng định dạng email',
                'email.unique'         => 'email đã tồn tại trong hệ thống',
                'password.required'    => 'mật khẩu không được bỏ trống',
                'password.min'         => 'mật khẩu phải có ít nhất 6 ký tự',
                'password.max'         => 'mật khẩu tối đa có 255 ký tự',
                're_password.required' => 'xác nhận mật khẩu không được bỏ trống',
                're_password.same'     => 'không khớp với mật khẩu đã nhập',
            ]
        );
        $data             = $request->all();
        $data['password'] = Hash::make($request->password);
        $user             = User::create($data);
        Auth::login($user);
        return back()->with('message', 'Đăng ký tài khoản thành công');
    }

    /**
     * login Client
     *
     * @return \Illuminate\Http\Response
     */
    public function loginClient(Request $request)
    {
        $rules     = [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];
        $messages  = [
            'email.required'    => 'Email là trường bắt buộc',
            'email.email'       => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.min'      => 'Mật khẩu phải chứa ít nhất 6 ký tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } else
        {
            $data = $request->only('email', 'password');
            dd($data);
            die;
            if (Auth::attempt($data, $request->has('remember')))
            {
                return back()->with('message', 'Đăng nhập thành công');
            } else
            {
                return back()->with('error', 'Đăng nhập thất bại. Xin vui lòng kiểm tra lại tài khoản');
            }
        }
    }

    /**
     * login admin
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAdmin(Request $request)
    {
        $rules     = [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];
        $messages  = [
            'email.required'    => 'Email là trường bắt buộc',
            'email.email'       => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.min'      => 'Mật khẩu phải chứa ít nhất 6 ký tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return redirect()->back()->with('error','Sai tài khoản hoặc mật khẩu');
        } else
        {
            $data = $request->only('email', 'password');
            if (Auth::attempt($data, $request->has('remember')))
            {
                if (Auth::user()->role == 1)
                {
                    return redirect('/admin')->with('message', 'Đăng nhập thành công');
                } elseif (Auth::user()->role == 2){
                    return redirect()->route('product.index')->with('message','Đăng nhập thành công');
                } elseif (Auth::user()->role == 3){
                    return redirect()->route('order.index')->with('message','Đăng nhập thành công');
                } else {
                    return redirect()->route('admin.getLogin')->with('error','Truy cập bị từ chối, bạn không có quyền vào trang này');
                }
            } else
            {
                return back()->with('error', 'Đăng nhập thất bại. Xin vui lòng kiểm tra lại tài khoản');
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
