<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements IUserRepository
{
    private readonly Profile $_profile;

    public function __construct(User $user, Profile $profile)
    {
        parent::__construct($user);

        $this->_profile = $profile;
    }

    public function register(RegisterRequest $request): Model
    {
        $user = $this->_model->fill([
            "role_id" => 2,
            "username" => $request->username,
            "email" => $request->email,
        ]);

        $this->setAuditableInformationFromRequest($user, $request);

        $user->setAttribute('password', bcrypt($request->password));

        $user->save();

        $profile = new $this->_profile([
            "name" => $request->name,
            "address" => $request->address,
            "phone_number" => $request->phone_number,
            "sim_number" => $request->sim_number
        ]);

        $this->setAuditableInformationFromRequest($profile, $request);

        $user->profile()->save($profile);

        return $user->fresh();
    }
}
