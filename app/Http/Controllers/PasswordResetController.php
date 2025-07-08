<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('site.password.reset');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.exists' => 'Este email não está cadastrado em nossa base.',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // Gerar token único
            $token = Str::random(60);
            
            // Salvar token no banco
            \DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            // Gerar link de reset
            $resetLink = url('/password/reset/' . $token);
            
            // Enviar email usando as configurações do Gmail
            try {
                Mail::send('emails.password-reset', [
                    'user' => $user,
                    'resetLink' => $resetLink
                ], function ($message) use ($user) {
                    $message->to($user->email, $user->name)
                            ->subject('Redefinição de Senha - Sistema Estante');
                });
                
                return redirect()->back()->with('success', 'Link de redefinição enviado para seu email!');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['email' => 'Erro ao enviar email. Tente novamente.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Email não encontrado.']);
    }

    public function showResetPasswordForm($token)
    {
        $reset = \DB::table('password_resets')->where('token', $token)->first();
        
        if (!$reset) {
            return redirect()->route('login')->with('error', 'Token inválido ou expirado.');
        }

        return view('site.password.confirm', ['token' => $token, 'email' => $reset->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $reset = \DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return redirect()->back()->withErrors(['email' => 'Token inválido ou expirado.']);
        }

        // Atualizar senha
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Remover token usado
        \DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Senha alterada com sucesso!');
    }
} 