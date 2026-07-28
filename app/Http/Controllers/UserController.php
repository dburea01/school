<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    use AuthorizesRequests;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userRepository->searchPaginated($request->all());
        $totalUsers = User::count();

        return view('users.index', [
            'users' => $users,
            'total_users' => $totalUsers,
            'search' => $request->query('search', ''),
            'role' => $request->query('role', '')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        $user = new User;
        $user->role = 'STUDENT';
        $user->country_id = 'FR';

        return view('users.edit', [
            'user' => $user,
            'readonly' => false,
            'pageTitle' => 'Créer utilisateur'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());

            if ($request->can_connect == 1) {
                $this->userService->sendActivationEmail($user);
                $message = $user->full_name.' créé. Un email a été envoyé pour valider son accés.';
            } else {
                $message = $user->full_name.' créé';
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return back()->with('error', 'Erreur, utilisateur non créé')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('users.edit', [
            'user' => $user,
            'readonly' => true,
            'pageTitle' => 'Fiche utilisateur'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'readonly' => false,
            'pageTitle' => 'Modifier utilisateur'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, StoreUserRequest $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $user->fill($request->validated());

            $message = $user->full_name.' modifié';

            if ($user->isDirty('can_connect')) {
                $isNowAllowed = (bool) $user->can_connect;
                $wasAllowed = (bool) $user->getOriginal('can_connect');
                if ($isNowAllowed && ! $wasAllowed) {
                    $this->userService->sendActivationEmail($user);
                    $message = $user->full_name.' modifié. Un email a été envoyé pour valider son accés.';
                }
            }

            $user->save();
            DB::commit();

            return redirect()->route('users.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return back()->with('error', 'Error, utilisateur non modifié')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $user->delete();

            return back()->with('success', "$user->full_name supprimé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, utilisateur non supprimé')->withInput();
        }
    }

    public function duplicated(Request $request): ResourceCollection
    {
        /** @var string $lastName */
        $lastName = $request->last_name;
        /** @var string $firstName */
        $firstName = $request->first_name;
        /** @var string $existingUserId */
        $existingUserId = $request->id;

        abort_if(Str::of($lastName)->trim()->isEmpty(), 400, 'Nom est vide');
        $this->authorize('viewAny', User::class);

        $duplicatedUsers = $this->userRepository->getDuplicatedUsers($existingUserId, $lastName, $firstName);

        return UserResource::collection($duplicatedUsers);
    }
}
