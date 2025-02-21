<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="margin: 0; padding: 0; font-family: system-ui, -apple-system, sans-serif; line-height: 1.5; color: #1a1a1a; background-color: #f9fafb;">
    <div style="max-width: 600px; margin: 2rem auto; padding: 2rem; background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center; margin-bottom: 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h1 style="color: #0f172a; font-size: 1.5rem; margin: 1rem auto; text-align: center; width: 100%;">Vérification de votre email</h1>
        </div>

        <div style="background-color: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <p style="color: #1a1a1a; margin-bottom: 1rem;">Bonjour {{ $notifiable->pseudo }},</p>
            
            <p style="color: #1a1a1a; margin-bottom: 1.5rem;">Merci de vous être inscrit ! Pour finaliser votre inscription et accéder à toutes les fonctionnalités, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous :</p>

            <div style="text-align: center; margin: 2rem 0;">
                <a href="{{ $url }}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #0f172a; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; text-align: center;">Vérifier mon email</a>
            </div>

            <p style="font-size: 0.875rem; color: #64748b; margin-top: 1.5rem;">
                Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien dans votre navigateur :<br>
                <a href="{{ $url }}" style="color: #2563eb; word-break: break-word; display: inline-block; margin-top: 0.5rem;">{{ $url }}</a>
            </p>

            <p style="color: #1a1a1a; margin-top: 1.5rem;">Ce lien est valable pendant 24 heures.</p>

            <p style="font-size: 0.875rem; color: #64748b; margin-top: 1.5rem;">
                Si vous rencontrez des problèmes, contactez notre support.
            </p>
        </div>

        <div style="text-align: center; font-size: 0.875rem; color: #64748b; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
            <p>Si vous n'avez pas créé de compte, aucune action n'est requise.</p>
            <p>&copy; {{ date('Y') }} VotreApp. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
