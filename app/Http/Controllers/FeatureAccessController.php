<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeatureAccessController extends Controller
{
    protected function getMembership()
    {
        $member = auth()->user()->member;
        return $member ? $member->membership : null;
    }

    protected function getStatusMessage($membership)
    {
        if (! $membership) {
            return 'You do not have a membership yet. Apply for a plan to unlock premium features.';
        }

        if (! $membership->isActiveWithValidity()) {
            if ($membership->isExpired()) {
                return 'Your membership has expired. Renew your plan to regain access.';
            }

            return 'Your membership is not active yet. Please wait for admin approval.';
        }

        return null;
    }

    public function trainerBooking(Request $request)
    {
        $membership = $this->getMembership();
        $statusMessage = $this->getStatusMessage($membership);
        $allowed = $membership && $membership->isActiveWithValidity() && $membership->canBookTrainers();

        return view('trainer-booking', [
            'membership' => $membership,
            'allowed' => $allowed,
            'statusMessage' => $statusMessage,
        ]);
    }

    public function groupClasses(Request $request)
    {
        $membership = $this->getMembership();
        $statusMessage = $this->getStatusMessage($membership);
        $allowed = $membership && $membership->isActiveWithValidity() && $membership->canAccessGroupClasses();

        return view('group-classes', [
            'membership' => $membership,
            'allowed' => $allowed,
            'statusMessage' => $statusMessage,
        ]);
    }
}
