namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EnvoyerAccesUtilisateur extends Notification
{
    use Queueable;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Accès à l\'application SGAE')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre compte a été créé avec succès.')
            ->line('Voici vos identifiants pour accéder à l\'application :')
            ->line('🔐 Email : ' . $notifiable->email)
            ->line('🔑 Mot de passe : ' . $this->password)
            ->action('Accéder à l\'application', url('https://sgae-1.onrender.com/'))
            ->line('Merci d\'utiliser notre application !');
    }
}
