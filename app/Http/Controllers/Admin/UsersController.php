<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;
use App\Http\Requests\UserManage;
use Exception;
use Log;

class UsersController extends BaseController
{
    /**
     * @var Subject
     */
    private $userRepository;
 
    public function __construct(UserRepository $userRepository) {
 
        $this->userRepository = $userRepository;
        $this->viewData['title'] = trans('admin/user.title');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['users'] = $this->userRepository->paginate();

        return view('admin.user.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserManage $request)
    {
        try {
            $input = $request->only('name', 'email', 'role');
            $input['password'] = config('user.password.default');
            $this->userRepository->create($input);
        } catch (Exception $e) {
            Log::debug($e);

            return back()->withErrors(trans('messages.errors.create'));
        }
        
        return redirect()->action('Admin\UsersController@index')
            ->with('status', trans('messages.success.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->viewData['user'] = $this->userRepository->find($id);

        return view('admin.user.detail', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if ($user->isMember()) {
            $this->viewData['user'] = $user;

            return view('admin.user.edit', $this->viewData);
        }

        return redirect()->action('Admin\UsersController@show', ['id' => $id])
            ->withErrors(trans('admin/user.update.permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserManage $request, $id)
    {
        $user = $this->userRepository->find($id);

        try {
            if ($user->isMember()) {
                $data = $request->only('name', 'email', 'role');
                $this->userRepository->update($data, $id);

                return redirect()->action('Admin\UsersController@show', ['id' => $id])
                    ->with('status', trans('messages.success.update'));
            }

            return redirect()->action('Admin\UsersController@show', ['id' => $id])
                ->withErrors(trans('admin/user.update.permission'));
            
        } catch (Exception $e) {
            Log::debug($e);

            return back()->withErrors(trans('messages.errors.update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if ($user->isMember()) {
            $this->userRepository->delete($id);

            return redirect()->action('Admin\UsersController@index')
                ->with('status', trans('messages.success.delete'));
        }
        
        return redirect()->action('Admin\UsersController@index')
            ->withErrors(trans('admin/user.delete.permission'));
    }
}
