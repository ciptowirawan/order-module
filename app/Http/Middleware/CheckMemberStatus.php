<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CheckMemberStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->intended('/login');
        }

        $today = Carbon::now();
        $memberOverIn = Carbon::parse($user->member_over_in);
        $daysRemaining = $today->diffInDays($memberOverIn, false);

        if (!$user->member_over_in) {
            // Membership is over
            $virtualAccount = $user->virtual_account ?? 'N/A';
            Alert::html('Membership is not yet active', "
                Your membership is inactive. Please activate it by transferring to this Virtual Account:<br>
                <strong id='virtualAccount'>{$virtualAccount}</strong><br>
                <button onclick='copyVirtualAccount()' class='btn btn-primary mt-2'>Copy Virtual Account</button>
                <script>
                function copyVirtualAccount() {
                    var virtualAccount = document.getElementById('virtualAccount');
                    navigator.clipboard.writeText(virtualAccount.textContent)
                        .then(() => alert('Virtual Account copied to clipboard!'));
                }
                </script>
            ", 'warning')->persistent(true, false);
            
            return redirect('/dashboard');
        }

        $virtualAccount = $user->virtual_account ?? 'N/A';
        if ($daysRemaining < 0) {
            // Membership is over
            User::where('id', $user->id)->update([
                "registrant_tag" => "INACTIVE"
            ]);

            echo "<script>
                window.copyVirtualAccount = function() {
                    var virtualAccount = document.getElementById('virtualAccount');
                    navigator.clipboard.writeText(virtualAccount.textContent)
                        .then(() => alert('Virtual Account copied to clipboard!'));
                }
            </script>";

            // Then, use the Alert::html method
            Alert::html('Membership Expired', "
                Your membership has expired. Please renew by transferring to this Virtual Account:<br>
                <div class='d-flex justify-content-center'>
                <div class='mt-4 border border-dark img-fluid w-50'>
                <strong id='virtualAccount'>{$virtualAccount}</strong><br>
                <button onclick='window.copyVirtualAccount()' class='btn btn-secondary my-2'>Copy to clipboard</button>
                </div>
                </div>
            ", 'warning')->persistent(true, false);
            
            return redirect('/dashboard');
        } elseif (in_array($daysRemaining, [30, 60, 90, 120])) {
        
            echo "<script>
                window.copyVirtualAccount = function() {
                    var virtualAccount = document.getElementById('virtualAccount');
                    navigator.clipboard.writeText(virtualAccount.textContent)
                        .then(() => alert('Virtual Account copied to clipboard!'));
                }
            </script>";

            // Then, use the Alert::html method
            Alert::html('Membership Expiring Soon', "
                Your membership will expire in {$daysRemaining} days. Please renew by transferring to this Virtual Account:<br>
                <div class='d-flex justify-content-center'>
                <div class='mt-4 border border-dark img-fluid w-50'>
                <strong id='virtualAccount'>{$virtualAccount}</strong><br>
                <button onclick='window.copyVirtualAccount()' class='btn btn-secondary my-2'>Copy to clipboard</button>
                </div>
                </div>
            ", 'warning')->persistent(true, false);
            
            // Alert::warning('Membership Expiring Soon', "Your membership will expire in {$daysRemaining} days. ");
        }

        return $next($request);
    }
}
