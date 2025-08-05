<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\WebAccounts;

class SecurityQuestionController extends Controller
{
    public function showSetupForm()
    {
        $user = Auth::user();

        $account = WebAccounts::where('account_id', $user->id)->first();
        if (!$account->confirmed) {
            return back()->with('error', 'Your account is not confirmed. Please confirm your account before enabling Security Questions.');
        }

        $hasSecurityQuestions = DB::table('security_questions')
            ->where('account_id', $user->id)
            ->exists();

        if ($hasSecurityQuestions) {
            return redirect()->route('account.manage.index')
                ->with('info', 'You have already set up your security questions.');
        }

        return view('account.manage.security-questions.index');
    }

    public function saveSecurityQuestions(Request $request)
    {
        $user = Auth::user();
        $questionKeys = array_keys(config('security.questions'));

        $rules = [
            'question_1' => ['required', 'integer', 'in:' . implode(',', $questionKeys)],
            'answer_1' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z\s]+$/'],
            'question_2' => ['required', 'integer', 'in:' . implode(',', $questionKeys)],
            'answer_2' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z\s]+$/'],
            'question_3' => ['required', 'integer', 'in:' . implode(',', $questionKeys)],
            'answer_3' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z\s]+$/'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            $questions = [
                $request->input('question_1'),
                $request->input('question_2'),
                $request->input('question_3'),
            ];

            if (count($questions) !== count(array_unique($questions))) {
                $validator->errors()->add('question_1', 'Each security question must be unique.');
                $validator->errors()->add('question_2', 'Each security question must be unique.');
                $validator->errors()->add('question_3', 'Each security question must be unique.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $sanitizeAnswer = fn($answer) => preg_replace('/[^a-zA-Z\s]/', '', $answer);

        DB::table('security_questions')->updateOrInsert(
            ['account_id' => $user->id],
            [
                'question_1' => $request->input('question_1'),
                'answer_1' => $sanitizeAnswer($request->input('answer_1')),
                'question_2' => $request->input('question_2'),
                'answer_2' => $sanitizeAnswer($request->input('answer_2')),
                'question_3' => $request->input('question_3'),
                'answer_3' => $sanitizeAnswer($request->input('answer_3')),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()->route('account.manage.index')->with('success', 'Security questions saved successfully.');
    }



}
