<?php
// app/Core/Mail.php
// Envio de e-mail via SMTP (PHPMailer). Configuração no .env: MAIL_HOST, MAIL_PORT,
// MAIL_USER, MAIL_PASS, MAIL_FROM (opcional, padrão = MAIL_USER), MAIL_FROM_NAME.
//
//   (new Mail())->send($email, 'Assunto', Mail::template('Título', '<p>Conteúdo</p>'), $nome);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class Mail
{
    /** Envia; retorna false (e registra no log) se falhar. Nunca lança exceção. */
    public function send(string $para, string $assunto, string $html, string $paraNome = ''): bool
    {
        if (!class_exists(PHPMailer::class)) {
            error_log('PHPMailer não instalado. Rode: composer install');
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = App::get('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = App::get('MAIL_USER', '');
            $mail->Password = App::get('MAIL_PASS', '');
            $mail->Port = (int) App::get('MAIL_PORT', 587);
            $mail->SMTPSecure = $mail->Port === 465 ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->CharSet = 'UTF-8';
            $mail->Timeout = 15;

            $mail->setFrom(App::get('MAIL_FROM', $mail->Username), App::get('MAIL_FROM_NAME', App::getName()));
            $mail->addAddress($para, $paraNome);

            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body = $html;
            $mail->AltBody = trim(html_entity_decode(strip_tags(str_replace(['<br>', '</p>'], "\n", $html)), ENT_QUOTES, 'UTF-8'));

            return $mail->send();
        } catch (MailException $e) {
            error_log('Erro ao enviar e-mail para ' . $para . ': ' . $mail->ErrorInfo);
            return false;
        }
    }

    /** Alias mantido por compatibilidade. */
    public function enviar($email, $nome, $assunto, $mensagem): bool
    {
        return $this->send($email, $assunto, $mensagem, $nome);
    }

    /**
     * Layout padrão de e-mail. $conteudoHtml deve ter dados do usuário já escapados com e().
     * $botao opcional: ['url' => '...', 'texto' => '...']
     */
    public static function template(string $titulo, string $conteudoHtml, ?array $botao = null): string
    {
        $app = e(App::getName());
        $botaoHtml = '';
        if ($botao) {
            $url = e($botao['url']);
            $botaoHtml = "<p style='text-align:center;margin:28px 0'>
                <a href='{$url}' style='display:inline-block;padding:14px 32px;background:#10b981;color:#ffffff;text-decoration:none;border-radius:8px;font-weight:700'>" . e($botao['texto']) . "</a></p>
                <p style='font-size:13px;color:#64748b'>Se o botão não funcionar, copie e cole no navegador:<br><span style='word-break:break-all'>{$url}</span></p>";
        }

        return "<!DOCTYPE html><html><body style='margin:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;padding:32px 12px'>
            <div style='max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;padding:36px;color:#334155;line-height:1.7'>
                <h1 style='margin:0 0 24px;text-align:center;color:#062c21;font-size:24px'>{$app}</h1>
                <h2 style='font-size:20px;color:#0f172a'>" . e($titulo) . "</h2>
                {$conteudoHtml}
                {$botaoHtml}
                <p style='margin-top:32px;padding-top:16px;border-top:1px solid #e2e8f0;text-align:center;font-size:12px;color:#94a3b8'>&copy; " . date('Y') . " {$app}</p>
            </div></body></html>";
    }

    public function sendResetPassword(string $email, string $nome, string $token): bool
    {
        $html = self::template(
            'Redefinição de senha',
            '<p>Olá, <strong>' . e($nome) . '</strong>.</p>
             <p>Recebemos uma solicitação para redefinir sua senha. Clique no botão abaixo. <strong>O link vale por 1 hora</strong> e só pode ser usado uma vez.</p>
             <p>Se você não pediu isso, ignore este e-mail: sua senha continua a mesma.</p>',
            ['url' => App::getUrl() . '/auth/redefinir?token=' . $token, 'texto' => 'Redefinir senha']
        );
        return $this->send($email, 'Redefinição de senha - ' . App::getName(), $html, $nome);
    }

    public function sendVerificacao(string $email, string $nome, string $token): bool
    {
        $html = self::template(
            'Confirme seu e-mail',
            '<p>Olá, <strong>' . e($nome) . '</strong>!</p>
             <p>Para ativar sua conta no ' . e(App::getName()) . ', confirme seu endereço de e-mail.</p>
             <p>Se você não criou esta conta, ignore este e-mail.</p>',
            ['url' => App::getUrl() . '/auth/verificar?token=' . $token, 'texto' => 'Confirmar e-mail']
        );
        return $this->send($email, 'Confirme seu e-mail - ' . App::getName(), $html, $nome);
    }

    /** Conta criada por um administrador: o usuário define a própria senha pelo link. */
    public function sendBoasVindas(string $email, string $nome, string $tokenDefinirSenha): bool
    {
        $html = self::template(
            'Sua conta foi criada',
            '<p>Olá, <strong>' . e($nome) . '</strong>!</p>
             <p>Uma conta foi criada para você no ' . e(App::getName()) . ' com o e-mail <strong>' . e($email) . '</strong>.</p>
             <p>Clique no botão para definir sua senha. <strong>O link vale por 48 horas.</strong> Depois disso, use "Esqueci minha senha" na tela de login.</p>',
            ['url' => App::getUrl() . '/auth/redefinir?token=' . $tokenDefinirSenha, 'texto' => 'Definir minha senha']
        );
        return $this->send($email, 'Bem-vindo ao ' . App::getName(), $html, $nome);
    }
}
