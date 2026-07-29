<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * @param  array<string>  $request
     * @return Builder<User>
     */
    public function getSearchQuery(array $request)
    {
        $query = User::orderBy('last_name');

        $query->when(isset($request['search']), function ($q) use ($request) {
            return $q->where(function (Builder $q2) use ($request) {
                $q2->where('first_name', 'ilike', '%'.$request['search'].'%')
                    ->orWhere('last_name', 'ilike', '%'.$request['search'].'%')
                    ->orWhere('email', 'ilike', '%'.$request['search'].'%');
            });
        });

        $query->when(isset($request['role']), function ($q) use ($request) {
            return $q->where('role', $request['role']);
        });

        $query->when(isset($request['status']), function ($q) use ($request) {
            return $q->where('status', $request['status']);
        });

        return $query;
    }

    /**
     * @param  array<string>  $filters
     * @return LengthAwarePaginator<int,User>
     */
    public function searchPaginated(array $filters)
    {
        return $this->getSearchQuery($filters)->paginate(10);
    }

    /**
     * @return Collection<int,User>
     */
    public function getDuplicatedUsers(?string $ignoreId, string $lastName, ?string $firstName)
    {
        $query = User::orderBy('last_name');

        $query->where(function ($subQuery) use ($lastName) {
            $subQuery->where('last_name', 'ilike', '%'.$lastName.'%')
                ->orWhere('first_name', 'ilike', '%'.$lastName.'%');
        });

        $query->when(isset($ignoreId), function ($q) use ($ignoreId) {
            $q->where(function ($subQuery) use ($ignoreId) {
                $subQuery->where('id', '<>', $ignoreId);
            });
        });

        return $query->get();
    }
}
