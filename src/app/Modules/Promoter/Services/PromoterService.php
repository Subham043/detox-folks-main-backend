<?php

namespace App\Modules\Promoter\Services;

use App\Modules\Authentication\Models\User;
use App\Modules\Promoter\Models\Promoter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class PromoterService
{

    public function paginatePromoter(Int $total = 10): LengthAwarePaginator
    {
        $query = User::with(['roles', 'app_promoter_code'])->whereHas('app_promoter_code')->whereHas('roles', function($q) { $q->where('name', 'App Promoter'); })->withCount('app_installer')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new AgentFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getPromoterById(Int $id): User|null
    {
        return User::with(['roles'])->whereHas('roles', function($q) { $q->where('name', 'App Promoter'); })->findOrFail($id);
    }

    public function getInstallerById(Int $id): User|null
    {
        return User::with(['roles'])->whereHas('roles', function($q) { $q->where('name', 'User'); })->findOrFail($id);
    }

    public function paginateInstaller($agent_id, Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(User::with(['roles', 'app_promoter'])->whereHas('roles', function($q) { $q->where('name', 'User'); })
        ->whereHas('app_promoter', function($q) use($agent_id) {
            $q->where('promoted_by_id', $agent_id);
        }))
        ->defaultSort('-id')
        ->allowedFilters([
            AllowedFilter::callback('has_date', function (Builder $query, $value) {
                $date = explode(' - ', $value);
                $query->whereBetween('created_at', [...$date]);
            }),
            AllowedFilter::custom('search', new AgentFilter),
        ])
        ->paginate($total)
        ->appends(request()->query());
    }

    public function promote(String $email, Int $agent_id)
    {
        $user = User::where('email', $email)->first();
        if($user){
            $promoter = Promoter::where('installed_by_id', $user->id)->first();
            if($promoter){
                throw new \Exception('The user is already promoted by another agent');
            }else{
                $promoter = new Promoter();
                $promoter->installed_by_id = $user->id;
                $promoter->promoted_by_id = $agent_id;
                $promoter->save();
            }
        }
    }

    public function destroy(Int $user_id, Int $agent_id)
    {
        $promoter = Promoter::where('installed_by_id', $user_id)->where('promoted_by_id', $agent_id)->firstOrFail();
        $promoter->delete();
    }

}

class AgentFilter implements Filter
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
