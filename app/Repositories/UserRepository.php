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
    public function getDuplicatedUsers(?string $postalCode, string $lastName, ?string $firstName, ?string $ignoreId)
    {
        $query = User::orderBy('last_name');

        // 1. Filter on the postal code (if known)
        $query->when(! empty($postalCode), function ($q) use ($postalCode) {
            $q->where('postal_code', $postalCode);
        });

        // 2. Filter on first_name / last_name (and vice versa)
        $query->where(function ($subQuery) use ($lastName, $firstName) {

            // Case : last_name in last_name AND firt_name in first_name
            $subQuery->where(function ($q) use ($lastName, $firstName) {
                $q->where('last_name', 'ilike', '%'.$lastName.'%');
                if (! empty($firstName)) {
                    $q->where('first_name', 'ilike', '%'.$firstName.'%');
                }
            })
                // Cas : vice versa
                ->orWhere(function ($q) use ($lastName, $firstName) {
                    $q->where('first_name', 'ilike', '%'.$lastName.'%');
                    if (! empty($firstName)) {
                        $q->where('last_name', 'ilike', '%'.$firstName.'%');
                    }
                });
        });

        // 3. exclude the current id for the modification case
        $query->when(! empty($ignoreId), function ($q) use ($ignoreId) {
            $q->where('id', '<>', $ignoreId);
        });

        return $query->get();
    }
}
