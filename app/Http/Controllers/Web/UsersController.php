<?php

namespace App\Http\Controllers\Web;

use Hash;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;

class UsersController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) 
    {
 
        $this->userRepository = $userRepository;
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

        if ($user->isCurrent()) {
            $this->viewData['user'] = $user;

            return view('web.users.profile', $this->viewData);
        }

       return redirect()->back()->withErrors(trans('front-end/users.profile.permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request, $id)
    {
        $input = $request->all();
        $data = $request->only('name', 'email');
        $user = $this->userRepository->find($id);

        if (!$user->isCurrent()) {
            return redirect()->action('Web\UsersController@edit', ['id' => Auth::user()->id])
                ->withErrors(trans('front-end/users.profile.permission'));
        }
        
        if (!empty($input['password'])) {

            if (!Hash::check($input['current_password'], Auth::user()->password)) {

                return redirect()->back()->withErrors(trans('front-end/users.password.wrong-current-password'));
            }

            $data['password'] = $input['password'];
        }

        if (!empty($input['chatwork_id'])) {
            $data['chatwork_id'] = $input['chatwork_id'];
        }

        $result = $this->userRepository->updateProfile($data, $id);

        if ($result) {
            return redirect()->action('Web\UsersController@edit', ['id' => $id])
                ->with('status', trans('front-end/users.profile.update-success'));
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
        try {
            $user = $this->userRepository->find($id);

            if ($user->isCurrent()) {
                $this->userRepository->delete($id);

                return redirect()->back();
            }

            return redirect()->action('Web\UsersController@edit', ['id' => Auth::user()->id])
                ->withErrors(trans('front-end/users.profile.delete-permission'));
        } catch (Exception $e) {
            Log::debug($e);
        }

         return redirect()->back()
            ->withErrors(trans('front-end/users.profile.delete-fail'));
    }
}
