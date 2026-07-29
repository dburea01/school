<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserImageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    use AuthorizesRequests;

    private UserRepository $userRepository;
    private UserImageService $userImageService;

    public function __construct(UserRepository $userRepository, UserImageService $userImageService)
    {
        $this->userRepository = $userRepository;
        $this->userImageService = $userImageService;
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
            'role' => $request->query('role', ''),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        $user = new User;
        $user->role = UserRole::STUDENT;
        $user->country_id = 'FR';

        return view('users.edit', [
            'user' => $user,
            'readonly' => false,
            'pageTitle' => 'Créer utilisateur',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $user = User::create($request->validated() + ['status' => 'ACTIVE']);

            if ($request->hasFile('photo')) {
                $paths = $this->userImageService->store(
                    $user,
                    $request->file('photo')
                );

                $user->update($paths);
            }

            

            return redirect()->route('users.index')->with('success', "$user->full_name créé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

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
            'pageTitle' => 'Fiche utilisateur',
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
            'pageTitle' => 'Modifier utilisateur',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, StoreUserRequest $request): RedirectResponse
    {
        try {
            $user->fill($request->validated());
            $user->save();

            if ($request->hasFile('photo')) {
                $paths = $this->userImageService->store(
                    $user,
                    $request->file('photo')
                );

                $user->update($paths);
            }

            return redirect()->route('users.index')->with('success', "$user->full_name modifié");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, utilisateur non modifié')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $this->userImageService->delete($user);
            $user->delete();

            return back()->with('success', "$user->full_name supprimé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, utilisateur non supprimé')->withInput();
        }
    }

    public function checkDuplicates(Request $request): ResourceCollection
    {
        /** @var string $lastName */
        $lastName = $request->last_name;
        /** @var string $firstName */
        $firstName = $request->first_name;
        /** @var string $ignoreId */
        $ignoreId = $request->ignore_id;

        abort_if(Str::of($lastName)->trim()->isEmpty(), 400, 'Nom est vide');
        $this->authorize('viewAny', User::class);

        $duplicatedUsers = $this->userRepository->getDuplicatedUsers($ignoreId, $lastName, $firstName);

        return UserResource::collection($duplicatedUsers);
    }

    private function uploadPhoto(UploadedFile $file, ?User $user = null): array
    {
        // if the user is updated, we delete the previous photo
        if ($user) {
            $this->deleteUserPhotos($user);
        }

        // Nom unique pour le fichier
        $filename = Str::uuid() . '.webp';

        // Redimensionnement
        $avatarImage = Image::read($file)->cover(150, 150)->toWebp(80);
        $largeImage  = Image::read($file)->scale(width: 800)->toWebp(85);

        // Chemins de stockage
        $avatarPath = "photos/avatars/{$filename}";
        $largePath  = "photos/large/{$filename}";

        // Enregistrement sur le disque configuré (Local ou Cloud)
        Storage::disk()->put($avatarPath, (string) $avatarImage);
        Storage::disk()->put($largePath, (string) $largeImage);

        return [
            'avatar_path' => $avatarPath,
            'photo_path'  => $largePath,
        ];
    }

    private function deleteUserPhotos(User $user): void
    {
        if ($user->avatar_path && Storage::disk()->exists($user->avatar_path)) {
            Storage::disk()->delete($user->avatar_path);
        }

        if ($user->photo_path && Storage::disk()->exists($user->photo_path)) {
            Storage::disk()->delete($user->photo_path);
        }
    }
}
