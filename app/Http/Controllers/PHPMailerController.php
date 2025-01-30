<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PHPMailerController extends Controller
{
    public function sendOTP(Request $request)

    {
        $mail = new PHPMailer(true);
        try {
            $request->validate([
                'email' => 'required|email',
                // 'subject' => 'required',
                // 'body' => 'required',
            ]);

            if (!$this->checkEmail($request->email)) {
                return response()->json([
                    'status' => "error",
                    'message' => "Email does not exist.",
                ], 400);
            }

            $otp = $this->generateOTP();


            /* Email SMTP Settings */

            $mail->SMTPDebug = 0;
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->email);
            $mail->isHTML(true);
            $mail->Subject = "OTP Verification";
            $mail->Body    = "Your OTP is: " . $otp;

            if (!$mail->send()) {
                return response()->json([
                    'status' => "error",
                    'message' => "Email could not be sent.",
                ], 400);
            } else {
                User::where('email', $request->email)->update(['otp' => $otp]);
                return response()->json([
                    'status' => "success",
                    'message' => "Email has been sent successfully",
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => "Internal Server Error",
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|numeric|digits:6',
            ]);

            if (!$this->checkEmail($request->email)) {
                return response()->json([
                    'status' => "error",
                    'message' => "Email does not exist.",
                ], 400);
            }

            $user = User::where('email', $request->email)->first();
            if ($user->otp == $request->otp) {
                User::where('email', $request->email)->update(['otp' => null]);
                return response()->json([
                    'status' => "success",
                    'message' => "OTP verified successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => "Invalid OTP",
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "error",
                'message' => "Internal Server Error",
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    private function generateOTP()
    {
        return rand(100000, 999999);
    }

    private function checkEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
