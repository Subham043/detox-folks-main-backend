<?php

namespace App\Modules\User\Services;

use App\Modules\Authentication\Models\User;
use App\Modules\BillingInformation\Models\BillingInformation;
use App\Modules\Promoter\Models\PromoterCode;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class UserService
{

    public function all(): Collection
    {
        return User::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = User::with('roles')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                    AllowedFilter::callback('has_role', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('roles', function($q) use($value) {
                                $q->where('name', $value);
                            });
                        }
                    }),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): User|null
    {
        return User::with('roles')->findOrFail($id);
    }

    public function getByEmail(String $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function create(array $data): User
    {
        $user = User::create([
            ...$data,
            'email' => empty($data['email']) ? null : $data['email']
        ]);
        $code = $this->generateUniqueCode();
        PromoterCode::create([
            'promoter_id' => $user->id,
            'code' => $code,
        ]);
        BillingInformation::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'gst' => null,
            'is_active' => true,
            'user_id' => $user->id,
        ]);
        return $user;
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }

        if (PromoterCode::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;

    }

    public function update(array $data, User $user): User
    {
        $user->update([
            ...$data,
            'email' => empty($data['email']) ? null : $data['email']
        ]);
        return $user;
    }

    public function syncRoles(array $roles = [], User $user): void
    {
        $user->syncRoles($roles);
    }

    public function delete(User $user): bool|null
    {
        return $user->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}
