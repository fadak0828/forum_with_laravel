<?php

namespace App\Http\Middleware;

use Closure;

class AuthorOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();
        $model = '\\App\\' . ucfirst($param);
        $modelId = $request->route(str_plural($param));

        if (! $model::whereId($modelId)->whereAuthorId($user->id)->exists()) {
            flash()->error(trans('errors.forbidden') . ' : ' . trans('errors.forbidden_description'));
            return back();
        }

        return $next($request);
    }
}
