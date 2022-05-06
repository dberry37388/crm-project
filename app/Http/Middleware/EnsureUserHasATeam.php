<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasATeam
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->isMemberOfATeam()) {
            return redirect()->route('teams.create');
        }

        $this->ensureUserHasCurrentTeamSet();

        return $next($request);
    }

    protected function ensureUserHasCurrentTeamSet(): void
    {
        if (is_null(auth()->user()->current_team_id)) {
            $user = Auth::user();
            $user->current_team_id = $user->allTeams()->first()->id;
            $user->save();
        }
    }
}
