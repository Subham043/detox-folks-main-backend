<?php

namespace App\Modules\Promoter\Services;

use App\Enums\OrderEnumStatus;
use App\Modules\Authentication\Models\User;
use App\Modules\Promoter\Models\Promoter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Collection;

class PromoterService
{

    public function paginatePromoter(Int $total = 10): LengthAwarePaginator
    {
        $query = User::with([
            'roles',
            'app_promoter_code',
            'app_installer' => function ($query) {
                $query->withCount([
                    'orders' => function ($query) {
                        $query->whereHas('current_status', function($qr) {
                            $qr->where('status', '!=', OrderEnumStatus::CANCELLED);
                        })->whereHas('user', function($q) {
                            $q->whereHas('roles', function($qr) {
                                $qr->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']);
                            });
                        });
                    }
                ])->whereHas('roles', function($q) {
                    $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']);
                });
            },
        ])->whereHas('app_promoter_code')->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })
        ->withCount([
            'app_installer' => function ($query) {
                $query->whereHas('roles', function($q) {
                    $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']);
                });
            },
        ])
        ->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new AgentFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getPromoterById(Int $id): User|null
    {
        return User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })->findOrFail($id);
    }

    public function getInstallerById(Int $id): User|null
    {
        return User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']); })->findOrFail($id);
    }

    public function paginateInstaller($agent_id, Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(User::with(['roles', 'app_promoter'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']); })
        ->whereHas('app_promoter', function($q) use($agent_id) {
            $q->where('promoted_by_id', $agent_id);
        }))
        ->withCount([
            'orders' => function ($query) {
                $query->whereHas('current_status', function($q) {
                    $q->where('status', '!=', OrderEnumStatus::CANCELLED);
                });
            }
        ])
        ->defaultSort('-id')
        ->allowedFilters([
            AllowedFilter::callback('has_date', function (Builder $query, $value) {
                $date = explode(' - ', $value);
                $query->whereBetween('created_at', [...$date]);
            }),
            AllowedFilter::callback('has_role', function (Builder $query, $value) {
                $query->whereHas('roles', function($q) use($value) {
                    $q->where('name', $value);
                });
            }),
            AllowedFilter::custom('search', new AgentFilter),
        ])
        ->paginate($total)
        ->appends(request()->query());
    }

    public function exportInstaller($agent_id): Collection
    {
        return QueryBuilder::for(User::with(['roles', 'app_promoter'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User']); })
        ->whereHas('app_promoter', function($q) use($agent_id) {
            $q->where('promoted_by_id', $agent_id);
        }))
        ->withCount([
            'orders' => function ($query) {
                $query->whereHas('current_status', function($q) {
                    $q->where('status', '!=', OrderEnumStatus::CANCELLED);
                });
            }
        ])
        ->defaultSort('-id')
        ->allowedFilters([
            AllowedFilter::callback('has_date', function (Builder $query, $value) {
                $date = explode(' - ', $value);
                $query->whereBetween('created_at', [...$date]);
            }),
            AllowedFilter::callback('has_role', function (Builder $query, $value) {
                $query->whereHas('roles', function($q) use($value) {
                    $q->where('name', $value);
                });
            }),
            AllowedFilter::custom('search', new AgentFilter),
        ])
        ->get();
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

    public function toggle(Int $user_id, Int $agent_id)
    {
        $promoter = Promoter::where('installed_by_id', $user_id)->where('promoted_by_id', $agent_id)->firstOrFail();
        $promoter->is_approved = !$promoter->is_approved;
        $promoter->save();
        // dd($promoter);
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
