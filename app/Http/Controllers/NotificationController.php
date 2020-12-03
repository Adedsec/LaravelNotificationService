<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Jobs\SendSms;
use App\Services\Notification\Constants\EmailTypes;
use App\Services\Notification\Exceptions\UserDoesNotHaveNumber;
use App\Services\Notification\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * show send email forms
     */

    public function email()
    {
        $users = User::all();
        $emailTypes = EmailTypes::toString();
        return view('notification.send-email', compact('users', 'emailTypes'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'user' => 'integer | exists:users,id',
            'email_type' => 'integer'
        ]);

        try {
            $mailable = EmailTypes::toMail($request->get('email_type'));
            SendEmail::dispatch(User::find($request->get('user')), new $mailable);
            return redirect()->back()->with('success', __('notification.email_sent_successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', __('notification.email_has_problem'));
        }

    }

    public function sms()
    {
        $users = User::all();
        return view('notification.send-sms', compact('users'));
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'user' => 'integer | exists:users,id',
            'text' => 'string | max:256'
        ]);

        try {
            SendSms::dispatch(User::fnd($request->user), $request->text);
            return $this->redirectBack('success', __('notification.sms_sent_successfully'));
        } catch (UserDoesNotHaveNumber $e) {
            return $this->redirectBack('failed', __('notification.user_does_not_have_number'));
        } catch (\Exception $e) {
            return $this->redirectBack('failed', __('notification.sms_has_problem'));
        }
    }

    private function redirectBack(string $type, string $text)
    {
        return redirect()->back()->with($type, $text);
    }
}
