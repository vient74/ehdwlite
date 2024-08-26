<?php 

namespace App\Http\Middleware;

use Closure;

class ForcePort3000
{
    public function handle($request, Closure $next)
    {
        if ($request->getPort() !== 3000) {
            return redirect()->to('https://dev-ehdw.kemendesa.go.id:3000' . $request->getRequestUri());
        }

        return $next($request);
    }
}
