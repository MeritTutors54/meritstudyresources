<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\DownloadHistory;
use App\Models\OrderItems;
use App\Models\Subscription;
use App\Models\Team;
use App\Operations\Frontend\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(): View
    {
        $warning = '';

        $user = User::query()->where('id', Auth::id())->first();

        if ($user->type == UserType::SCHOOL->value && empty($user->team_id)) {
            $warning = "Please complete your profile first.";
        }

        $count['subscriptions'] = Subscription::query()
            ->where('stripe_status', 'active')
            ->whereNull('ends_at')
            ->where('user_id', $user->id)->count();

        $count['book_orders'] = OrderItems::query()
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum('quantity');

        $count['downloads'] = DownloadHistory::query()
            ->where('user_id', $user->id)->count();

        return view('frontend.dashboard.home')
            ->with([
                'count' => $count,
                'warning' => $warning,
                'user' => $user,
            ]);
    }

    public function history(): View
    {
        $user = Auth::user();

        if ($user->type == UserType::SCHOOL->value) {
            $downloads = $user->getSchoolDownloadHistory();
        } else {
            $downloads = $user->downloadHistories;
        }

        return view('frontend.dashboard.download-history')
            ->with([
                'downloads' => $downloads,
            ]);
    }

    // User profile
    public function profile()
    {
        $user = Auth::user();

        app(PermissionRegistrar::class)->setPermissionsTeamId($user->team_id);

        return view('frontend.dashboard.profile');
    }

    public function profileUpdate(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'post_code' => 'required|string|max:5',
            'address' => 'nullable|string|max:255',
        ]);

        // Attempt to update the user data
        $update = User::query()
            ->where('id', Auth::user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'post_code' => $request->post_code,
                'bio' => $request->bio,
            ]);

        // Check if the update was successful
        if ($update) {
            $notification = [
                'msg' => 'Profile Update successful',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'msg' => 'Profile Update failed',
                'alert-type' => 'error'
            ];
        }

        return to_route('user.edit.profile')
            ->with($notification['alert-type'], $notification['msg']);
    }


    public function profilePasswordUpdate(Request $request)
    {
        // Validate the request data
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:3|same:password_confirmation',
        ]);

        // Check if the current password matches the user's actual password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = [
                'message' => 'The current password is incorrect.',
                'alert-type' => 'error'
            ];

            $tab = 2;

            return to_route('user.edit.profile', ['tab' => $tab])
                ->with($notification['alert-type'], $notification['message']);
        }

        // Update the password
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Notification message
        $notification = [
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        ];

        Auth::logout();

        return redirect('/login');
    }

    // Purchase History
    public function purchaseHistory()
    {
        return view('frontend.dashboard.purchase-history');
    }

    // wishlist
    public function wishList()
    {
        return view('frontend.dashboard.wishlist');
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();

        $team = $user->getCurrentTeam;

        $tab = $request->get('tab', 1);

        return view('frontend.dashboard.edit-profile')
            ->with([
                'team' => $team,
                'tab' => $tab,
            ]);
    }

    public function subscriptionList(Request $request): View
    {
        $subscriptions = Subscription::query()
            ->with('plan')
            ->where('user_id', Auth::id())
            ->get()->map(function ($subscription) {
                $timestamp = $subscription->asStripeSubscription()->current_period_end;
                $subscription->next_billing_date = Carbon::createFromTimeStamp($timestamp)->toFormattedDateString();

                return $subscription;
            });

        return view('frontend.dashboard.subscription-list')
            ->with([
                'subscriptions' => $subscriptions
            ]);
    }

    public function updateTeam(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
        ]);

        $team = Team::updateOrCreate(
            ['name' => $request->team_name],
            [
                'guard_name' => 'web',
            ]
        );

        $user = Auth::user();
        UserActivity::assignRole($user, $team);

        $user->team_id = $team->id;
        $user->save();

        $tab = 3;

        return to_route('user.edit.profile', ['tab' => $tab])
            ->with('success', 'Team updated successfully for this school.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
