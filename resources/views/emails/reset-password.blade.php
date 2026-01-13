<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сброс пароля</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600px" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 40px;">
                    <tr>
                        <td style="text-align: center; padding-bottom: 30px;">
                            <h1 style="color: #333333; font-size: 24px; margin: 0;">Сброс пароля</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #666666; font-size: 16px; line-height: 24px; padding-bottom: 20px;">
                            Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding: 30px 0;">
                            <a href="{{ $url }}" style="display: inline-block; background-color: #007bff; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; font-weight: bold;">Сбросить пароль</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #666666; font-size: 14px; line-height: 20px; padding-top: 20px; border-top: 1px solid #eeeeee;">
                            Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо. Ссылка для сброса пароля действительна в течение 60 минут.
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #999999; font-size: 12px; line-height: 18px; padding-top: 20px; text-align: center;">
                            Если кнопка не работает, скопируйте и вставьте следующую ссылку в браузер:<br>
                            <a href="{{ $url }}" style="ecolor: #007bff; word-break: break-all;">{{ $url }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
