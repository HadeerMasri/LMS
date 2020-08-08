<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;



use App\Notifications\UserRegisteredNotification;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        $country = Country::where('country_code', $input['country'])->first();
        $membershipCountryType = MembershipCountryType::where('country_id', $country->id)->first();

        if (empty($membershipCountryType)) {
            $membershipCountryType = MembershipCountryType::where('country_id', '0')->first();
        }

        $membership_id = UserInfo::whereRaw('substr(membership_id, 1, 2) = ?', array($membershipCountryType->prefix))
            ->orderByRaw('substr(user_info.membership_id,3,5) desc')
            ->first();;

        $num = 1;
        if (!empty($membership_id)) {
            $num = (substr($membership_id->membership_id, 2, 5) + 1);
        }
        $str_length = 3;

        // hardcoded left padding if number < $str_length
        $str = substr("0000{$num}", -$str_length);


        $userInfo = new UserInfo();
        $userInfo->status = '0';
        if ($request->input('roles')['0'] == 'member') {
            $userInfo->membership_id = $membershipCountryType->prefix . $str;
        } else {
            $userInfo->membership_id = '';
        }
        $userInfo->form_step = 0;
        $userInfo->user_id = $user->id;
        $userInfo->country_id = $country->id;
        $userInfo->save();

        $user->notify(new UserRegisteredNotification($user));

        return redirect()->route('manage.users.index')
            ->with('success', 'User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $areas = Area::pluck('area', 'id');
        $targetGroups = TargetGroups::pluck('name_ar', 'id');
        $legalEntities = LegalEntity::pluck('name_ar', 'id')->all();
        $activity_types = ActivityType::get();
        $scopeTypes = ScopeType::Sort()->pluck('name_ar', 'id');

        return view('admin.users.show', compact('user', 'legalEntities', 'areas', 'targetGroups', 'activity_types','scopeTypes'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();


        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->has('password')) {
            $this->handleData($id);
        }

        if (isset($request->reject)) {

            $user = UserInfo::where('user_id', $id)->first();
            $user->notes = $request->notes;
            $user->status = '2';
            $user->save();
            $_user = User::where('id', $user->user_id)->firstOrFail();
            Mail::to($_user->email)->send(new Reject($_user));
            return redirect()->route('manage.users.index')
                ->with('success', 'تم رفض العضوية');
        }
        if (isset($request->approve)) {

            $user = UserInfo::where('user_id', $id)->first();
            $user->notes = $request->notes;
            $user->status = '1';
            $user->save();


            $_user = User::where('id', $user->user_id)->firstOrFail();
            Mail::to($_user->email)->send(new Approve($_user));
            return redirect()->route('manage.users.index')
                ->with('success', 'تم اعتماد العضو بنجاح');
        }
        if (isset($request->saveWithoutApprove)) {
            return redirect()->route('manage.users.index')
                ->with('success', 'تم حفظ البيانات بنجاح');
        }
        if (isset($request->forceApprove)) {
            $user = UserInfo::where('user_id', $id)->first();
            $user->notes = $request->notes;
            $user->status = '1';
            $user->save();
            $_user = User::where('id', $user->user_id)->firstOrFail();
            Mail::to($_user->email)->send(new Approve($_user));
            return redirect()->route('manage.users.index')
                ->with('success', 'تم اعتماد العضو بنجاح');
        }
        if (isset($request->forceSaveWithoutApprove)) {
            $user = UserInfo::where('user_id', $id)->first();
            $user->notes = $request->notes;
            $user->status = '0';
            $user->save();
            return redirect()->route('manage.users.index')
                ->with('success', 'تم حفظ بيانات العضو بنجاح');
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:password_confirmation',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();


        $user->assignRole($request->input('roles'));


        $country = Country::where('country_code', $input['country'])->first();
        $membershipCountryType = MembershipCountryType::where('country_id', $country->id)->first();

        if (empty($membershipCountryType)) {
            $membershipCountryType = MembershipCountryType::where('country_id', '0')->first();
        }

        $membership_id = UserInfo::whereRaw('substr(membership_id, 1, 2) = ?', array($membershipCountryType->prefix))
            ->orderByRaw('substr(user_info.membership_id,3,5) desc')
            ->first();;

        $num = 1;
        if (!empty($membership_id)) {
            $num = (substr($membership_id->membership_id, 2, 5) + 1);
        }
        $str_length = 3;

        // hardcoded left padding if number < $str_length
        $str = substr("0000{$num}", -$str_length);

        $userInfo = UserInfo::where('user_id', $id)->first();


        if ($request->input('roles')['0'] == 'member') {
            if ($userInfo->membership_id == '') {
                $userInfo->membership_id = $membershipCountryType->prefix . $str;
            } elseif (substr($userInfo->membership_id, 0, 2) != $membershipCountryType->prefix) {
                $userInfo->membership_id = $membershipCountryType->prefix . $str;
            }

        } else {
            $userInfo->membership_id = '';
        }
        $userInfo->country_id = $country->id;

        $userInfo->save();


        return redirect()->route('manage.users.index')
            ->with('success', 'User updated successfully');
    }

    public function handleData($id)
    {
        $input = Input::all();
        $user = user::find($id);

        if (!empty($input['main_activity'])) {
            $mainActivities = $this->getActivity($input['main_activity']);
            $user->activity()->wherePivot('activity_type', 'main')->detach();
            $user->activity()->attach($mainActivities, ['activity_type' => 'main']); // insert sub activities
        }

        if (!empty($input['sub_activity'])) {
            $subActivities = $this->getActivity($input['sub_activity']);
            $user->activity()->wherePivot('activity_type', 'sub')->detach();
            $user->activity()->attach($subActivities, ['activity_type' => 'sub']); // insert sub activities
        }

        if (isset($input['target_groups']) && count($input['target_groups']) > 0) {
            $user->target_groups()->sync($input['target_groups']);
        }

        // User::where('email', $userEmail)->first();
        $expiry_date = Carbon::createFromFormat('d/m/Y', $input['expiry_date']);

        $userInfo = UserInfo::where('user_id', $id)->first();
        $userInfo->city = $input['city'];
        $userInfo->address = $input['address'];
        $userInfo->legal_entity_id = $input['legal_entity_id'] ?? null;
        $userInfo->scope_type_id = $input['scope_type_id'] ?? null;

        $userInfo->phone = $input['phone'];
        $userInfo->phone_number = $input['phone_number'];
        $userInfo->other_branches = $input['other_branches'] ?? null;
        $userInfo->org_review = $input['org_review'];

        $userInfo->national_address = $input['national_address'];
        $userInfo->fax = $input['fax'];
        $userInfo->mailbox = $input['mailbox'];
        $userInfo->zip_code = $input['zip_code'];
        if ($userInfo->status != 1) {
            $userInfo->registry = $input['registry'];
        }
        if (isset($input['area_id'])) {
            $userInfo->area_id = $input['area_id'];
        }

        $userInfo->issued_by = $input['issued_by'];
        $userInfo->authority_activity = $input['authority_activity'] ?? null;
        $userInfo->expiry_date = $expiry_date->toDateString();
        if (Input::hasFile('file')) {
            if (!empty(Input::file('file'))) {
                $userInfo->file = $this->saveFiles(Input::file('file'), 'registry');
            }
        }
        if (Input::hasFile('logo')) {
            if (!empty(Input::file('logo'))) {
                $userInfo->logo = $this->saveFiles(Input::file('logo'), 'logos');
            }
        }
        // $userInfo->file = $this->saveFiles(Input::file('file'),'registry') ;

        $userInfo->save();

        $coordinator = Coordinator::where('user_id', $id)->first();
        if (empty($coordinator)) {
            $coordinator = new Coordinator();
            $coordinator->user_id = $user->id;
        }
        $coordinator->name = $input['comp_name'];
        $coordinator->job_title = $input['job_title'];
        $coordinator->email = $input['comp_email'];
        $coordinator->phone = $input['mob'];
        if (Input::hasFile('coordinator_file')) {
            if (!empty(Input::file('coordinator_file'))) {
                $coordinator->file = $this->saveFiles(Input::file('coordinator_file'), 'coordinator');
            }
        }
        $coordinator->save();

        $branches = $input['branch'];


        if (!empty($branches)) {
            if (!is_null(collect($branches['name'])->first())) {
                Branch::where('user_id', $id)->delete();
                if ($input['other_branches'] == 1) {
                    for ($i = 0; $i < count($branches['name']); $i++) {
                        $branch = new Branch();
                        $branch->user_id = $id;
                        $branch->name = $branches['name'][$i];
                        $branch->city = $branches['city'][$i];
                        $branch->save();
                    }
                }
            }

        }


        return true;
    }

    public function getActivity($activities)
    {
        $mainActivity = array();
        $count_id = count($activities['id']);
        for ($i = 0; $i < $count_id; $i++) {
            if (!preg_match('/[^A-Za-z0-9]/', $activities['id'][$i])) {
                $activity = Activity::updateOrCreate(
                    ['name' => $activities['id'][$i], 'description' => $activities['description'][$i], 'language' => 'en']
                );

                $mainActivity[] = $activity->id;
            } else {
                $activity = Activity::updateOrCreate(
                    ['name' => $activities['id'][$i], 'description' => $activities['description'][$i], 'language' => 'ar']
                );
                $mainActivity[] = $activity->id;
            }

        }

        return $mainActivity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('manage.users.index')
            ->with('success', 'User deleted successfully');
    }

}
